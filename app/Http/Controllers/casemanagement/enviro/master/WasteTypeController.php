<?php

namespace App\Http\Controllers\casemanagement\enviro\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\casemanagement\enviro\master\WasteType;
use App\Http\Resources\casemanagement\enviro\master\WasteTypeResource;

class WasteTypeController extends Controller
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
        $data = WasteType::when($searchQuery , function ($query) use ($searchQuery ) {
            $query->where(function($query) use ($searchQuery) {
             $query->where('waste_type', 'LIKE', '%' . $searchQuery  . '%');
            });
        })
        ->when(isset($status), function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'data' => WasteTypeResource::collection($data),
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
            'waste_type' => 'required|max:255',
        ]);

        $data = WasteType::create($validatedData);

        return response()->json(['message' => 'Waste Type has been added successfully'], 200);
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
        $item = WasteType::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'waste_type' => 'required|max:255',
        ]);

        $item->waste_type = $validatedData['waste_type'];
        $item->save();

        return response()->json(['message' => 'Waste Type has been updated successfully'], 200);
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
        $item = WasteType::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $item->status = $validatedData['status'];
        $item->save();

        return response()->json(['message' => 'Waste Type Status has been updated successfully'], 200);
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
