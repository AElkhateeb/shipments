<div class="col-lg-12 col-md-12 col-sm-12">
	<h3>{{ __('Your Order')}}</h3> </div>
<div class="col-lg-12 col-md-12 col-sm-12">
	<div class="product-wrap">
		<ul> @if(Cart::count()>0) @foreach(Cart::content() as $shipp)
			<li><strong>{{$shipp->name}}</strong>${{$shipp->subtotal}}</li> @endforeach @endif
			<li><strong>Total</strong>$ {{Cart::priceTotal()}}</li>
		</ul>
	</div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12">
	<div class="pay-wrap">
		<div class="pay-wrap-content">
			<div class="pw-content-detail">
				<div class="pw-first-content">
					<h4>{{__("Your Features")}}</h4> </div>
				<ul class="pw-features"> 
					@foreach($data['paymentMethod'] as $paymentMethod )
						@if($paymentMethod->enabled)
							<li>
								<input id="{{$paymentMethod->name}}" class="checkbox-custom" name="plan" type="radio" value="{{$paymentMethod->slug}}">
								<label for="{{$paymentMethod->name}}" class="checkbox-custom-label">{{$paymentMethod->name}}</label>
							</li>
						 @endif
					@endforeach
				</ul>
			</div>
			<div class="pw-btn-wrap"> <a href="#" class="btn btn-payment">{{ __("Proceed Payment") }}</a> </div>
		</div>
	</div>
</div>