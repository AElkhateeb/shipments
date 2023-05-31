<?php

namespace App\Http\Requests\Admin\Package;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdatePackage extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.package.edit', $this->package);
    }

/**
     * Get the validation rules that apply to the requests untranslatable fields.
     *
     * @return array
     */
    public function untranslatableRules(): array {
        return [
            'long' => ['sometimes', 'numeric'],
            'limited' => ['sometimes', 'boolean'],
            'shipment_count' => ['sometimes', 'integer'],
            'price' => ['sometimes', 'numeric'],
            'weight_default' => ['sometimes', 'numeric'],
            'weight_fee' => ['sometimes', 'numeric'],
            'road' => ['sometimes', 'boolean'],
            'road_sale' => ['sometimes', 'numeric'],
            'pickup' => ['sometimes', 'boolean'],
            'pickup_fee' => ['sometimes', 'numeric'],
            'todoor' => ['sometimes', 'boolean'],
            'todoor_fee' => ['sometimes', 'numeric'],
            'express' => ['sometimes', 'boolean'],
            'express_fee' => ['sometimes', 'numeric'],
            'breakable' => ['sometimes', 'boolean'],
            'breakable_fee' => ['sometimes', 'numeric'],
            'is_published' => ['sometimes', 'boolean'],
            'for_stuff' => ['sometimes', 'boolean'],
            

        ];
    }

    /**
     * Get the validation rules that apply to the requests translatable fields.
     *
     * @return array
     */
    public function translatableRules($locale): array {
        return [
            'name' => ['sometimes', 'string'],
            
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
