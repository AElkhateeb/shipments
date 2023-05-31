<div class="col-lg-6 col-md-6">
	<div class="form-group">
		<input type="hidden" id="location-id" name="location-id" value="new">
		<label>{{ __('government') }}<i class="req">*</i></label>
		<select id="state" name="state" class="form-control">
			<option value="">&nbsp;</option>
		</select>
	</div>
	<div class="alert alert-danger jquery_error_message d-none" id="jquery_error_government"></div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12">
	<div class="form-group">
		<label>{{__('Town/City')}}<i class="req">*</i></label>
		<select id="city" name="city" class="form-control">
			<option value="">&nbsp;</option>
		</select>
	</div>
	<div class="alert alert-danger jquery_error_message d-none" id="jquery_error_city"></div>
</div>
<div class="col-lg-12 col-md-12">
	<div class="form-group">
		<label>{{ __('Street') }}<i class="req">*</i></label>
		<input type="text" id="street" name="street" class="form-control">
		<input type="hidden" id="location" name="location" class="form-control">
		<input type="hidden" id="lat" name="lat" class="form-control">
		<input type="hidden" id="lng" name="lng" class="form-control"> </div>
	<div class="alert alert-danger jquery_error_message d-none" id="jquery_error_street"></div>
	<div class="alert alert-danger jquery_error_message d-none" id="jquery_error_location"></div>
	<div class="alert alert-danger jquery_error_message d-none" id="jquery_error_lat"></div>
	<div class="alert alert-danger jquery_error_message d-none" id="jquery_error_lng"></div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12">
	<div id="address-map-container" style="width:100%;height:400px; ">
		<div style="width: 100%; height: 100%" id="address-map"></div>
	</div>
</div>


