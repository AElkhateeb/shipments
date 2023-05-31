<?php

namespace App\Http\Requests\Admin\ShipmentItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateShipmentItem extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.shipment-item.edit', $this->shipmentItem);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'shipment_id' => ['sometimes', 'integer'],
            'name' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'enabled' => ['sometimes', 'boolean'],
            'price' => ['sometimes', 'numeric'],
            
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
}
