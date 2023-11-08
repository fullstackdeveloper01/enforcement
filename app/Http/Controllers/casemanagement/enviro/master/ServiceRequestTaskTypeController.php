<?php

namespace App\Http\Controllers\casemanagement\enviro\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\casemanagement\enviro\master\ServiceRequestTaskType;
use App\Http\Resources\casemanagement\enviro\master\ServiceRequestTaskTypeResource;

class ServiceRequestTaskTypeController extends Controller
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
        $sites = $request->get('sites');
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('currentPage', 1);
        $data = ServiceRequestTaskType::when($searchQuery , function ($query) use ($searchQuery ) {
            $query->where(function($query) use ($searchQuery) {
             $query->where('task_type_name', 'LIKE', '%' . $searchQuery  . '%');
            });
        })
        ->when(isset($status), function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->when(isset($sites), function ($query) use ($sites) {
            $query->where('site_id', $sites);
        })
        ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'data' => ServiceRequestTaskTypeResource::collection($data),
            'pagination' => [
                'currentPage' => $data->currentPage(),
                'perPage' => $data->perPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
            ],
            ]);
    }


    public function tasklistbysite($id){
        $data = ServiceRequestTaskType::where('site_id',$id)->get();
        return response()->json([
            'data' => $data,
            'success' => true
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
        $validatedData = $request->validate([
            'site_id' => 'required',
            'task_type_name' => 'required|max:255'
        ]);

        $data = ServiceRequestTaskType::create($validatedData);

        return response()->json(['message' => 'Service Request Task Type has been added successfully'], 200);
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
        $item = ServiceRequestTaskType::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'site_id' => 'required',
            'task_type_name' => 'required|max:255'
        ]);

        $item->site_id = $validatedData['site_id'];
        $item->task_type_name = $validatedData['task_type_name'];
        $item->save();

        return response()->json(['message' => 'Service Request Task Type has been updated successfully'], 200);
    }

    /**
     * Update the specified status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $item = ServiceRequestTaskType::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $item->status = $validatedData['status'];
        $item->save();

        return response()->json(['message' => 'Service Request Task Type Status has been updated successfully'], 200);
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
}
