<tbody>
	<tr style="background: #e61a4a;">
		<th <?= (App::currentLocale()=='en')? '': 'class="arabic"'?>><i class="fa fa-truck"></i> {{__('front.shipment.table')}}</th>
		<th></th>
	</tr> 
	@if(Cart::count()>0)
	 @foreach(Cart::content() as $shipp)
		<!-- Item #1 -->
		<tr>
			<td class="property-container">
				<div class="title ">
					<h4><a href="#">{{$shipp->name}}</a></h4>
					
						<input type="hidden" id="id-{{$shipp->rowId}}" value="{{$shipp->id}}">
						<span  style="color:#fff">
							 <div class="row <?= (App::currentLocale()=='en')? '': 'arabic'?>">
								 <div  class="col-md-4" style="color:#fff">
								 	<label style="color:#fff" class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">{{ __('front.shipment.price')}}: </label> 
								 	<label style="color:#fff" class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">
								 	{{$shipp->options->shipp_cost}} {{ __('front.shipment.caruncy')}}</label>
								 </div>
								 <div  class="col-md-4" >
								 	<label style="color:#fff" class=" col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">{{ __('front.shipment.express')}}</label>
			                        <label class="col-md-6 switch"><input id="express-{{$shipp->rowId}}" class="calc-check" type="checkbox"
			                        	<?= ($shipp->options->express=='true')?'checked':'' ?>
			                        	> <span class="rounds slide-check"></span></label>
			                        </div>
			                     <div class="col-md-4" > 
			                        <label  style="color:#fff" class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">{{ __('front.shipment.pickup')}}</label>
			                        <label class="col-md-6 switch"><input id="pickup-{{$shipp->rowId}}" class="calc-check" type="checkbox"
			                        	<?= ($shipp->options->pickup=='true')?'checked':'' ?>
			                        	> <span class="rounds slide-check"></span></label>
								</div> 
							</div> 
						</span> 
						<span  style="color:#fff">
							 <div class="row <?= (App::currentLocale()=='en')? '': 'arabic'?>">
								 <div  class="col-md-4" style="color:#fff">
								 	<label style="color:#fff" class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">
								 	{{ __('front.shipment.weight')}} :</label>
								 	<label style="color:#fff" class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">
								  <input type="number" min="1" style="width:50px" id="weight-{{$shipp->rowId}}" max="15" value="{{$shipp->weight}}">
								  {{ __('front.shipment.kg')}}</label>
								   </div>
								 <div  class="col-md-4" >
								 	<label style="color:#fff" class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">{{ __('front.shipment.todoor')}}</label>
			                        <label class="col-md-6 switch"><input id="todoor-{{$shipp->rowId}}" class="calc-check" type="checkbox"
			                        	<?= ($shipp->options->todoor=='true')?'checked':'' ?>
			                        	> <span class="rounds slide-check"></span></label>
			                        </div>
			                     <div class="col-md-4" > 
			                        <label  style="color:#fff" class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">{{ __('front.shipment.breakable')}}</label>
			                        <label class="col-md-6 switch"><input id="breakable-{{$shipp->rowId}}" class="calc-check" type="checkbox"
			                        	<?= ($shipp->options->breakable=='true')?'checked':'' ?>
			                        	> <span class="rounds slide-check"></span></label>
								</div> 
							</div> 
						</span>
						 <div class="row <?= (App::currentLocale()=='en')? '': 'arabic'?>" style="display: flex;">
						 	<div  class="col-md-4" >
						 		<label  style="color:#fff" class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">{{ __('front.shipment.summary.total')}}</label>
								 <span class="table-property-price col-md-6 ">
								 	{{$shipp->qty}} <i class="ti-close"></i>  {{$shipp->price}}  {{ __('front.shipment.caruncy')}}
								 </span>
							</div>
							  <div  class="col-md-4" >
							  	 <label  style="color:#fff" class="col-md-6 <?= (App::currentLocale()=='en')? '': 'arab'?>">{{ __('front.shipment.qty')}}</label>
							 	<input type="number" style="width:50px" min="1" id="qty-{{$shipp->rowId}}" value="{{$shipp->qty}}">
							 </div>
							  <div  class="col-md-4" >
							 	<input type="submit" id="{{$shipp->rowId}}" class="shipp-update col-md-12" value="{{ __('front.shipment.btn.update')}}">
							 </div>
						 </div>	
					
					 

				</div>
			</td>
			<td class="action"> <a href="#" data-link="{{route('site.cart.remove',['rowId'=>$shipp->rowId])}}" class="delete remove-item"><i class="ti-close"></i> {{ __('front.shipment.btn.delete')}}</a> </td>
		</tr> 
	 @endforeach
	@endif 
</tbody>
