@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.package.actions.index'))

@section('body')

    <package-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/packages') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.package.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/packages/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.package.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
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

                                        <th is='sortable' :column="'id'">{{ trans('admin.package.columns.id') }}</th>
                                        <th is='sortable' :column="'name'">{{ trans('admin.package.columns.name') }}</th>
                                        <th is='sortable' :column="'long'">{{ trans('admin.package.columns.long') }}</th>
                                        <th is='sortable' :column="'limited'">{{ trans('admin.package.columns.limited') }}</th>
                                        <th is='sortable' :column="'shipment_count'">{{ trans('admin.package.columns.shipment_count') }}</th>
                                        <th is='sortable' :column="'price'">{{ trans('admin.package.columns.price') }}</th>
                                        <th is='sortable' :column="'weight_default'">{{ trans('admin.package.columns.weight_default') }}</th>
                                        <th is='sortable' :column="'weight_fee'">{{ trans('admin.package.columns.weight_fee') }}</th>
                                        <th is='sortable' :column="'road'">{{ trans('admin.package.columns.road') }}</th>
                                        <th is='sortable' :column="'road_sale'">{{ trans('admin.package.columns.road_sale') }}</th>
                                        <th is='sortable' :column="'pickup'">{{ trans('admin.package.columns.pickup') }}</th>
                                        <th is='sortable' :column="'pickup_fee'">{{ trans('admin.package.columns.pickup_fee') }}</th>
                                        <th is='sortable' :column="'todoor'">{{ trans('admin.package.columns.todoor') }}</th>
                                        <th is='sortable' :column="'todoor_fee'">{{ trans('admin.package.columns.todoor_fee') }}</th>
                                        <th is='sortable' :column="'express'">{{ trans('admin.package.columns.express') }}</th>
                                        <th is='sortable' :column="'express_fee'">{{ trans('admin.package.columns.express_fee') }}</th>
                                        <th is='sortable' :column="'breakable'">{{ trans('admin.package.columns.breakable') }}</th>
                                        <th is='sortable' :column="'breakable_fee'">{{ trans('admin.package.columns.breakable_fee') }}</th>
                                        <th is='sortable' :column="'is_published'">{{ trans('admin.package.columns.is_published') }}</th>
                                        <th is='sortable' :column="'for_stuff'">{{ trans('admin.package.columns.for_stuff') }}</th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="22">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/packages')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/packages/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
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
                                        <td>@{{ item.name }}</td>
                                        <td>@{{ item.long }}</td>
                                        <td>@{{ item.limited }}</td>
                                        <td>@{{ item.shipment_count }}</td>
                                        <td>@{{ item.price }}</td>
                                        <td>@{{ item.weight_default }}</td>
                                        <td>@{{ item.weight_fee }}</td>
                                        <td>@{{ item.road }}</td>
                                        <td>@{{ item.road_sale }}</td>
                                        <td>@{{ item.pickup }}</td>
                                        <td>@{{ item.pickup_fee }}</td>
                                        <td>@{{ item.todoor }}</td>
                                        <td>@{{ item.todoor_fee }}</td>
                                        <td>@{{ item.express }}</td>
                                        <td>@{{ item.express_fee }}</td>
                                        <td>@{{ item.breakable }}</td>
                                        <td>@{{ item.breakable_fee }}</td>
                                        <td>
                                            <label class="switch switch-3d switch-success">
                                                <input type="checkbox" class="switch-input" v-model="collection[index].is_published" @change="toggleSwitch(item.resource_url, 'is_published', collection[index])">
                                                <span class="switch-slider"></span>
                                            </label>
                                        </td>

                                        <td>@{{ item.for_stuff }}</td>
                                        
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
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/packages/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.package.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </package-listing>

@endsection