<?php

namespace App\Http\Requests\Admin\Place;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StorePlace extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.place.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'enabled' => ['required', 'boolean'],
            'parent' => ['nullable', ],
            'branch' => ['required', ],

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
        $sanitized['parent_id'] = $this->getParentId();
        $sanitized['branch_id'] = $this->getBranchId();
        //Add your code for manipulation with request data here

        return $sanitized;
    }
    public function getParentId(){
        if ($this->has('parent')&& $this->get('parent')!=""){
            return $this->get('parent')['id'];
        }
        return null;
    }
    public function getBranchId(){
        if ($this->has('branch')){
            return $this->get('branch')['id'];
        }
        return null;
    }
}
