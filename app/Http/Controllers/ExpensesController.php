<?php

namespace App\Http\Controllers;

use App\ExpenseCat;
use App\Expenses;
use App\Http\Resources\ExpensesResource;
use Illuminate\Http\Request;
use App\User;
use Auth;

class ExpensesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    
        $expenseCat = ExpenseCat::pluck('name','id');
        return view('expenses')->with(['data'=>$expenseCat]);
    }

    public function read(Request $request)
    {
        $expenses = Expenses::all();
        //return response()->json($users);
        //return UserResource::collection($users);
        return response(new ExpensesResource($expenses));

    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $expenseCat = ExpenseCat::findOrFail($request['category_id']);
        $this->validate($request,[
            'category_id' => 'required',
            'amount' => 'required',
            'entry_date' => 'required'
        ]);
        $expense = Expenses::create([
            'user_id' => $user->id,
            'category_id' => $request['category_id'],
            'category_name' => $expenseCat->name,
            'amount' => $request['amount'],
            'entry_date' => $request['entry_date']
        ]);

        //$data = Expenses::create($input);

        return $expense;
    }

    public function update(Request $request, $id)
    {
        $expense = Expenses::findOrFail($id);
        $expenseCat = ExpenseCat::findOrFail($request['category_id']);
        $this->validate($request,[
            'category_id' => 'required',
            'amount' => 'required',
            'entry_date' => 'required'
        ]);
        $input = $request->all();
        $input['category_name'] = $expenseCat->name;

        $expense->update($input);

        return ['message' => 'Expense info has been updated'];
    }

    public function destroy($id)
    {
        $expense = Expenses::findOrFail($id);
        //$user->roles()->detach(); 
        $expense->delete();
        
        return ['message' => 'Expense has been deleted'];
    }
}
