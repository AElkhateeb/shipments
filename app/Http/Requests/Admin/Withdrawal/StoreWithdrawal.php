<?php

namespace App\Http\Requests\Admin\Withdrawal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreWithdrawal extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.withdrawal.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'price' => ['required', 'numeric'],
            'reason_type' => ['required', 'string'],
            'reason_id' => ['required', 'string'],
            'made_type' => ['required', 'string'],
            'made_id' => ['required', 'string'],
            'in_out' => ['required', 'boolean'],
            'enabled' => ['required', 'boolean'],
            'from' => ['required', 'integer'],
            'to' => ['required', 'integer'],
            'payment_method' => ['required', 'integer'],

        ];
    }

    /**
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
    public function getFromId(){
        if ($this->has('from')){
            return $this->get('from')['id'];
        }
        return null;
    }
    public function getToId(){
        if ($this->has('to')){
            return $this->get('to')['id'];
        }
        return null;
    }
    public function getPaymentMethodId(){
        if ($this->has('paymentMethod')){
            return $this->get('paymentMethod')['id'];
        }
        return null;
    }
}
