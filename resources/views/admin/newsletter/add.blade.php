@extends('admin.layouts.app')
@section('title','Newsletter')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{route('dashboard.index')}}">{{__('msg.dashboard')}} </a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.newsletter.index')}}">{{__('msg.newsletter')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{__('msg.newsletter')}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                @if(admin()->check_route_permission('admin.newsletter.create') == 1)
                                    <div class="card-header">
                                        <h4 class="card-title" id="basic-layout-form">{{__('msg.newsletter')}}</h4>
                                        <a class="heading-elements-toggle"><i
                                                class="la la-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <form class="form" action="{{route('admin.newsletter.store')}}"
                                                  method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-body">
                                                    <h4 class="form-section"></h4>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class=" label-control"
                                                                       for="url">{{__('msg.title')}}</label>

                                                                <input type="text" id="url"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.title')}}"
                                                                       value="{{ old('title') }}"
                                                                       name="title">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.desc')}}</label>
                                                                <textarea rows="5"
                                                                          class="form-control border-primary"
                                                                          placeholder="{{__('msg.desc')}}"
                                                                          name="desc">{{ old('desc') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class=" label-control"
                                                                       for="url">{{__('msg.send_date')}}</label>

                                                                <input type="text" class="form-control send_date"
                                                                       id="send_date" name="send_date"
                                                                       placeholder="d/m/Y"
                                                                       value="{{ old('send_date') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-actions">
                                                    <a href="{{route('admin.newsletter.index')}}" type="button"
                                                       class="btn btn-warning mr-1 block-page"
                                                       onclick="history.back();">
                                                        <i class="ft-x"></i> {{__('msg.back')}}
                                                    </a>
                                                    <button type="submit" class="btn btn-primary block-page">
                                                        <i class="la la-check-square-o"></i> {{__('msg.send_close')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    @include('admin.layouts.alerts.error_perm')
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection
@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr(".send_date", {
            enableTime: false,
            dateFormat: "d/m/Y",
            altFormat: "d/m/Y",
            minDate: "today",
        });
    </script>
@endsection
