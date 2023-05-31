<?php

namespace App\Http\Requests\Admin\Road;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRoad extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.road.create');
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
            'time' => ['required', 'numeric'],
            'enabled' => ['required', 'boolean'],
            'pickup' => ['required', 'boolean'],
            'todoor' => ['required', 'boolean'],
            'express' => ['required', 'boolean'],
            'breakable' => ['required', 'boolean'],
            'from' => ['nullable'],
            'to' => ['nullable'],

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
         $sanitized['from_id'] = $this->getFromId();
        $sanitized['to_id'] = $this->getToId();
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
}
