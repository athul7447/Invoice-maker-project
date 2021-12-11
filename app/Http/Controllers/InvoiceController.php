<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use App\Models\Invoiceitems;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function save_data(Request $request)
    {
        $post=new Invoice();
        $post->name=$request->customer_name;
        $post->email=$request->customer_email;
        $post->subtotal_without_tax=$request->total_tax_amt;
        $post->subtotal=$request->total_amt;
        if($request->discount=="")
        {
            $post->discount=0;
            $post->discount_type="amount";
        }
        else
        {
            $post->discount=$request->discount;
            $post->discount_type=$request->discount_type;
        }

        $post->save();
        $count = count($request->name);
        for ($i=0; $i < $count; $i++) { 
          $task = new Invoiceitems();
          $task->invoice_id = $post->id;
          $task->name = $request->name[$i];
          $task->quantity    = $request->qty[$i];
          $task->unit_prize = $request->unit_prize[$i];
          $task->tax = $request->tax[$i];
          $task->total = $request->tax_prize[$i];
          $task->save();
        }
        $data=Invoice::where('id','=',$post->id)->get();
        $invoicedata=Invoiceitems::where('invoice_id','=',$post->id)->get();
        return view('invoice-view',compact('data','invoicedata'));
       // return back()->with('user_created','User has been created');
    }
}
