<?php
use App\Cms_meta;
use Illuminate\Support\Facades\DB;
use App\User;
use App\States;
/*
 * To get dynamic html for the various pages on frontend
 */
function getDynamicContent($cms_id,$meta_key){
    $content = Cms_meta::with('cms_data')->where('cms_id',$cms_id)->where('meta_key',$meta_key)->first();
    $content->meta_value = json_decode($content->meta_value,true);
    return $content;
} 

function getCounties()
{  
    $countries = DB::table("countries")->get();

    return $countries;
}

  // function getAlltaxsforstates() {
		//       $taxNamesAndValues = [];
		// 	  $userDetail = User::find(Auth::user()->id, ['first_name', 'last_name', 'email','stripe_id','id','state','country']);
  //             $taxNamesAndValues['total_percentage'] = 0;
               
		//       if($userDetail->country){
	 //                $canadaStatesTaxs = States::where('country_id',$userDetail->country)->get();
	 //            	foreach ($canadaStatesTaxs as $key => $taxStates) {                		
	 //        		   if($userDetail->state == $taxStates->id && $userDetail->country == $taxStates->country_id ){   
	 //        		      if($taxStates->type){   
	 //                      $taxsTypes = explode(",",$taxStates->type);
	 //                      foreach ($taxsTypes as $key => $taxs) {	                      	
	 //                      	$taxNamesAndValues[$taxs]  = $taxStates->$taxs;                      	                     	 
	 //                      } 
  //                        } 
	 //        		   }       
	        		                 		 
	 //        	   }
	 //        	   $taxsValues = array_values($taxNamesAndValues); 
	 //        	   $total = array_sum( $taxsValues);
	 //        	   $taxNamesAndValues['total_percentage'] = $total;
	 //        	   return $taxNamesAndValues; 
	 //          }else{

	 //          	$taxNamesAndValues['total_percentage'] = 0;
	 //        	   return $taxNamesAndValues; 
	 //          }
	 //    }
