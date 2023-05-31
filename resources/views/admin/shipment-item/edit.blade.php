@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.shipment-item.actions.edit', ['name' => $shipmentItem->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <shipment-item-form
                :action="'{{ $shipmentItem->resource_url }}'"
                :data="{{ $shipmentItem->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.shipment-item.actions.edit', ['name' => $shipmentItem->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.shipment-item.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </shipment-item-form>

        </div>
    
</div>

@endsection