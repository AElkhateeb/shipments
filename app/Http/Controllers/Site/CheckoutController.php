<?php

namespace App\Http\Controllers\Site;

use App\Models\Shipment;
use App\Http\Requests;
//use App\Basket\Basket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Checkout\StoreCheckoutAccountNoPickup;
use App\Http\Requests\Site\Checkout\StoreCheckoutAccount;
use App\Http\Requests\Site\Checkout\UpdateCheckoutAccount;
//use App\Exceptions\QuantityExceededException;
//use Haruncpi\LaravelIdGenerator\IdGenerator;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Cart;
use App\Models\Place;
use App\Models\Road;
use App\Models\SiteOption;
use App\Models\PaymentMethod;
use App\Models\Location;
use App\Models\Users\AccountAdmin;
use Auth;
use Brackets\AdminListing\Facades\AdminListing;

class CheckoutController extends Controller
{

    
     /**
     * Store a newly created resource in storage.
     *
     * @param StoreCart $request
     * @return array|RedirectResponse|Redirector
     */
    /*public function add(StoreCart $request){
         $sanitized = $request->getSanitized();
          Cart::Add($sanitized);
          return view('front.miniCart',['count'=>Cart::count()]);
    }
    public function summary () {
        $paymentMethod=PaymentMethod::where('enabled',1)->get();
        $paymentMethod->makeHidden(['created_at','updated_at','resource_url']);
        $data=['paymentMethod'=>$paymentMethod];
        return view('front.cart-total',compact('data'));
    }*/
    public function index(){
       /*  $placeF = Place::has('start')->get();
        $placeF->makeHidden(['created_at','updated_at','resource_url']);
        $placeT = Place::has('end')->get();
        $placeT->makeHidden(['created_at','updated_at','resource_url']);
        $road = Road::where('enabled',1) ->get();
        $road->makeHidden(['created_at','updated_at','resource_url','placeFrom']);
        $siteOption = SiteOption::first();
        $siteOption->makeHidden(['created_at','updated_at','resource_url']);
         $data=[
           'placeF'=>$placeF,
           'placeT'=>$placeT,
           'road'=>$road,
           'siteOption'=>$siteOption,
       ];*/
       //return Auth::user()->full_name;
       $paymentMethod=PaymentMethod::where('enabled',1)->get();
        $paymentMethod->makeHidden(['created_at','updated_at','resource_url']);
        if(Auth::guard(config('account-auth.defaults.guard'))->check()){
            $data=[
            'paymentMethod'=>$paymentMethod,
            'user'=>Auth::guard(config('account-auth.defaults.guard'))->user(config('account-auth.defaults.guard'))->with('locations')->first()
        ];
        }else{
            $data=[
            'paymentMethod'=>$paymentMethod,
            
        ];
        }
        
        //Session::put(['hasPickup' => true]);
          //return view('front.shipping',compact('data'));
        $this->hasPickup();
       return view('front.checkout.layout',compact('data'));
    }
    public function accountNoLocation(StoreCheckoutAccountNoPickup $request){
        $checkout= $request->getSanitized();
        //return $checkout['plan'];
        $shippmentSucsses=0;
        if ($checkout['plan']=='cash_on_delevary') {
            foreach($checkout['shipment'] as $shippment){
                $shippmentCheak=Shipment::create($shippment);
                 if(isset($shippmentCheak->id)){
                    $shippments[$shippmentSucsses]=$shippmentCheak;
                    $shippmentSucsses+1;
                    
                    //$shippmentCheak->pkg_num=$shippmentCheak->id
                 }
            }
        }
        return $shippments;
        // $request->getSanitized();

    }
    public function accountLocation(StoreCheckoutAccount $request){
        return $request->getSanitized();
    }
    public function selectLocation($locId){
        $location=Location::find($locId);
        return $location;
    }
    public function addPickup(Request $request){
        if(Auth::guard(config('account-auth.defaults.guard'))->check()){
             $user=Auth::guard(config('account-auth.defaults.guard'))->user(config('account-auth.defaults.guard'))->with('locations')->first();
            if($user->locations->isEmpty()){
                return view('front.checkout.content.location',compact('user'));
            }else{
               return view('front.checkout.content.locations',compact('user')); 
            }
            
          }else{
            return view('front.checkout.content.location');
          }
          
    }
   /* public function update(UpdateCart $request){
        $sanitized = $request->getSanitized();
        Cart::update($request->rowId,$sanitized);
        return view('front.shipment-table');
    }*/
    public function hasPickup(){
        Session::put(['hasPickup' => false]);
        if(Cart::count()>0){
            foreach(Cart::content() as $shipp){
                if($shipp->options->pickup!='false'){
                   Session::put(['hasPickup' => $shipp->options->pickup]); 
                }
            }
        }
     
    }
    public function hasTodoor(){
    
        Session::put(['hasTodoor' => false]);
        if(Cart::count()>0){
            foreach(Cart::content() as $shipp){
                if($shipp->options->todoor!='false'){
                   Session::put(['hasTodoor' => $shipp->options->todoor]); 
                }
            }
        }
     
    }
    public function setPickup(){

    }
}