<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&language={{App::getLocale()}}}&callback=int_map" async defer></script>
<script>
   $.getJSON("{{URL::asset('front/js/governorate.json')}}", function(jd) {
       var governorate = jQuery.map( jd, function(a) {

                return {'id': a.id,'text': a.governorate_name_{{App::getLocale()}}} ;
            });
       console.log(governorate);
       $('#state').empty().select2({data: governorate});
    });
   $('#state').on('change',function(){  city_options(); }) ;
   $('#city').on('change',function(){  city_loction(); }) ;

function city_options(){
   $.getJSON("{{URL::asset('front/js/city.json')}}", function(jd) {
      //$.governorate_id[?(@.isbn)]
      var gid=$('#state').val();
       var city = $.map( jd, function(a) {
            if(a.governorate_id==gid){
               return {'id': a.id,'text': a.city_name_{{App::getLocale()}}} ;
            }    
            });
       //console.log(city);
       $("#city").empty().select2({data: city});
    });
   //int_map();
}
function city_loction(){
   $.getJSON("{{URL::asset('front/js/city.json')}}", function(jd) {
   var cid=$('#city').val();
   const loc=$.map( jd, function(a) {
      if(a.id==cid){
            return {'latitude': parseFloat(a.Latitude),'longitude': parseFloat(a.Longitude)}
      }
   });
  mapSet(parseFloat(loc[0].latitude),parseFloat(loc[0].longitude));
  setLocationCoordinates(parseFloat(loc[0].latitude),parseFloat(loc[0].longitude));
  autoucompliteMap(parseFloat(loc[0].latitude),parseFloat(loc[0].longitude));
  

});
}
function int_map(){
city_options();

const autocompletes = [];

const latitude =29.8579396;
const longitude =31.3884671;
mapSet(latitude,longitude);
autoucompliteMap(latitude,longitude);

}
function autoucompliteMap(lat,lng){
var input = document.getElementById('street');
const autocomplete = new google.maps.places.Autocomplete(input);
autocomplete.setComponentRestrictions({'country': 'EG'});
var circle = new google.maps.Circle({
            center: { lat: +parseFloat(lat), lng: +parseFloat(lng)},
            radius: 10
         });
autocomplete.setBounds(circle.getBounds());
//autocomplete.set
google.maps.event.addListener(autocomplete,'place_changed', function () {
   CheangePlaceMarker(autocomplete);
});
}
function CheangePlaceMarker(loc){
    var place = loc.getPlace();
    mapSet(place.geometry.location.lat(),place.geometry.location.lng()); 

}
function mapSet(lat,lng){
   const map = new google.maps.Map(document.getElementById('address-map'), {
            center: { lat: +parseFloat(lat), lng: +parseFloat(lng)},
            zoom: 13
        });
const marker = new google.maps.Marker({
    map: map,
    position: { lat: +parseFloat(lat), lng: +parseFloat(lng)},
    draggable: true
});
   
autoucompliteMap(parseFloat(lat),parseFloat(lng));
   google.maps.event.addListener(marker, 'dragend', function(a) {
    //console.log(a.latLng);
    
    setLocationCoordinates(a.latLng.lat(), a.latLng.lng())
});

}


function setLocationCoordinates(lat, lng) {
   var result=[];
    var geocoder = new google.maps.Geocoder;
//autocomplete.set
    geocoder.geocode({
      'location': { lat: +parseFloat(lat), lng: +parseFloat(lng)}
    }, function(results, status) {
      if (status === 'OK') {
        if (results[0]) {
         $('#street').val(results[0].formatted_address);
          
        } else {
          window.alert('No results found');
        }
      } else {
        window.alert('Geocoder failed due to: ' + status);
      }
   });
    var locLink='https://www.google.com/maps/@'+lat+','+lng;
    $('#location').val(locLink);
    $('#lat').val(lat);
    $('#lng').val(lng);

autoucompliteMap(parseFloat(lat),parseFloat(lng));
}
//city_options();

</script>