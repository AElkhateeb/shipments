<div class="row form-inline" style="padding-bottom: 10px;" v-cloak>
    <div :class="{'col-xl-10 col-md-11 text-right': !isFormLocalized, 'col text-center': isFormLocalized, 'hidden': onSmallScreen }">
        <small>{{ trans('brackets/admin-ui::admin.forms.currently_editing_translation') }}<span v-if="!isFormLocalized && otherLocales.length > 1"> {{ trans('brackets/admin-ui::admin.forms.more_can_be_managed') }}</span><span v-if="!isFormLocalized"> | <a href="#" @click.prevent="showLocalization">{{ trans('brackets/admin-ui::admin.forms.manage_translations') }}</a></span></small>
        <i class="localization-error" v-if="!isFormLocalized && showLocalizedValidationError"></i>
    </div>

    <div class="col text-center" :class="{'language-mobile': onSmallScreen, 'has-error': !isFormLocalized && showLocalizedValidationError}" v-if="isFormLocalized || onSmallScreen" v-cloak>
        <small>{{ trans('brackets/admin-ui::admin.forms.choose_translation_to_edit') }}
            <select class="form-control" v-model="currentLocale">
                <option :value="defaultLocale" v-if="onSmallScreen">@{{defaultLocale.toUpperCase()}}</option>
                <option v-for="locale in otherLocales" :value="locale">@{{locale.toUpperCase()}}</option>
            </select>
            <i class="localization-error" v-if="isFormLocalized && showLocalizedValidationError"></i>
            <span>|</span>
            <a href="#" @click.prevent="hideLocalization">{{ trans('brackets/admin-ui::admin.forms.hide') }}</a>
        </small>
    </div>
</div>

<div class="row">
    @foreach($locales as $locale)
        <div class="col-md" v-show="shouldShowLangGroup('{{ $locale }}')" v-cloak>
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('name_{{ $locale }}'), 'has-success': fields.name_{{ $locale }} && fields.name_{{ $locale }}.valid }">
                <label for="name_{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{ trans('admin.package.columns.name') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    <input type="text" v-model="form.name.{{ $locale }}" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name_{{ $locale }}'), 'form-control-success': fields.name_{{ $locale }} && fields.name_{{ $locale }}.valid }" id="name_{{ $locale }}" name="name_{{ $locale }}" placeholder="{{ trans('admin.package.columns.name') }}">
                    <div v-if="errors.has('name_{{ $locale }}')" class="form-control-feedback form-text" v-cloak>{{'{{'}} errors.first('name_{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pickup_fee'), 'has-success': fields.pickup_fee && fields.pickup_fee.valid }">
    <label for="pickup_fee" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.pickup_fee') }}</label>

    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group ">
            <div class=" input-group-text">
                <input class="form-check-input" id="pickup" type="checkbox" v-model="form.pickup" v-validate="''" data-vv-name="pickup"  name="pickup_fake_element">
                <label class="form-check-label" for="pickup">
                    {{ trans('admin.package.columns.pickup') }}
                </label>
                <input type="hidden" name="pickup" :value="form.pickup">

            </div>
            <div v-if="errors.has('pickup')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pickup') }}</div>
            <input type="text" v-model="form.pickup_fee" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('pickup_fee'), 'form-control-success': fields.pickup_fee && fields.pickup_fee.valid}" id="pickup_fee" name="pickup_fee" placeholder="{{ trans('admin.package.columns.pickup_fee') }}">
            <div v-if="errors.has('pickup_fee')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pickup_fee') }}</div>

        </div>
    </div>
</div>


<div class="form-group row align-items-center" :class="{'has-danger': errors.has('breakable_fee'), 'has-success': fields.breakable_fee && fields.breakable_fee.valid }">
    <label for="breakable_fee" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.breakable_fee') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group ">
            <div class="input-group-text">
                <input class="form-check-input" id="breakable" type="checkbox" v-model="form.breakable" v-validate="''" data-vv-name="breakable"  name="breakable_fake_element">
                <label class="form-check-label" for="breakable">
                    {{ trans('admin.package.columns.breakable') }}
                </label>
                <input type="hidden" name="breakable" :value="form.breakable">


            </div>
            <div v-if="errors.has('breakable')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('breakable') }}</div>
            <input type="text" v-model="form.breakable_fee" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('breakable_fee'), 'form-control-success': fields.breakable_fee && fields.breakable_fee.valid}" id="breakable_fee" name="breakable_fee" placeholder="{{ trans('admin.package.columns.breakable_fee') }}">
            <div v-if="errors.has('breakable_fee')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('breakable_fee') }}</div>

        </div>


    </div>
</div>


<div class="form-group row align-items-center" :class="{'has-danger': errors.has('express_fee'), 'has-success': fields.express_fee && fields.express_fee.valid }">
    <label for="express_fee" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.express_fee') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group">
            <div class="input-group-text">
                <input class="form-check-input" id="express" type="checkbox" v-model="form.express" v-validate="''" data-vv-name="express"  name="express_fake_element">
                <label class="form-check-label" for="express">
                    {{ trans('admin.package.columns.express') }}
                </label>
                <input type="hidden" name="express" :value="form.express">

            </div>
            <div v-if="errors.has('express')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('express') }}</div>
            <input type="text" v-model="form.express_fee" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('express_fee'), 'form-control-success': fields.express_fee && fields.express_fee.valid}" id="express_fee" name="express_fee" placeholder="{{ trans('admin.package.columns.express_fee') }}">
            <div v-if="errors.has('express_fee')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('express_fee') }}</div>
        </div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('todoor_fee'), 'has-success': fields.todoor_fee && fields.todoor_fee.valid }">
    <label for="todoor_fee" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.todoor_fee') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group">
            <div class="input-group-text">
                <input class="form-check-input" id="todoor" type="checkbox" v-model="form.todoor" v-validate="''" data-vv-name="todoor"  name="todoor_fake_element">
                <label class="form-check-label" for="todoor">
                    {{ trans('admin.package.columns.todoor') }}
                </label>
                <input type="hidden" name="todoor" :value="form.todoor">
                <div v-if="errors.has('todoor')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('todoor') }}</div>
            </div>
            <input type="text" v-model="form.todoor_fee" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('todoor_fee'), 'form-control-success': fields.todoor_fee && fields.todoor_fee.valid}" id="todoor_fee" name="todoor_fee" placeholder="{{ trans('admin.package.columns.todoor_fee') }}">
            <div v-if="errors.has('todoor_fee')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('todoor_fee') }}</div>
        </div>
    </div>
</div>



<div class="form-group row align-items-center" :class="{'has-danger': errors.has('road_sale'), 'has-success': fields.road_sale && fields.road_sale.valid }">
    <label for="road_sale" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.road_sale') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group">
            <div class="input-group-text">
                <input class="form-check-input" id="road" type="checkbox" v-model="form.road" v-validate="''" data-vv-name="road"  name="road_fake_element">
                <label class="form-check-label" for="road">
                    {{ trans('admin.package.columns.road') }}
                </label>
                <input type="hidden" name="road" :value="form.road">
                <div v-if="errors.has('road')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('road') }}</div>
            </div>
            <input type="text" v-model="form.road_sale" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('road_sale'), 'form-control-success': fields.road_sale && fields.road_sale.valid}" id="road_sale" name="road_sale" placeholder="{{ trans('admin.package.columns.road_sale') }}">
            <div v-if="errors.has('road_sale')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('road_sale') }}</div>
        </div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('shipment_count'), 'has-success': fields.shipment_count && fields.shipment_count.valid }">
    <label for="shipment_count" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.shipment_count') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group">
            <div class="input-group-text">
                <input class="form-check-input" id="limited" type="checkbox" v-model="form.limited" v-validate="''" data-vv-name="limited"  name="limited_fake_element">
                <label class="form-check-label" for="limited">
                    {{ trans('admin.package.columns.limited') }}
                </label>
                <input type="hidden" name="limited" :value="form.limited">
                <div v-if="errors.has('limited')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('limited') }}</div>
            </div>
            <input type="text" v-model="form.shipment_count" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('shipment_count'), 'form-control-success': fields.shipment_count && fields.shipment_count.valid}" id="shipment_count" name="shipment_count" placeholder="{{ trans('admin.package.columns.shipment_count') }}">
            <div v-if="errors.has('shipment_count')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('shipment_count') }}</div>
        </div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('long'), 'has-success': fields.long && fields.long.valid }">
    <label for="long" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.long') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.long" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('long'), 'form-control-success': fields.long && fields.long.valid}" id="long" name="long" placeholder="{{ trans('admin.package.columns.long') }}">
        <div v-if="errors.has('long')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('long') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('weight_fee'), 'has-success': fields.weight_fee && fields.weight_fee.valid }">
    <label for="weight_fee" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.weight_fee') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.weight_fee" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('weight_fee'), 'form-control-success': fields.weight_fee && fields.weight_fee.valid}" id="weight_fee" name="weight_fee" placeholder="{{ trans('admin.package.columns.weight_fee') }}">
        <div v-if="errors.has('weight_fee')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('weight_fee') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('weight_default'), 'has-success': fields.weight_default && fields.weight_default.valid }">
    <label for="weight_default" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.weight_default') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.weight_default" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('weight_default'), 'form-control-success': fields.weight_default && fields.weight_default.valid}" id="weight_default" name="weight_default" placeholder="{{ trans('admin.package.columns.weight_default') }}">
        <div v-if="errors.has('weight_default')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('weight_default') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('price'), 'has-success': fields.price && fields.price.valid }">
    <label for="price" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.price') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.price" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('price'), 'form-control-success': fields.price && fields.price.valid}" id="price" name="price" placeholder="{{ trans('admin.package.columns.price') }}">
        <div v-if="errors.has('price')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('price') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('for_stuff'), 'has-success': fields.for_stuff && fields.for_stuff.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="for_stuff" type="checkbox" v-model="form.for_stuff" v-validate="''" data-vv-name="for_stuff"  name="for_stuff_fake_element">
        <label class="form-check-label" for="for_stuff">
            {{ trans('admin.package.columns.for_stuff') }}
        </label>
        <input type="hidden" name="for_stuff" :value="form.for_stuff">
        <div v-if="errors.has('for_stuff')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('for_stuff') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('is_published'), 'has-success': fields.is_published && fields.is_published.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="is_published" type="checkbox" v-model="form.is_published" v-validate="''" data-vv-name="is_published"  name="is_published_fake_element">
        <label class="form-check-label" for="is_published">
            {{ trans('admin.package.columns.is_published') }}
        </label>
        <input type="hidden" name="is_published" :value="form.is_published">
        <div v-if="errors.has('is_published')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('is_published') }}</div>
    </div>
</div>


