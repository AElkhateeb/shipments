<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;
use Illuminate\Support\Facades\URL;

class Location extends Model
{
    use HasTranslations;
    protected $fillable = [
        'state',
        'city',
        'street',
        'location',
        'lng',
        'lat',
        'for_type',
        'for_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = [
        'resource_url',
        'state_name',
       'city_name',
    ];

    public $translatable = [
        'state_name',
        'city_name',

    ];
    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/locations/'.$this->getKey());
    }
    public function for()
    {
        return $this->morphTo('for');
    }
    public function getStateNameAttribute()
    {
        $url=public_path('front/js/governorate.json');
        $file = file_get_contents($url);
         $governorateArray = json_decode($file, true);
        $governoratefilter = array_filter($governorateArray);
        $governorate=collect($governoratefilter)->where("id","=",$this->state)->first();
        return   $governorate['governorate_name_'.$this->getLocale()];
     }
     public function getCityNameAttribute()
    {
        $url=public_path('front/js/city.json');
        $file = file_get_contents($url);
         $cityArray = json_decode($file, true);
        $cityfilter = array_filter($cityArray);
         $city=collect($cityfilter)->where("id","=",$this->city)->first();
        return   $city['city_name_'.$this->getLocale()];
     }
}
