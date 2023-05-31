<?php

namespace App\Http\Requests\Site\Checkout;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\PaymentMethod;
use Auth;

class StoreCheckoutAccount extends FormRequest
{
   
    public $payment;
    //public $option;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'plan' => ['string'],
            'location'=>[
                'state' => ['required', 'string'],
                'city' => ['required', 'string'],
                'street' => ['required', 'boolean'],
                'location' => ['required', 'boolean'],
                'lat' => ['required', 'integer'],
                'lng' => ['required', 'integer'],
            ],
            'location-id' => ['required'],

        ];
    }

    public function getPayment(){
        if ($this->has('plan')){
           // return $this->get('road')['id'];
          return  PaymentMethod::where('slug',$this->get('plan'))->first();
        }
        return null;
    }
    public function getUser(){
        return Auth::guard(config('account-auth.defaults.guard'))->user(config('account-auth.defaults.guard'))->id;
    }
    
    /**
    * Modify input data
    *
    * @return array
    */

    public function getSanitized(): array
    {
        $sanitized = $this->validated();
        $this->payment=$this->getPayment();
        $sanitized['location']['for_id'] = $this->getUser();
        $sanitized['location']['for_type'] = 'App\Models\Users\AccountAdmin';
        //Add your code for manipulation with request data here

        return $sanitized;
    }



}
