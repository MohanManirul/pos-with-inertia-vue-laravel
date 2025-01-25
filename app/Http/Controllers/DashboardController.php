<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboardPage(Request $request){

     $data= [
        'customer'=>Customer::where('user_id','=',$request->header('id'))->count(),
        'category'=>Category::where('user_id','=',$request->header('id'))->count(),
        'products'=>Product::where('user_id','=',$request->header('id'))->count(),
        'invoice'=>Invoice::where('user_id','=',$request->header('id'))->count(),
        'total'=>Invoice::where('user_id','=',$request->header('id'))->sum('total'),
        'collection'=>Invoice::where('user_id','=',$request->header('id'))->sum('payable'),
        'vat'=>Invoice::where('user_id','=',$request->header('id'))->sum('vat')
        ];

        return Inertia::render('Dashboard/DashboardPage',['data'=>$data]);
    }

    public function salePage(Request $request){
        $userId=$request->header('id');
        $customers=Customer::where('user_id','=',$userId)->get();
        $products=Product::where('user_id','=',$userId)->where('unit','>',0)->get();

        return Inertia::render('Sale/SalePage',['customers'=>$customers,'products'=>$products]);
    }
}
