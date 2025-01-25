<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function createInvoice(Request $request) {

          DB::beginTransaction();
          try{
            $userId=$request->header('id');
            $data=[
                'user_id'=>$userId,
                'customer_id'=>$request->input('cus_id'),
                'total'=>$request->input('total'),
                'vat'=>$request->input('vat'),
                'payable'=>$request->input('payable'),
                'discount'=>$request->input('discount'),
            ];

            $invoice=Invoice::create($data);

            $products=$request->input('products');
            foreach($products as $product){
                InvoiceProduct::create([
                    'invoice_id'=>$invoice->id,
                    'product_id'=>$product['id'],
                    'user_id'=>$userId,
                    'qty'=>$product['unit'],
                    'sale_price'=>$product['price'],
                    $exitsUnit=Product::where('id','=',$product['id'])->select('unit')->first(),
                    Product::where('id','=',$product['id'])->update(['unit'=>$exitsUnit->unit-$product['unit']])
                ]);
            }
            DB::commit();
            return redirect()->route('salePage')->with(['status'=>true,'message'=>'Invoice created successfully']);
          }catch(Exception $e){
            DB::rollBack();
            return redirect()->route('salePage')->with(['status'=>false,'message'=>'Something went wrong']);

          }
    }

    public function listInvoice(Request $request){

            $userId=$request->header('id');
            $list= Invoice::where('user_id','=',$userId)
            ->with('customer','invoiceProducts.product')->get();

            return Inertia::render('Invoice/InvoiceListPage',['list'=>$list]);


    }

    public function deleteInvoice(Request $request){
        DB::beginTransaction();
        try{
            $userId=$request->header('id');
            $invoiceId=$request->input('id');
            InvoiceProduct::where('invoice_id','=',$invoiceId)->where('user_id','=',$userId)->delete();
            Invoice::where('user_id','=',$userId)->where('id','=',$invoiceId)->delete();
            DB::commit();
            return redirect()->route('listInvoice')->with(['status'=>true,'message'=>'Invoice deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->route('listInvoice')->with(['status'=>false,'message'=>'Something went wrong']);
        }
    }

}
