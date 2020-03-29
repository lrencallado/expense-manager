<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\User;
use App\Role;
use stdClass;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    
        $roles = Role::pluck('name','id');
        return view('user')->with(['data'=>$roles]);
    }

    public function read(Request $request)
    {
        $users = User::all();
        //return response()->json($users);
        //return UserResource::collection($users);
        return response(new UserResource($users));

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users'
        ]);
        
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make('admin123'),
        ]);

        $user->roles()->attach(Role::where('name', 'user')->first());

        return $user;
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role_id' => 'required'
        ]);

        $user->roles()->sync([$request['role_id']]);

        $user->update($request->all());

        return ['message' => 'User info has been updated'];
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach(); 
        $user->delete();
        
        return ['message' => 'User has been deleted'];
    }

    public function account()
    {
        return view('account');
    }

    public function updatePW(Request $request)
    {
        $getUser = Auth::user();
        $user = User::findOrFail($getUser->id);
        
        $this->validate($request,[
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'

        ]);

        //$input = $request->all();
        $input['password'] = Hash::make($request['new_password']);

        $user->update($input);

    }
}
