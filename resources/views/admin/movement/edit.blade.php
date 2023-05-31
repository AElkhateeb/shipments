@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.movement.actions.edit', ['name' => $movement->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <movement-form
                :action="'{{ $movement->resource_url }}'"
                :data="{{ $movement->toJson() }}"
                :parents="{{ $parents->map(function($parent) { return ['id' => $parent->id, 'label' =>  $parent->method]; })->toJson() }}"
                :methods="{{$methods->map(function($method) { return ['id' => $method->id, 'label' =>  $method->method]; })->toJson()}}"
                :shipments="{{ $shipments->map(function($shipment) { return ['id' => $shipment->id, 'label' =>  $shipment->pkg_num]; })->toJson() }}"
                :branches="{{$branches->map(function($branch) { return ['id' => $branch->id, 'label' =>  $branch->name]; })->toJson()}}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.movement.actions.edit', ['name' => $movement->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.movement.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </movement-form>

        </div>

</div>

@endsection
