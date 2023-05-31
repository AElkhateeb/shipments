<div class="form-group row align-items-center" :class="{'has-danger': errors.has('reason'), 'has-success': fields.reason && fields.reason.valid }">
    <label for="reason" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movement.columns.reason') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.reason" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('reason'), 'form-control-success': fields.reason && fields.reason.valid}" id="reason" name="reason" placeholder="{{ trans('admin.movement.columns.reason') }}">
        <div v-if="errors.has('reason')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('reason') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('shipment_id'), 'has-success': fields.shipment_id && fields.shipment_id.valid }">
    <label for="shipment_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movement.columns.shipment_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <multiselect
                v-model="form.shipment"
                :options="shipments"
                :multiple="false"
                track-by="id"
                label="label"
                tag-placeholder="{{ __('Select Shipment') }}"
                placeholder="{{ __('shipment') }}">
            </multiselect>
            <div v-if="errors.has('shipment_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('shipment_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('method_id'), 'has-success': fields.method_id && fields.method_id.valid }">
    <label for="method_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movement.columns.method_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <multiselect
                v-model="form.method"
                :options="methods"
                :multiple="false"
                track-by="id"
                label="label"
                tag-placeholder="{{ __('Select Method') }}"
                placeholder="{{ __('method') }}">
            </multiselect>
            <div v-if="errors.has('method_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('method_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('employee_type'), 'has-success': fields.employee_type && fields.employee_type.valid }">
    <label for="employee_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movement.columns.employee_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
             <multiselect
                v-model="form.employee_type"
                :options="roles"
                :multiple="false"
                @select="getOwner"
                track-by="model"
                label="name"
                tag-placeholder="{{ __('Select Shipper') }}"
                placeholder="{{ __('Shipper') }}" >
            </multiselect>
        <div v-if="errors.has('employee_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('employee_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('employee_id'), 'has-success': fields.employee_id && fields.employee_id.valid }">
    <label for="employee_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movement.columns.employee_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
       <multiselect
                v-model="form.employee"
                :options="shippers"
                :multiple="false"
                track-by="id"
                label="label"
                :searchable="true" 
                tag-placeholder="{{ __('Select Shipper') }}"
                placeholder="{{ __('Shipper') }}" >
            </multiselect>
        <div v-if="errors.has('employee_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('employee_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('branch_id'), 'has-success': fields.branch_id && fields.branch_id.valid }">
    <label for="branch_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movement.columns.branch_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <multiselect
                v-model="form.branch"
                :options="branches"
                :multiple="false"
                track-by="id"
                label="label"
                tag-placeholder="{{ __('Select Branch') }}"
                placeholder="{{ __('branch') }}">
            </multiselect>
            <div v-if="errors.has('branch_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('branch_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('method_parent_id'), 'has-success': fields.method_parent_id && fields.method_parent_id.valid }">
    <label for="method_parent_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.movement.columns.method_parent_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <multiselect
                v-model="form.parent"
                :options="parents"
                :multiple="false"
                track-by="id"
                label="label"
                tag-placeholder="{{ __('Select Parent') }}"
                placeholder="{{ __('parent') }}">
            </multiselect>
            <div v-if="errors.has('method_parent_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('method_parent_id') }}</div>
    </div>
</div>


