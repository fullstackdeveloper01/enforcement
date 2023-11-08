<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\AssignedSite;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery  = $request->get('q');
        $status = $request->get('status');
        $role = $request->get('role');
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('currentPage', 1);
        $data = User::when($searchQuery , function ($query) use ($searchQuery ) {
            $query->where(function($query) use ($searchQuery) {
             $query->where('name', 'LIKE', '%' . $searchQuery  . '%')
                ->orWhere('email', 'LIKE', '%' . $searchQuery  . '%');
            });
        })
        ->when(isset($status), function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->when(isset($role), function ($query) use ($role) {
            $query->where('role_id', $role);
        })
        ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
        'data' => UserResource::collection($data),
        'pagination' => [
            'currentPage' => $data->currentPage(),
            'perPage' => $data->perPage(),
            'last_page' => $data->lastPage(),
            'total' => $data->total(),
        ],
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'startDate' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'roleId' => 'required|integer',
            'niNumber' => 'required|string',
            'password' => 'required|string',
            'operatorNumber' => 'required|string',
            'pinNumber' => 'required|string',
        ]);
    
        $user = new User();
        $user->company_id = 1;
        $user->first_name = $validatedData['firstName'];
        $user->last_name = $validatedData['lastName'];
        $user->name = $user->first_name.' '.$user->last_name;
        $user->start_date = $validatedData['startDate'];
        $user->end_date = $validatedData['endDate'] ?? null;
        $user->email = $validatedData['email'];
        $user->role_id = $validatedData['roleId'];
        $user->ni_number = $validatedData['niNumber'];
        $user->password = bcrypt($validatedData['password']);
        $user->operator_number = $validatedData['operatorNumber'];
        $user->pin_number = $validatedData['pinNumber'];
        $user->is_officer = $request['is_officer'];
        $user->save();

        return response()->json(['message' => 'User has been added successfully'], 200);
    }

    public function update(Request $request, $id)
    {

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'startDate' => 'required|date',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'roleId' => 'required|integer',
            'niNumber' => 'required|string',
            'operatorNumber' => [
                'required',
                'string',
                Rule::unique('users', 'operator_number')->ignore($id),
            ],
            'pinNumber' => 'required|string',
        ]);
        $user->first_name = $validatedData['firstName'];
        $user->last_name = $validatedData['lastName'];
        $user->name = $user->first_name.' '.$user->last_name;
        $user->start_date = $validatedData['startDate'];
        $user->end_date = $validatedData['endDate'] ?? null;
        $user->email = $validatedData['email'];
        $user->role_id = $validatedData['roleId'];
        $user->ni_number = $validatedData['niNumber'];
        $user->operator_number = $validatedData['operatorNumber'];
        $user->pin_number = $validatedData['pinNumber'];
        $user->is_officer = $request['is_officer'];
        $user->save();
        
        return response()->json(['message' => 'User has been updated successfully'], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $item = User::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $validatedData = $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $item->status = $validatedData['status'];
        $item->save();

        return response()->json(['message' => 'User Status has been updated successfully'], 200);
    }

    public function show($id)
    {
        $users = User::where('deleted',0)->find($id);
        if(!$users){
            return response()->json([
                'message' => "No data available.",
            ],201);
        }

        return response()->json([
            'message' => "User details.",
            'data' => new UserResource($users)
        ],200);
    }

    public function fetch_officers()
    {
        $users = User::where('is_officer', 1)->get();
        $data = [];
        if(count($users) > 0)
        {
            foreach($users as $user)
            {
                $item = [
                    'id' => $user->id,
                    'name' => $user->name
                ];
                array_push($data, $item);
            }
        }

        return response()->json($data);
    }

    public function fetch_admins()
    {
        $users = User::where('role_id', 1)->get();
        $data = [];
        if(count($users) > 0)
        {
            foreach($users as $user)
            {
                $item = [
                    'id' => $user->id,
                    'name' => $user->name
                ];
                array_push($data, $item);
            }
        }

        return response()->json($data);
    }

    public function fetch_assigned_sites($user_id)
    {

        $sites = AssignedSite::where('user_id', $user_id)->with('site')->orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $sites
        ]);
    }

    public function assign_site(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'site_id' => 'required',
        ]);

        $check = AssignedSite::where('user_id', $request->user_id)->where('site_id', $request->site_id)->first();
        if($check)
        {
            return response()->json([
                'success' => true,
                'message' => 'Site is already assigned to this user'
            ], 400);
        }

        AssignedSite::create([
            'site_id' => $request->site_id,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'You have assigned a new site to this user'
        ], 200);
    }
    
    public function unlink_assigned_site(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'site_id' => 'required',
        ]);
        $data = AssignedSite::find($request->site_id);
        if($data)
        {
            $data->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Site is successfully removed'
        ], 200);
    }
}
