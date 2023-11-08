<?php

namespace App\Http\Controllers\casemanagement\enviro\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\casemanagement\enviro\master\ServiceRequestTaskGroup;
use App\Models\casemanagement\enviro\master\TaskTypeTaskGroupMap;
use App\Http\Resources\casemanagement\enviro\master\ServiceRequestTaskGroupResource;

class ServiceRequestTaskGroupController extends Controller
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
        $data = ServiceRequestTaskGroup::whereHas('taskType',function($query) use ($sites) {
            $query->when(isset($sites), function ($query) use ($sites) {
                $query->where('site_id', $sites);
            });
        })->with('taskType.taskSite')->when($searchQuery , function ($query) use ($searchQuery ) {
            $query->where(function($query) use ($searchQuery) {
             $query->where('task_group_name', 'LIKE', '%' . $searchQuery  . '%');
            });
        })
        ->when(isset($status), function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'data' => ServiceRequestTaskGroupResource::collection($data),
            'pagination' => [
                'currentPage' => $data->currentPage(),
                'perPage' => $data->perPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
            ],
        ]);
    }

    public function list(){
        $data = ServiceRequestTaskGroup::get();
        return response()->json([
            'data' => ServiceRequestTaskGroupResource::collection($data),
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
            'task_type_id' => 'required',
            'task_group_name' => 'required|max:255'
        ]);

        $data = ServiceRequestTaskGroup::create([
            'task_group_name' => $validatedData['task_group_name'],
        ]);

        foreach($validatedData['task_type_id'] as $val){
            TaskTypeTaskGroupMap::create([
                'site_id' => $request->site_id,
                'task_type_id' => $val,
                'task_group_id' => $data->id,
            ]);
        }

        return response()->json(['message' => 'Service Request Task Group has been added successfully'], 200);
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
        $item = ServiceRequestTaskGroup::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $validatedData = $request->validate([
            'site_id' => 'required',
            'task_type_id' => 'required',
            'task_group_name' => 'required|max:255'
        ]);
        
        $item->task_group_name = $validatedData['task_group_name'];
        $item->save();

        TaskTypeTaskGroupMap::where('task_group_id',$item->id)->delete();

        foreach($validatedData['task_type_id'] as $val){
            TaskTypeTaskGroupMap::create([
                'site_id' => $request->site_id,
                'task_type_id' => $val,
                'task_group_id' => $item->id,
            ]);
        }

        return response()->json(['message' => 'Service Request Task Group has been updated successfully'], 200);
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
        $item = ServiceRequestTaskGroup::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $item->status = $validatedData['status'];
        $item->save();

        return response()->json(['message' => 'Service Request Task Group Status has been updated successfully'], 200);
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
