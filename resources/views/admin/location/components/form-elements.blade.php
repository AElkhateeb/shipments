<div class="form-group row align-items-center" :class="{'has-danger': errors.has('state'), 'has-success': fields.state && fields.state.valid }">
    <label for="state" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.location.columns.state') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.state" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('state'), 'form-control-success': fields.state && fields.state.valid}" id="state" name="state" placeholder="{{ trans('admin.location.columns.state') }}">
        <div v-if="errors.has('state')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('state') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('city'), 'has-success': fields.city && fields.city.valid }">
    <label for="city" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.location.columns.city') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.city" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('city'), 'form-control-success': fields.city && fields.city.valid}" id="city" name="city" placeholder="{{ trans('admin.location.columns.city') }}">
        <div v-if="errors.has('city')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('city') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('street'), 'has-success': fields.street && fields.street.valid }">
    <label for="street" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.location.columns.street') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.street" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('street'), 'form-control-success': fields.street && fields.street.valid}" id="street" name="street" placeholder="{{ trans('admin.location.columns.street') }}">
        <div v-if="errors.has('street')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('street') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('location'), 'has-success': fields.location && fields.location.valid }">
    <label for="location" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.location.columns.location') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.location" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('location'), 'form-control-success': fields.location && fields.location.valid}" id="location" name="location" placeholder="{{ trans('admin.location.columns.location') }}">
        <div v-if="errors.has('location')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('location') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('lng'), 'has-success': fields.lng && fields.lng.valid }">
    <label for="lng" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.location.columns.lng') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.lng" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('lng'), 'form-control-success': fields.lng && fields.lng.valid}" id="lng" name="lng" placeholder="{{ trans('admin.location.columns.lng') }}">
        <div v-if="errors.has('lng')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('lng') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('lat'), 'has-success': fields.lat && fields.lat.valid }">
    <label for="lat" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.location.columns.lat') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.lat" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('lat'), 'form-control-success': fields.lat && fields.lat.valid}" id="lat" name="lat" placeholder="{{ trans('admin.location.columns.lat') }}">
        <div v-if="errors.has('lat')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('lat') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('for_type'), 'has-success': fields.for_type && fields.for_type.valid }">
    <label for="for_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.location.columns.for_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.for_type" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('for_type'), 'form-control-success': fields.for_type && fields.for_type.valid}" id="for_type" name="for_type" placeholder="{{ trans('admin.location.columns.for_type') }}">
        <div v-if="errors.has('for_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('for_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('for_id'), 'has-success': fields.for_id && fields.for_id.valid }">
    <label for="for_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.location.columns.for_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.for_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('for_id'), 'form-control-success': fields.for_id && fields.for_id.valid}" id="for_id" name="for_id" placeholder="{{ trans('admin.location.columns.for_id') }}">
        <div v-if="errors.has('for_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('for_id') }}</div>
    </div>
</div>


