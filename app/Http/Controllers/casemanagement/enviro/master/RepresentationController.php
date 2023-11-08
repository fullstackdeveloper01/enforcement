<?php

namespace App\Http\Controllers\casemanagement\enviro\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\casemanagement\enviro\master\Representation;
use App\Http\Resources\casemanagement\enviro\master\RepresentationResource;
use App\Models\casemanagement\enviro\Enviro;
use App\Models\Setup\Site;
use Log;
use Mail;
use Zendesk;
use DB;

class RepresentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchQuery  = $request->get('q');
        $status = $request->get('status');
        $lodgeDate = $request->get('lodgeDate');
        $councilId = $request->get('council') ? array_filter($request->get('council')) : [];
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('currentPage', 1);
        $councilList = [];
        $statusCount = [
            'open' => 0,
            'pending' => 0,
            'declined' => 0,
        ];

        $data = Representation::when($searchQuery , function ($query) use ($searchQuery ) {
            $query->where(function($query) use ($searchQuery) {
                $query->where('fpn_number', 'LIKE', '%' . $searchQuery  . '%')             
                ->orwhere('first_name', 'LIKE', '%' . $searchQuery  . '%')             
                ->orwhere('last_name', 'LIKE', '%' . $searchQuery  . '%')               
                ->orwhere('fpn_number', 'LIKE', '%' . $searchQuery  . '%');
            });
        })
        ->orwhereHas('siteData', function($q) use ($searchQuery){
            $q->where('name', 'LIKE', '%' . $searchQuery  . '%');
        })
        ->when(isset($lodgeDate), function ($query) use ($lodgeDate) {
            $query->whereBetween('created_at', explode('to', $lodgeDate));
        })
        ->when(!empty($councilId), function ($query) use ($councilId) {
            $query->whereIn('site_id', $councilId);
        })
        ->when(isset($status), function ($query) use ($status) {
            $query->where('lodged_status', $status);
        });

        $paginateDate = $data->paginate($perPage, ['*'], 'page', $currentPage);
        //Get count
        $data->select( DB::raw('count(lodged_status) as count, lodged_status') );
        $counts = $data->groupBy('lodged_status')->get();
        if (!$counts->isEmpty()) {
            foreach($counts as $count) {
                $statusCount[$count['lodged_status']] = $count['count'];
            }
        }

        //Get all councils
        $sites = Site::select('id', 'name')->get();
        if (!$sites->isEmpty()) {
            foreach($sites as $key => $site) {
                $councilList[$key]['title'] = $site->name;
                $councilList[$key]['value'] = $site->id;
            }
        }

        return response()->json([
            'data' => RepresentationResource::collection($paginateDate),
            'statusCount' => $statusCount,
            'councilList' => $councilList,
            'pagination' => [
                'currentPage' => $paginateDate->currentPage(),
                'perPage' => $paginateDate->perPage(),
                'last_page' => $paginateDate->lastPage(),
                'total' => $paginateDate->total(),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'address_line1' => 'required',
                'town' => 'required',
                'city' => 'required',
                'country' => 'required',
                'post_code' => 'required',
                'email' => 'required|email',
                'confirm_email' => 'required',
                'reason' => 'required',
                'appeal_note' => 'required',
                'accept_statement' =>'accepted',
                'privacy_statement' =>'accepted',
                'upload' => 'nullable|mimes:jpeg,jpg,doc,docx,pdf|max:5120'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ]);
            }
            
            $input = $request->all();
            if ($request->file('upload')) {
                $input['upload']  = uniqid(rand(9999, 999999)).date('dmY').'.'.$request->upload->getClientOriginalExtension();
                $request->upload->move(public_path("/uploads/representation/supportedFile"), $input['upload']);
            }

            //Store in database.
            $response = Representation::create($input);
            if ($response) {
                //Create a new ticket on zendesk.
                $subject = "[FPN: {$response->fpn_number}] - {$response->siteData->name} - {$response->reasonData->reason}";
                $ticketResponse = Zendesk::tickets()->create([
                    'subject' => $subject,
                    'comment' => [
                        'body' => $response->appeal_note
                    ],
                    'requester' => array(
                        'name' => $response->first_name,  
                        'email' => $response->email
                    ),
                    'priority' => 'normal',
                ]);

                if (!empty($ticketResponse)) {
                    $response->ticket_id = $ticketResponse->ticket->id;
                    $response->lodged_status = $ticketResponse->ticket->status;
                    if ($response->save()) {
                        // Update enviro status representation logged.
                        Enviro::where('id', $response->enviro_id)->update([
                            'is_rep_logged' => 1,
                            'fpn_status' => 'rep_logged'
                        ]);
                        
                        return response()->json([
                            'success' => true,
                            'message' => 'Your Representation has been submitted successfully. Thank you.'
                        ]);
                    }
                }
            }        
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function searchFpn(Request $request) 
    {
        if(!isset($request->fpn))
        {
            return response()->json([
                'success' => false,
                'message' => "Please provide a valid FPN Number"
            ]);
        }

        $row = Enviro::where([
            ['fpn_number','=', $request->fpn],
            ['is_rep_logged','=', 0],
            ['is_paid','=', 0]
        ])->first();

        if(!$row)
        {
            return response()->json([
                'success' => false,
                'message' => "Please provide a valid FPN Number"
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $row
        ]);
    }

    public function handleZendeskCallBack(Request $request) 
    {
        try {
            if ($request->isMethod('post')) {
                if (!empty($request->ticket)) {
                    $zendeskRes = $request->ticket;
                    $representation = Representation::where('ticket_id', $zendeskRes['id'])->first();
                    $representation->lodged_status = $zendeskRes['status'];
                    $representation->save();
                } 
            }                   
        } catch (\Throwable $th) {
            Log::info("Something went wrong in zendesk call back response. {$th}");
        }
    }
}
