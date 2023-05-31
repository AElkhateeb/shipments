<?php

namespace App\Http\Requests\Admin\Withdrawal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateWithdrawal extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.withdrawal.edit', $this->withdrawal);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'price' => ['sometimes', 'numeric'],
            'reason_type' => ['sometimes', 'string'],
            'reason_id' => ['sometimes', 'string'],
            'made_type' => ['sometimes', 'string'],
            'made_id' => ['sometimes', 'string'],
            'in_out' => ['sometimes', 'boolean'],
            'enabled' => ['sometimes', 'boolean'],
            'from' => ['sometimes', 'integer'],
            'to' => ['sometimes', 'integer'],
            'payment_method_id' => ['sometimes', 'integer'],

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
