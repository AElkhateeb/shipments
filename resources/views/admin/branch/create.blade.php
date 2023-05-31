@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.branch.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <branch-form
            :action="'{{ url('admin/branches') }}'"
            :locales="{{ json_encode($locales) }}"
            :mangers="{{ $mangers->map(function($manger) { return ['id' => $manger->id, 'label' =>  $manger->full_name]; })->toJson() }}"
            :agents="{{$agents->map(function($agent) { return ['id' => $agent->id, 'label' =>  $agent->full_name]; })->toJson()}}"
            :send-empty-locales="false"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.branch.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.branch.components.form-elements')
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>

            </form>

        </branch-form>

        </div>

        </div>


@endsection
