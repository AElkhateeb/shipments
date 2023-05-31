<div class="col-lg-12 col-md-12">
	<div class="alert alert-success text-center" role="alert"> {{ __("Add pickup to your shipmints ")}} <a id="add-pickup" href="#" data-toggle="collapse" data-target="#location-frm">{{ __("Add Pickup")}}</a> </div>
</div>
<div class="col-lg-12 col-md-12">
	<div id="location-frm" class="collapse">
		
	</div>
</div>
<script >
	$('#add-pickup').on('click',function(e){
      e.preventDefault();
      $.post('{{route("addPickup.checkout")}}',$('#checkout-form').serialize()).done(function(response){
                        $("#location-frm").html(response);
                    });
      })
</script>