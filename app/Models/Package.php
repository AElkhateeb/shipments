<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;

class Package extends Model
{
use HasTranslations;
    protected $fillable = [
        'name',
        'long',
        'limited',
        'shipment_count',
        'price',
        'weight_default',
        'weight_fee',
        'road',
        'road_sale',
        'pickup',
        'pickup_fee',
        'todoor',
        'todoor_fee',
        'express',
        'express_fee',
        'breakable',
        'breakable_fee',
        'is_published',
        'for_stuff',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    // these attributes are translatable
    public $translatable = [
        'name',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/packages/'.$this->getKey());
    }
}
