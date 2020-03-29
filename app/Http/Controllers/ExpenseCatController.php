<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExpenseCat;
use App\Http\Resources\ExpenseCatResource;

class ExpenseCatController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->checkRoles('Administrator');
        return view('expensecat');
        
    }

    public function read(Request $request)
    {
        $expenseCat = ExpenseCat::all();
        //return response()->json($users);
        //return UserResource::collection($users);
        return response(new ExpenseCatResource($expenseCat));

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:45|unique:expense_cats',
            'description' => 'required|string|max:255'
        ]);

        $existingColors = ExpenseCat::where('color', '!=', '')->get()->pluck('color')->toArray();
        $hexCode = "#".substr(md5(rand()), 0, 6);

        while(in_array($hexCode, $existingColors)) {
            $hexCode = "#".substr(md5(rand()), 0, 6);
        }

        return ExpenseCat::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'color' => $hexCode,
        ]);
    }

    public function update(Request $request, $id)
    {
        $expenseCat = ExpenseCat::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:255|unique:expense_cats,name,'.$expenseCat->id,
            'description' => 'required|string|max:255'
        ]);

        $expenseCat->update($request->all());

        return ['message' => 'Expense category has been updated'];
    }

    public function destroy($id)
    {
        $expenseCat = ExpenseCat::findOrFail($id);

        $expenseCat->delete();

        return ['message' => 'Expense category has been deleted'];
    }
}
