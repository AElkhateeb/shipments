@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.road.actions.index'))

@section('body')

    <road-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/roads') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.road.actions.index') }}
                        <a class="btn btn-primary btn-sm pull-right m-b-0 ml-2" href="{{ url('admin/roads/export') }}" role="button"><i class="fa fa-file-excel-o"></i>&nbsp; {{ trans('admin.road.actions.export') }}</a>
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/roads/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.road.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend" v-if="showFromFilter">
                                                <div class="col-sm-auto form-group">
                                                    <p>{{ __('Select place/s') }}</p>
                                                </div>
                                                <div class="col col-lg-12 col-xl-12 form-group">
                                                    <multiselect v-model="fromMultiselect"
                                                                 :options="{{ $places->map(function($place) { return ['key' => $place->id, 'label' =>  $place->name]; })->toJson() }}"
                                                                 label="label"
                                                                 track-by="key"
                                                                 placeholder="{{ __('Type to search a place/s') }}"
                                                                 :limit="2"
                                                                 :multiple="false">
                                                    </multiselect>
                                                </div>
                                            </div>
                                            <div class="input-group-prepend" v-if="showToFilter">
                                                <div class="col-sm-auto form-group">
                                                    <p>{{ __('Select place/s') }}</p>
                                                </div>
                                                <div class="col col-lg-12 col-xl-12 form-group">
                                                    <multiselect v-model="toMultiselect"
                                                                 :options="{{ $places->map(function($place) { return ['key' => $place->id, 'label' =>  $place->name]; })->toJson() }}"
                                                                 label="label"
                                                                 track-by="key"
                                                                 placeholder="{{ __('Type to search a place/s') }}"
                                                                 :limit="2"
                                                                 :multiple="false">
                                                    </multiselect>
                                                </div>
                                            </div>
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">

                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'id'">{{ trans('admin.road.columns.id') }}</th>
                                        <th is='sortable' :column="'price'">{{ trans('admin.road.columns.price') }}</th>
                                        <th is='sortable' :column="'time'">{{ trans('admin.road.columns.time') }}</th>
                                        <th is='sortable' :column="'enabled'">{{ trans('admin.road.columns.enabled') }}</th>
                                        <th is='sortable' :column="'pickup'">{{ trans('admin.road.columns.pickup') }}</th>
                                        <th is='sortable' :column="'todoor'">{{ trans('admin.road.columns.todoor') }}</th>
                                        <th is='sortable' :column="'express'">{{ trans('admin.road.columns.express') }}</th>
                                        <th is='sortable' :column="'breakable'">{{ trans('admin.road.columns.breakable') }}</th>
                                        <th is='sortable' :column="'from_id'">{{ trans('admin.road.columns.from_id') }}</th>
                                        <th is='sortable' :column="'to_id'">{{ trans('admin.road.columns.to_id') }}</th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="12">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/roads')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/roads/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>

                                    <td>@{{ item.id }}</td>
                                        <td>@{{ item.price }}</td>
                                        <td>@{{ item.time }}</td>
                                        <td>
                                            <label class="switch switch-3d switch-success">
                                                <input type="checkbox" class="switch-input" v-model="collection[index].enabled" @change="toggleSwitch(item.resource_url, 'enabled', collection[index])">
                                                <span class="switch-slider"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="switch switch-3d switch-success">
                                                <input type="checkbox" class="switch-input" v-model="collection[index].pickup" @change="toggleSwitch(item.resource_url, 'pickup', collection[index])">
                                                <span class="switch-slider"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="switch switch-3d switch-success">
                                                <input type="checkbox" class="switch-input" v-model="collection[index].todoor" @change="toggleSwitch(item.resource_url, 'todoor', collection[index])">
                                                <span class="switch-slider"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="switch switch-3d switch-success">
                                                <input type="checkbox" class="switch-input" v-model="collection[index].express" @change="toggleSwitch(item.resource_url, 'express', collection[index])">
                                                <span class="switch-slider"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="switch switch-3d switch-success">
                                                <input type="checkbox" class="switch-input" v-model="collection[index].breakable" @change="toggleSwitch(item.resource_url, 'breakable', collection[index])">
                                                <span class="switch-slider"></span>
                                            </label>
                                        </td>
                                        <td>@{{ item.place_from.name }}</td>
                                        <td>@{{ item.place_to.name }}</td>

                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/roads/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.road.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </road-listing>

@endsection
