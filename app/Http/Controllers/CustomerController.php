<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{

    public function customerPage(Request $request){
        $userId = $request->header('id');
        $customers = Customer::where('user_id', '=', $userId)->get();
        return Inertia::render('Customer/CustomerPage',['customers' => $customers]);
    }

    public function customerSavePage(Request $request){
        $id=$request->query('id');
        $userId=$request->header('id');
        $customer=Customer::where('user_id','=',$userId)->where('id','=',$id)->first();
        return Inertia::render('Customer/CustomerSavePage',['customer'=>$customer]);
    }
    public function createCustomer(Request $request)
    {
        try {
            $request->validate([
                'name' => 'string|required',
                'email' => 'string|required|unique:users',
                'mobile' => 'string|required',
            ]);
            $userId = $request->header('id');
            $name = $request->input('name');
            $email = $request->input('email');
            $mobile = $request->input('mobile');
            Customer::create(['user_id' => $userId, 'name' => $name, 'email' => $email, 'mobile' => $mobile]);
            return redirect()->route('customerSavePage')->with(['status' => true, 'message' => 'Customer created successfully']);
        } catch (Exception $e) {
            return redirect()->route('customerSavePage')->with(['status' => false, 'message' => 'Customer creation failed']);
        }
    }


    public function updateCustomer(Request $request){
           $request->validate([
               'name' => 'string|required',
               'email' => 'string|required',
               'mobile' => 'string|required',
           ]);
        try{
            $userId=$request->header('id');
            $customerId=$request->input('id');
            Customer::where('id', '=', $customerId)->where('user_id', '=', $userId)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
            ]);

            return redirect()->route('customerSavePage')->with(['status'=>true,'message'=>'Customer updated successfully']);
        }catch(Exception $e){
            return redirect()->route('customerSavePage')->with(['status'=>false,'message'=>'Customer updated fail']);

        }
    }

    public function deleteCustomer(Request $request){
        try{
            $userId=$request->header('id');
            $customerId=$request->query('id');
            Customer::where('id', '=', $customerId)->where('user_id', '=', $userId)->delete();
            return redirect()->route('customerPage')->with(['status' => true, 'message' => 'Customer deleted successfully']);
        }catch(Exception $e){
            return redirect()->route('customerPage')->with(['status' => false, 'message' => 'Customer deletion failed']);
        }

    }

}
