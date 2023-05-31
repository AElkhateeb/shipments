@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.shipment.actions.create'))

@section('body')

    <div class="container-xl">


        <shipment-form
            :action="'{{ url('admin/shipments') }}'"
            :url="'admin'"
            :roads="{{ $roads->map(function($road) { return ['id' => $road->id, 'label' =>  $road->name]; })->toJson()}}"
            :places="{{$places->map(function($place) { return ['id' => $place->id, 'label' =>  $place->name]; })->toJson()}}"
            :branches="{{$branches->map(function($branch) { return ['id' => $branch->id, 'label' =>  $branch->name]; })->toJson()}}"
            :payment_methods="{{$paymentMethods->map(function($paymentMethod) { return ['id' => $paymentMethod->id, 'label' =>  $paymentMethod->name]; })->toJson()}}"
            :roles="{{$roles->map(function($roles) { return ['model' =>$roles->guard_name.'-admin', 'label' =>  $roles->name]; })->toJson()}}"
            :shippers="{{$shippers->map(function($shippers) { return ['id' =>$shippers->id, 'label' =>  $shippers->full_name]; })->toJson()}}"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus"></i> {{ trans('admin.shipment.actions.create') }}
                            </div>
                            <div class="card-body">
                                @include('admin.shipment.components.form-elements')
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12 col-xl-5 col-xxl-4">
                        @include('admin.shipment.components.form-elements-right')

                    </div>
                </div>

                <button type="submit" class="btn btn-primary fixed-cta-button button-save" :disabled="submiting">
                    <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-save'"></i>
                    {{ trans('brackets/admin-ui::admin.btn.save') }}
                </button>


            </form>

        </shipment-form>

        </div>


@endsection
