<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class Shipment extends Model
{
    protected $fillable = [
        'pkg_num',
        'road_id',
        'place_from_id',
        'branch_from_id',
        'place_to_id',
        'branch_to_id',
        'weight',
        'pickup',
        'todoor',
        'express',
        'breakable',
        'shipper_type',
        'receiver_type',
        'shipper_id',
        'receiver_id',
        'status',
        'published_at',
        'end_at',
        'shipp_price',
        'shipp_cost',
        'shipp_sale',
        'shipp_total',
        'payment_method_id',

    ];


    protected $dates = [
        'published_at',
        'end_at',
        'created_at',
        'updated_at',

    ];

    protected $appends = [
        'resource_url',
        'account_url',
        'shipper_url',
        'employee_url',
        'manger_url',
        'agent_url',
        'ceo_url',
    ];

    /* ************************ ACCESSOR ************************* */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $shiperType=str_replace("App\Models\Users\\",'',$model->shipper_type);
            $typePerfix=str_replace("Brackets\AdminAuth\Models\\",'',$shiperType);
            $tP=mb_substr($shiperType, 0, 2);
            $prefix='#SH'.$tP.str_pad($model->shipper_id, 5, "0", STR_PAD_LEFT).str_pad($model->road_id, 3, "0", STR_PAD_LEFT).str_pad($model->payment_method_id, 3, "0", STR_PAD_LEFT).date('ymd');
            $model->pkg_num = IdGenerator::generate(['table' => 'shipments','field'=>'pkg_num', 'length' => 6, 'prefix' =>$prefix,"reset_on_prefix_change"=>true]);
        });
    }
    public function getResourceUrlAttribute()
    {
        return url('/admin/shipments/'.$this->getKey());
    }
    public function getAccountUrlAttribute()
    {
        return url('/account/shipments/'.$this->getKey());
    }
    public function getShipperUrlAttribute()
    {
        return url('/shipper/shipments/'.$this->getKey());
    }
    public function getEmployeeUrlAttribute()
    {
        return url('/employee/shipments/'.$this->getKey());
    }
    public function getMangerUrlAttribute()
    {
        return url('/manger/shipments/'.$this->getKey());
    }
    public function getAgentUrlAttribute()
    {
        return url('/agent/shipments/'.$this->getKey());
    }
    public function getCeoUrlAttribute()
    {
        return url('/ceo/shipments/'.$this->getKey());
    }
    /* ************************ references ************************* */
    /* ************************ many to one ************************* */
    public function road() {
        return $this->belongsTo('App\Models\Road','road_id');
    }
    public function placeFrom() {
        return $this->belongsTo('App\Models\Place','place_from_id');
    }
    public function branchFrom() {
        return $this->belongsTo('App\Models\Branch','branch_from_id');
    }
    public function placeTo() {
        return $this->belongsTo('App\Models\Place','place_to_id');
    }
    public function branchTo() {
        return $this->belongsTo('App\Models\Branch','branch_to_id');
    }
    public function receiver() {
        return $this->belongsTo('App\Models\Receiver','receiver_id');
    }
    public function paymentMethod() {
        return $this->belongsTo('App\Models\PaymentMethod','payment_method_id');
    }
    /* ************************ morph ************************* */
    public function shipper()
    {
        return $this->morphTo('shipper');
    }
    public function shipping()
    {
        return $this->morphOne('App\Models\Withdrawal','reason');
    }
    /* ************************ one to many ************************* */
    public function movements()
    {
        return $this->hasMany('App\Models\Movements','shipment_id');
    }
    /* ************************ many to many ************************* */
    public function movementMethods() {
        return $this -> belongsToMany('App\Models\MovementMethod','movements','movement_method_id','shipment_id','id','id');
    }
    public function movementParents() {
        return $this -> belongsToMany('App\Models\MovementMethod','movements','method_parent_id','shipment_id','id','id');

    }
}
