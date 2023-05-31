<?php

namespace App\Http\Requests\Admin\Movement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreMovement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.movement.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'reason' => ['nullable', 'string'],
            'shipment' => ['required', 'integer'],
            'method' => ['required', 'integer'],
            'employee_type' => ['required', 'string'],
            'employee_id' => ['required', 'string'],
            'branch' => ['required', 'integer'],
            'parent' => ['nullable', 'integer'],

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
    public function getParentId(){
        if ($this->has('parent')){
            return $this->get('parent')['id'];
        }
        return null;
    }
    public function getMethodId(){
        if ($this->has('method')){
            return $this->get('method')['id'];
        }
        return null;
    }
    public function getShipmentId(){
        if ($this->has('shipment')){
            return $this->get('shipment')['id'];
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
