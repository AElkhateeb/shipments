<div class="col-lg-12 col-md-12">
	<table class="property-table-wrap responsive-table bkmark">
		<tbody>
			<tr style="background: #e61a4a;">
				<th <?= (App::currentLocale()=='en')? '': 'class="arabic"'?>><i class="fa fa-map-marker"></i> {{__('front.locations.table')}}</th>
				<th></th>
			</tr> 
			<!-- Item #1 -->
			@empty($user->locations)
				<tr>
					<td class="property-container">
						<div class="title">
							<h4>{{ __('you dont have locations yet')}}</h4>
							
						</div>
					 </td>
				</tr>
			@else
				@foreach($user->locations as $location)
					<tr>
						<td class="property-container"> 
							<div class="title">
								<h4><a href="#">{{$location->state_name.' / '.$location->city_name}}</a></h4> <span style="color:#fff" >{{$location->street}}</span></div>
						</td>
						<td class="action"> <a href="#" class="delete select-location" data-url="{{route('selectLocation.checkout',$location->id)}}"><i class="fa fa-map-marker"></i> </a> </td>
					</tr>
				@endforeach
				
			@endempty
			
		</tbody>
	</table>
</div>
<div class="col-lg-12 col-md-12">
	<div class="alert alert-success text-center" role="alert"> {{ __("Add location for pickup")}} <a id="add-location" href="#" data-toggle="collapse" data-target="#location-frm">{{ __("Add location for pickup")}}</a> </div>
</div>
<div class="col-lg-12 col-md-12">
	<div id="location-frm" class="collapse">
		@include('front.checkout.content.location')
	</div>
</div>
