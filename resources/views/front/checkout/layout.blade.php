@extends('layouts.front')
@section('title', 'checkout')
@section('description', 'description')
@section('content')
<section>
   <div class="container">
      <div class="dashboard-wraper">
         <!-- row Start -->
         @if(!Auth::guard(config('account-auth.defaults.guard'))->check())
         <div class="row">
            @include('front.checkout.content.pleaseLogin')
         </div>
         @endif
         <!-- /row -->
         <!-- row Start -->
         <div class="row form-submit">
            <div class="col-lg-8 col-md-8 col-sm-12">
               <!-- row -->
               <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                     <h3>Billing Detail</h3>
                  </div>
                  <form id="checkout-form" method="POST" action="">
                  
                  @if(!Auth::guard(config('account-auth.defaults.guard'))->check())
                     @include('front.checkout.content.signup')
                  @endif
                  @if(Session::get('hasPickup'))
                     @if(Auth::guard(config('account-auth.defaults.guard'))->check())
                      @include('front.checkout.content.locations',['user'=>$data['user']])
                     @else
                        @include('front.checkout.content.location')
                     @endif  
                  @else
                     @include('front.checkout.content.addPickup')
                  @endif 
                     
               </div>
               <!--/row -->
               
            </div>
            <!-- Col-lg 4 -->
            <div class="col-lg-4 col-md-4 col-sm-12" style="color:#fff">
               <div class="col-lg-12 col-md-12 col-sm-12">
                  <h3>{{ __('Your Order')}}</h3>
               </div>
               <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="product-wrap">
                     <ul>
                        @if(Cart::count()>0)
                           @foreach(Cart::content() as $shipp)
                        <li><strong>{{$shipp->name}}</strong>${{$shipp->subtotal}}</li>
                           @endforeach
                        @endif 
                        <li><strong>Total</strong>$ {{Cart::priceTotal()}}</li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="pay-wrap">
                     <div class="pay-wrap-content">
                        <div class="pw-content-detail">
                        <div class="pw-first-content">
                           <h4>{{__("Your Features")}}</h4>
                        </div>
                           <ul class="pw-features">
                              @php $count=0; @endphp
                              @foreach($data['paymentMethod'] as $paymentMethod )
                                 @if($paymentMethod->enabled)
                                    <li>
                                       <input id="{{$paymentMethod->name}}" class="checkbox-custom" name="plan" type="radio" value="{{$paymentMethod->slug}}" <?= ($count==0)? 'checked':'' ?> >
                                       @php $count++; @endphp
                                       <label for="{{$paymentMethod->name}}" class="checkbox-custom-label">{{$paymentMethod->name}}</label>
                                    </li>
                                 @endif   
                              @endforeach
                              
                           </ul>
                        </div>
                        <div class="pw-btn-wrap"> <a href="#" id="account-location" class="btn btn-payment">{{ __("Proceed Payment") }}</a> </div>
                     </div>
                  </form>
                  </div>
               </div>
            </div>
            <!-- /col-lg-4 -->
         </div>
         <!-- /row -->
      </div>
   </div>
</section>
@stop
@section('last-script')
   @if(Session::get('hasPickup'))
      @include('front.checkout.script.location')
      @if(Auth::guard(config('account-auth.defaults.guard'))->check())
         @include('front.checkout.script.locations')
      @endif
   @else
      @if(Auth::guard(config('account-auth.defaults.guard'))->check())
         @include('front.checkout.script.authNoPickup')
      @else
         @include('front.checkout.script.noAuthNoPickup')
      @endif
   @endif
@stop