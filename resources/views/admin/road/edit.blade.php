@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.road.actions.edit', ['name' => $road->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <road-form
                :action="'{{ $road->resource_url }}'"
                :data="{{ $road->toJson() }}"
                :places="{{$places->map(function($place) { return ['id' => $place->id, 'name' =>  $place->name]; })->toJson()}}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.road.actions.edit', ['name' => $road->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.road.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </road-form>

        </div>

</div>

@endsection
