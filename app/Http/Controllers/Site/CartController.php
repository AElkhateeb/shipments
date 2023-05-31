<?php

namespace App\Http\Controllers\Site;

use App\Models\Shipment;
use App\Http\Requests;
//use App\Basket\Basket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Cart\StoreCart;
use App\Http\Requests\Site\Cart\UpdateCart;
//use App\Exceptions\QuantityExceededException;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Cart;
use App\Models\Place;
use App\Models\Road;
use App\Models\SiteOption;
use App\Models\PaymentMethod;

class CartController extends Controller
{
     /**
     * Store a newly created resource in storage.
     *
     * @param StoreCart $request
     * @return array|RedirectResponse|Redirector
     */
    public function add(StoreCart $request){
         $sanitized = $request->getSanitized();
          Cart::Add($sanitized);
          return view('front.miniCart',['count'=>Cart::count()]);
    }
    public function summary () {
        $paymentMethod=PaymentMethod::where('enabled',1)->get();
        $paymentMethod->makeHidden(['created_at','updated_at','resource_url']);
        $data=['paymentMethod'=>$paymentMethod];
        return view('front.cart-total',compact('data'));
    }
    public function index(){
         $placeF = Place::has('start')->get();
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
       ];
          return view('front.shipping',compact('data'));
    }
    public function remove($rowId){
          Cart::remove($rowId);
          return view('front.shipment-table');
    }
    public function update(UpdateCart $request){
        $sanitized = $request->getSanitized();
        Cart::update($request->rowId,$sanitized);
        return view('front.shipment-table');
    }

}