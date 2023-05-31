<?php

namespace App\Http\Requests\Site\Shipment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShipment extends FormRequest
{
   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'pkg_num' => ['required', 'integer'],
            'road' => ['required', 'integer'],
            'placeFrom' => ['required', 'integer'],
            'branchFrom' => ['required', 'integer'],
            'placeTo' => ['required', 'integer'],
            'branchTo' => ['required', 'integer'],
            'weight' => ['required', 'numeric'],
            'pickup' => ['required', 'boolean'],
            'todoor' => ['required', 'boolean'],
            'express' => ['required', 'boolean'],
            'breakable' => ['required', 'boolean'],
            'shipper_type' => ['required', 'string'],
            'shipper_id' => ['required', 'string'],
            'receiver_id' => ['nullable', 'integer'],
            'status' => ['required', 'string'],
            'published_at' => ['required', 'date'],
            'end_at' => ['required', 'date'],
            'shipp_price' => ['required', 'string'],
            'shipp_cost' => ['required', 'string'],
            'shipp_sale' => ['required', 'string'],
            'shipp_total' => ['required', 'string'],
            'paymentMethod' => ['nullable', 'integer'],

        ];
    }
   /* public function getRoadId(){
        if ($this->has('road')){
            return $this->get('road')['id'];
        }
        return null;
    }
    public function getPlaceFromId(){
        if ($this->has('placeFrom')){
            return $this->get('placeFrom')['id'];
        }
        return null;
    }
    public function getBranchFromId(){
        if ($this->has('branchFrom')){
            return $this->get('branchFrom')['id'];
        }
        return null;
    }
    public function getPlaceToId(){
        if ($this->has('placeTo')){
            return $this->get('placeTo')['id'];
        }
        return null;
    }
    public function getBranchToId(){
        if ($this->has('branchTo')){
            return $this->get('branchTo')['id'];
        }
        return null;
    }
    public function getPaymentMethodId(){
        if ($this->has('paymentMethod')){
            return $this->get('paymentMethod')['id'];
        }
        return null;
    }
   */ /**
    * Modify input data
    *
    * @return array
    */

    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }



}
