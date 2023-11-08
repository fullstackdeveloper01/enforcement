<?php

namespace App\Http\Controllers\casemanagement\enviro\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\casemanagement\enviro\master\Legislation;
use App\Http\Resources\casemanagement\enviro\master\LegislationResource;

class LegislationController extends Controller
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
        $language = $request->get('language');
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('currentPage', 1);
        $data = Legislation::when($searchQuery , function ($query) use ($searchQuery ) {
            $query->where(function($query) use ($searchQuery) {
             $query->where('title', 'LIKE', '%' . $searchQuery  . '%')
                ->orWhere('legislation', 'LIKE', '%' . $searchQuery  . '%');
            });
        })
        ->when(isset($language), function ($query) use ($language) {
            $query->where('language', $language);
        })
        ->when(isset($status), function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'data' => LegislationResource::collection($data),
            'pagination' => [
                'currentPage' => $data->currentPage(),
                'perPage' => $data->perPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
            ],
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
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'legislation' => 'required|max:255',
            'language' => 'required|max:255',
            'offenceSpecificText' => 'required|max:255',
        ]);

        $data = Legislation::create($validatedData);

        return response()->json(['message' => 'Legislation has been added successfully'], 200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Legislation::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'legislation' => 'required|max:255',
            'language' => 'required|max:255',
            'offenceSpecificText' => 'required|max:255',
        ]);

        $item->title = $validatedData['title'];
        $item->legislation = $validatedData['legislation'];
        $item->language = $validatedData['language'];
        $item->offenceSpecificText = $validatedData['offenceSpecificText'];
        $item->save();

        return response()->json(['message' => 'Legislation has been updated successfully'], 200);
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
        $item = Legislation::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $item->status = $validatedData['status'];
        $item->save();

        return response()->json(['message' => 'Legislation Status has been updated successfully'], 200);
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
