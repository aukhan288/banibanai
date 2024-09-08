<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserSignUpRequest;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    function index(){
        $title='Users';
        $roles = Role::select(['id', 'name'])->get();
        return View('users',compact('title','roles'));
    }
    
    function createUser(Request $request){
        $user=User::create([
            "name" => $request->name,
            "role_id" => 2,
            "email" => $request->email,
            "password" =>Hash::make($request->password)

        ]);
    }

    function userList(Request $request)
    {
        $users = User::with('role')->paginate($request->input('length', 10)); // Default is 10 records per page
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $users->total(),
            'recordsFiltered' => $users->total(),
            'data' => $users->items(),
        ]);
    }
    
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        // Validate and update the user data
        $user->update($request->validated());

        return response()->json(['success' => true, 'message' => 'User updated successfully']);
    }
   
    public function show($id) {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }
}

