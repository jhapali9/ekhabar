@extends('common::layouts.master')
@section('appearance')
    active
@endsection
@section('appearance-aria-expanded')
    aria-expanded=true
@endsection
@section('theme_option')
    active
@endsection
@section('appearance-show')
    show
@endsection

@section('content')

    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- page info start-->
            <div class="row clearfix">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            @if (session('error'))
                                <div id="error_m" class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div id="success_m" class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <!-- Main Content section start -->
                        <div class="col-12 col-lg-12">
                            {!! Form::open(['route' => 'update-theme-option', 'method' => 'post']) !!}
                            <div class="add-new-page  bg-white p-20 m-b-20">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="page-title"
                                                class="col-form-label">{{ __('primary_color') }}</label>
                                            <input id="page-title"
                                                value="{{ data_get($activeTheme, 'options.primary_color') }}"
                                                name="primary_color" type="color" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 m-t-20">
                                        <div class="form-group form-float form-group-sm text-right">
                                            <button type="submit" class="btn btn-primary pull-right"><i
                                                    class="m-r-10 mdi mdi-content-save-all"></i>{{ __('update_theme') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}

                            {!! Form::open([
                                'route' => 'update-settings',
                                'method' => 'post',
                                'enctype' => 'multipart/form-data',
                                'id' => 'update-settings',
                            ]) !!}
                            <div class="add-new-page  bg-white p-20 m-b-20">
                                <div class="row p-l-15">
                                    <div class="col-sm-12">
                                        <div class="m-b-20">
                                            <span class=""><strong> {{ __('preloader_option') }}</strong> </span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-title">
                                            <label for="visibility">{{ __('status') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-3 col-md-2">
                                        <label class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" name="preloader_option" id="visibility_show"
                                                value="1" {{ settingHelper('preloader_option') == 1 ? 'checked' : '' }}
                                                class="custom-control-input">
                                            <span class="custom-control-label">{{ __('enable') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-3 col-md-2">
                                        <label class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" name="preloader_option" id="visibility_hide"
                                                value="0" class="custom-control-input"
                                                {{ settingHelper('preloader_option') == 0 ? 'checked' : '' }}>
                                            <span class="custom-control-label">{{ __('disable') }}</span>
                                        </label>
                                    </div>

                                    <div class="col-12 m-t-20">
                                        <div class="form-group form-float form-group-sm text-right">
                                            <button type="submit" class="btn btn-primary pull-right"><i
                                                    class="m-r-10 mdi mdi-content-save-all"></i>{{ __('save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <!-- Main Content section end -->

                    </div>
                </div>
            </div>
            <!-- page info end-->
        </div>
    </div>

@endsection
