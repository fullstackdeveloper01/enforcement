<?php

namespace App\Http\Controllers\casemanagement\enviro\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\casemanagement\enviro\master\ServiceRequestReportedVia;
use App\Http\Resources\casemanagement\enviro\master\ServiceRequestReportedViaResource;

class ServiceRequestReportedViaController extends Controller
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
        $data = ServiceRequestReportedVia::when($searchQuery , function ($query) use ($searchQuery ) {
            $query->where(function($query) use ($searchQuery) {
             $query->where('reported_via', 'LIKE', '%' . $searchQuery  . '%');
            });
        })
        ->when(isset($status), function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'data' => ServiceRequestReportedViaResource::collection($data),
            'pagination' => [
                'currentPage' => $data->currentPage(),
                'perPage' => $data->perPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
            ],
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
            'reported_via' => 'required|max:255'
        ]);

        $data = ServiceRequestReportedVia::create($validatedData);

        return response()->json(['message' => 'Service Request Reported Via has been added successfully'], 200);
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
        $item = ServiceRequestReportedVia::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'reported_via' => 'required|max:255'
        ]);

        $item->reported_via = $validatedData['reported_via'];
        $item->save();

        return response()->json(['message' => 'Service Request Reported Via has been updated successfully'], 200);
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
        $item = ServiceRequestReportedVia::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $item->status = $validatedData['status'];
        $item->save();

        return response()->json(['message' => 'Service Request Reported Via Status has been updated successfully'], 200);
    }

    /**
     * Update the specified Back Office status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateBackOffice(Request $request, $id)
    {
        $item = ServiceRequestReportedVia::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'is_back_office' => 'required|in:0,1',
        ]);

        $item->is_back_office = $validatedData['is_back_office'];
        $item->save();

        return response()->json(['message' => 'Service Request Reported Via Back Office Status has been updated successfully'], 200);
    }

    /**
     * Update the specified Online status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOnline(Request $request, $id)
    {
        $item = ServiceRequestReportedVia::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'is_online' => 'required|in:0,1',
        ]);

        $item->is_online = $validatedData['is_online'];
        $item->save();

        return response()->json(['message' => 'Service Request Reported Via Online Status has been updated successfully'], 200);
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
