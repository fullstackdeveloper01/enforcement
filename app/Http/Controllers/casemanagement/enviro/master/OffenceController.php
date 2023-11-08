<?php

namespace App\Http\Controllers\casemanagement\enviro\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setup\SiteOffence;
use App\Models\casemanagement\enviro\master\Offence;
use App\Models\casemanagement\enviro\master\OffenceGroup;
use App\Http\Resources\casemanagement\enviro\master\OffenceResource;

class OffenceController extends Controller
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
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('currentPage', 1);
        $data = Offence::when($searchQuery , function ($query) use ($searchQuery ) {
            $query->where(function($query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery  . '%')
                    ->orwhere('issueType', 'LIKE', '%' . $searchQuery  . '%');
            });
        })
        ->when(isset($status), function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'data' => OffenceResource::collection($data),
            'pagination' => [
                'currentPage' => $data->currentPage(),
                'perPage' => $data->perPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
            ]
        ]);
    }

    /**
     * Get the single list of offence from id.
     */
    public function show($id)
    {
        $offence = Offence::find($id);
        return response()->json([
            'data' => $offence
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:tbl_master_env_offence',
            'minImageRequired' => 'required|max:100',
            'englishLegislation' => 'required',
            'group' => 'required',
            'maxFine' => 'required',
            'issueType' => 'required',
        ]);

        Offence::create($request->all());
        return response()->json(['message' => 'Offence has been added successfully'], 200);
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
        $offence = Offence::find($id);
        if (!$offence) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $request->validate([
            'name' => 'required|max:100|unique:tbl_master_env_offence,name,'.$id,
            'minImageRequired' => 'required|max:100',
            'englishLegislation' => 'required',
            'group' => 'required',
            'maxFine' => 'required',
            'issueType' => 'required',
        ]);

        $offence->fill($request->all());
        $offence->save();

        return response()->json(['message' => 'Offence has been updated successfully'], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $offence = Offence::find($id);
        if (!$offence) {
            return response()->json(['message' => 'Offence not found'], 404);
        }
        $validatedData = $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $offence->status = $validatedData['status'];
        $offence->save();

        return response()->json(['message' => 'Offence status has been updated successfully'], 200);
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

    public function fetch_offence_groups()
    {
        $offences = OffenceGroup::all();
        $data = [];
        if(count($offences) > 0)
        {
            foreach($offences as $obj)
            {
                $item = [
                    'id' => $obj->id,
                    'name' => $obj->englishName
                ];

                array_push($data, $item);
            }
        }

        return response()->json($data);
    }

    public function fetch_offence_types($site_id, $id)
    {
        $site_offences = SiteOffence::where('offence_group_id', $id)->where('site_id', $site_id)->where('status', 1)->get();
        $data = [];
        if(count($site_offences) > 0)
        {
            foreach($site_offences as $obj)
            {
                $offence_id = $obj->offence_id;
                $offence = Offence::find($offence_id);
                $item = [
                    'id' => $offence->id,
                    'name' => $offence->name
                ];

                array_push($data, $item);
            }
        }

        return response()->json($data);
    }
}
