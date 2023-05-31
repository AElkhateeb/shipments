@extends('ceo.layout.default')

@section('title', trans('admin.slider.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <slider-form
            :action="'{{ url('ceo/sliders') }}'"
            :locales="{{ json_encode($locales) }}"
            :send-empty-locales="false"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.slider.actions.create') }}
                </div>

                <div class="card-body">
                    @include('ceo.slider.components.form-elements')
                    @include('ceo.includes.media-uploader', [
                       'mediaCollection' => app(App\Models\Slider::class)->getMediaCollection('slider'),
                       'label' => 'Image'
                       ])
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>

            </form>

        </slider-form>

        </div>

        </div>


@endsection
