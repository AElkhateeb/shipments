<?php

namespace App\Http\Requests\Admin\Location;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreLocation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.location.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
            'street' => ['required', 'string'],
            'location' => ['required', 'string'],
            'lng' => ['required', 'numeric'],
            'lat' => ['required', 'numeric'],
            'for_type' => ['required', 'string'],
            'for_id' => ['required', 'string'],
            
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
