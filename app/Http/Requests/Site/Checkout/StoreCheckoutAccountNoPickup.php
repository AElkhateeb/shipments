<?php

namespace App\Http\Requests\Site\Checkout;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\PaymentMethod;
use App\Models\Road;
use Auth;
use Cart;

class StoreCheckoutAccountNoPickup extends FormRequest
{
   
    public $payment;
    public $road;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'plan' => ['string'],
            'shipment' => ['array','nullable'],

        ];
    }

    public function getPayment(){
        if ($this->has('plan')){
          return  PaymentMethod::where('slug',$this->get('plan'))->first();
        }
        return null;
    }
    
    public function getRoad($id){
          return  Road::where('id',$id)->with(['placeFrom','placeTo'])->first();
    }
    public function getUser(){
        return Auth::guard(config('account-auth.defaults.guard'))->user(config('account-auth.defaults.guard'))->id;
    }


    
    /**
    * Modify input data
    *
    * @return array
    */

    public function getSanitized(): array
    {
        $sanitized = $this->validated();
        //functions
        $this->payment=$this->getPayment();
        $shipmentCount=0;
        foreach(Cart::content() as $shipp){

        $this->road=$this->getRoad($shipp->id);
            for($qty=0;$qty<$shipp->qty;$qty++){
$sanitized['shipment'][$shipmentCount]['road_id']=$this->road->id;
$sanitized['shipment'][$shipmentCount]['place_from_id']=$this->road->placeFrom->id;
$sanitized['shipment'][$shipmentCount]['branch_from_id']=$this->road->placeFrom->branch_id;
$sanitized['shipment'][$shipmentCount]['place_to_id']=$this->road->placeTo->id;
$sanitized['shipment'][$shipmentCount]['branch_to_id']=$this->road->placeTo->branch_id;
$sanitized['shipment'][$shipmentCount]['weight']=$shipp->weight;
$sanitized['shipment'][$shipmentCount]['pickup']=filter_var($shipp->options->pickup, FILTER_VALIDATE_BOOLEAN);
$sanitized['shipment'][$shipmentCount]['todoor']=filter_var($shipp->options->todoor, FILTER_VALIDATE_BOOLEAN);
$sanitized['shipment'][$shipmentCount]['express']=filter_var($shipp->options->express, FILTER_VALIDATE_BOOLEAN);
$sanitized['shipment'][$shipmentCount]['breakable']=filter_var($shipp->options->breakable, FILTER_VALIDATE_BOOLEAN);
$sanitized['shipment'][$shipmentCount]['shipper_type']='App\Models\Users\AccountAdmin';
$sanitized['shipment'][$shipmentCount]['shipper_id']=$this->getUser();
$sanitized['shipment'][$shipmentCount]['receiver_id']=$this->road->placeTo->branch_id;
$sanitized['shipment'][$shipmentCount]['receiver_type']='App\Models\Branch';
$sanitized['shipment'][$shipmentCount]['status']=0;
$sanitized['shipment'][$shipmentCount]['shipp_price']=$shipp->options->shipp_cost;
$sanitized['shipment'][$shipmentCount]['shipp_cost']=$shipp->price-$shipp->options->shipp_cost;
$sanitized['shipment'][$shipmentCount]['shipp_sale']=0;
$sanitized['shipment'][$shipmentCount]['shipp_total']=$shipp->price;
$sanitized['shipment'][$shipmentCount]['payment_method_id']=$this->payment->id; 
$shipmentCount++;
            }
         
        }
        
        //Add your code for manipulation with request data here

        return $sanitized;//=$this->getRoad(Cart::content()['c89923c0f978cff6c976c7a9f2c2c76b']['id']);
    }



}
