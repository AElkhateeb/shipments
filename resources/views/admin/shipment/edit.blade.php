@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.shipment.actions.edit', ['name' => $shipment->id]))

@section('body')

    <div class="container-xl">

            <shipment-form
                :action="'{{ $shipment->resource_url }}'"
                :data="{{ $shipment->toJson() }}"
                :roads="{{ $roads->map(function($road) { return ['id' => $road->id, 'label' =>  $road->name]; })->toJson()}}"
                :places="{{$places->map(function($place) { return ['id' => $place->id, 'label' =>  $place->name]; })->toJson()}}"
                :branches="{{$branches->map(function($branch) { return ['id' => $branch->id, 'label' =>  $branch->name]; })->toJson()}}"
                :payment_methods="{{$paymentMethods->map(function($paymentMethod) { return ['id' => $paymentMethod->id, 'label' =>  $paymentMethod->name]; })->toJson()}}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-pencil"></i> {{ trans('admin.shipment.actions.edit', ['name' => $shipment->id]) }}
                                </div>
                                <div class="card-body">
                                    @include('admin.shipment.components.form-elements')
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-xl-5 col-xxl-4">
                            @include('admin.shipment.components.form-elements-right', ['showHistory' => true])
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary fixed-cta-button button-save" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-save'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>

                    <button type="submit" style="display: none" class="btn btn-success fixed-cta-button button-saved" :disabled="submiting" :class="">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-check'"></i>
                        <span>{{ trans('brackets/admin-ui::admin.btn.saved') }}</span>
                    </button>

                </form>

        </shipment-form>


</div>

@endsection
