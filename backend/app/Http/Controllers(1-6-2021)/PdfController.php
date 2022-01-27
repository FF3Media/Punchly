<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Order;
use Carbon\Carbon;

class PdfController extends Controller
{
 


   public function create()
    {
    	$data = ['title' => 'Laravel 7 Generate PDF From View Example Tutorial'];
        $pdf = PDF::loadView('Invoices.pdf');  
        return $pdf->download('Invoice.pdf');
    }

        public function pdfdta(Request $request){
			if($request->isMethod('get')){
				if($request->order_id){
				$data = Order::with('user','payment_details','coupon')->where(['id' => $request->order_id])->first();
				$data['subject'] = 'Order Invoice';
				$data['discount'] = '';
					if(isset($data->coupon)){
						if(!empty($data->coupon->percent_off)){
						  $data['discount'] = $data->coupon->percent_off.'%';
						}else{
						  $data['discount'] = '$'.$data->coupon->amount_off;
						}
			       }  
						if($data->amount_after_coupon > 0){
						  $data['total'] = $data->amount_after_coupon;
						}else{
						  $data['total'] = $data->amount;
						}
			          $completed_date = Carbon::createFromFormat('Y-m-d H:i:s', $data['updated_at'])->format('F-d-y');
			          $data = [
				       	        'order_id' => $data['order_unique_id'],
				                'discount'=>$data['discount'] ,
				                'amount'=>$data['amount'],
				                'total'=>$data['total'],
				                'completed_date' => $completed_date,
			                 ]; 
			        $pdf = PDF::loadView('Invoices.pdf',$data);
				   return $pdf->stream('Invoice.pdf');
			         
                }
			} 
     }
}
