<?php

namespace App\Http\Requests\Admin\Branch;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreBranch extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.branch.create');
    }

/**
     * Get the validation rules that apply to the requests untranslatable fields.
     *
     * @return array
     */
    public function untranslatableRules(): array {
        return [
            'location' => ['nullable', 'string'],
            'lng' => ['nullable', 'numeric'],
            'lat' => ['nullable', 'numeric'],
            'is_published' => ['required', 'boolean'],
            'manger' => ['required'],
            'agent' => ['nullable'],

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
            'governorate' => ['required', 'string'],

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
        $sanitized['manger'] = $this->getMangerId();
       $sanitized['agent'] = $this->getAgentId();

        return $this;
    }
    public function getMangerId(){
        if ($this->has('manger')){
            return $this->get('manger')['id'];
        }
        return null;
    }
    public function getAgentId(){
        if ($this->has('agent')){
            return $this->get('agent')['id'];
        }
        return null;
    }
}
