<?php

namespace App\Http\Requests\Site\Checkout;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\Road;
use App\Models\SiteOption;

class UpdateCheckoutAccount extends FormRequest
{
    public $road;
    public $option;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'road' => ['required'],
            'rowId' => ['required'],
            //'placeFrom' => ['required', 'integer'],
            //'branchFrom' => ['required', 'integer'],
            //'placeTo' => ['required', 'integer'],
            //'branchTo' => ['required', 'integer'],
            'weight' => ['required', 'numeric'],
            'qty' => ['required', 'numeric'],
            'options'=>[
                'pickup' => ['required', 'boolean'],
                'todoor' => ['required', 'boolean'],
                'express' => ['required', 'boolean'],
                'breakable' => ['required', 'boolean'],
            ],
            // *'shipper_type' => ['required', 'string'],
            // *'shipper_id' => ['required', 'string'],
            //'receiver_id' => ['nullable', 'integer'],
            //'status' => ['required', 'string'],
           // 'published_at' => ['required', 'date'],
           // 'end_at' => ['required', 'date'],
           // 'shipp_price' => ['required', 'string'],
            'shipp_cost' => ['nullable'],
            //'shipp_sale' => ['nullable'],
            'shipp_total' => ['nullable'],
            //'paymentMethod' => ['nullable', 'integer'],

        ];
    }
    public function getOption(){
       return SiteOption::first();
    }
    public function getRoad(){
        if ($this->has('road')){
           // return $this->get('road')['id'];
          return  Road::where('id',$this->get('road'))->first();
        }
        return null;
    }
    public function getRoadName(){
        if ($this->road){
            return $this->road->road;
        }
        return null;
    }
    public function getRoadCost(){
        if ($this->road&&$this->option){
           return $price=$this->road->price;
        }
        return null;
    }
    public function getRoadTotal(){
        if ($this->road&&$this->option){
            $cost=$this->getRoadCost();
            if($this->road->express==1&&$this->option->express==1){
                if($this->get('options')['express']!='false'){
                    $cost=$cost*$this->option->express_fee;
                }
            }
            if($this->option->weight_default<$this->get('weight')){
                //return "55555555555555";
                $extraWeight=$this->get('weight')-$this->option->weight_default;
                $extraPrice=$extraWeight*$this->option->weight_fee;
                $cost=$cost+$extraPrice;
            }
            if($this->road->pickup==1&&$this->option->pickup==1){
                if($this->get('options')['pickup']!='false'){
                    $cost=$cost+$this->option->pickup_fee;
                }
            }
            if($this->road->todoor==1&&$this->option->todoor==1){
                if($this->get('options')['todoor']!='false'){
                    $cost=$cost+$this->option->todoor_fee;
                }
            }
            if($this->road->breakable==1&&$this->option->breakable==1){
                if($this->get('options')['breakable']!='false'){
                    $cost=$cost+$this->option->breakable_fee;
                }
            }
            return $cost;
        }
        return null;
    }
    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {

        $sanitized = $this->validated();
        $this->road=$this->getRoad();
        $this->option=$this->getOption();
        $sanitized['id'] = $this->road->id;
        $sanitized['name'] = $this->getRoadName();
        $sanitized['price'] = $this->getRoadTotal();
        $sanitized['options']['shipp_cost'] = $this->getRoadCost();
        if($this->road->express!=1||$this->option->express!=1){
            $sanitized['options']['express'] ='false';
        }
        if($this->road->pickup!=1||$this->option->pickup!=1){
            $sanitized['options']['pickup'] ='false';
        }
        if($this->road->todoor!=1||$this->option->todoor!=1){
            $sanitized['options']['todoor'] ='false';
        }
        if($this->road->breakable!=1||$this->option->breakable!=1){
            $sanitized['options']['breakable'] ='false';
        }
        //Add your code for manipulation with request data here

        return $sanitized;
    }

}
