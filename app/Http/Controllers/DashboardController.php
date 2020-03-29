<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExpenseCat;
use Auth;
use stdClass;
use DB;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $result = new stdClass;
        $data = [];
        $labels = [];
        $hexCodes = [];
        //$newHex = Common::getRandomHexCode();
        $expenseCat = ExpenseCat::select('name','color')
            ->withCount(['expenses' => function($query) use ($user) {
                $query->select(DB::raw("SUM(amount) as total"));

                // If expense per user matters we can uncomment this line :) --> Elaine
                // if($user->role_id > 1) {
                //     $query->where('user_id', $user->id);
                // }
            }])->get();

        foreach($expenseCat as $category) {
            $data[] = $category->expenses_count;
            $labels[] = $category->name;
            $hexCodes[] = $category->color;
        }
        $result->data = [
            'data' => $data,
            'labels' => $labels,
            'backgroundColor' => $hexCodes,
            'all' => $expenseCat
        ];

        return view('dashboard')->with('result', $result);

    }
}
