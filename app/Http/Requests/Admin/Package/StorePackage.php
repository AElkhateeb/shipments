<?php

namespace App\Http\Requests\Admin\Package;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StorePackage extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.package.create');
    }

/**
     * Get the validation rules that apply to the requests untranslatable fields.
     *
     * @return array
     */
    public function untranslatableRules(): array {
        return [
            'long' => ['required', 'numeric'],
            'limited' => ['required', 'boolean'],
            'shipment_count' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'weight_default' => ['required', 'numeric'],
            'weight_fee' => ['required', 'numeric'],
            'road' => ['required', 'boolean'],
            'road_sale' => ['required', 'numeric'],
            'pickup' => ['required', 'boolean'],
            'pickup_fee' => ['required', 'numeric'],
            'todoor' => ['required', 'boolean'],
            'todoor_fee' => ['required', 'numeric'],
            'express' => ['required', 'boolean'],
            'express_fee' => ['required', 'numeric'],
            'breakable' => ['required', 'boolean'],
            'breakable_fee' => ['required', 'numeric'],
            'is_published' => ['required', 'boolean'],
            'for_stuff' => ['required', 'boolean'],
            
        ];
    }

    /**
     * Get the validation rules that apply to the requests translatable fields.
     *
     * @return array
     */
    public function translatableRules($locale): array {
        return [
            'name' => ['required', 'string'],
            
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
