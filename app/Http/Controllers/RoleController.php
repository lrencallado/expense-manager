<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Role;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->checkRoles('Administrator');
        return view('role');
        
    }

    public function read(Request $request)
    {
        $roles = Role::all();
        //return response()->json($users);
        //return UserResource::collection($users);
        return response(new RoleResource($roles));

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:45|unique:roles',
            'description' => 'required|string|max:255'
        ]);

        return Role::create([
            'name' => $request['name'],
            'description' => $request['description']
        ]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:255|unique:roles,name,'.$role->id,
            'description' => 'required|string|max:255'
        ]);

        $role->update($request->all());

        return ['message' => 'Role info has been updated'];
    }

    public function destroy($id)
    {
        $user = Role::findOrFail($id);

        $user->delete();

        return ['message' => 'Role has been deleted'];
    }
}
