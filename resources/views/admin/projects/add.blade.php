@extends('admin.layouts.app')
@section('title','Projects')
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
                                        href="{{route('admin.projects.index')}}">{{__('msg.projects')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{__('msg.create')}}
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
                                @if(admin()->check_route_permission('admin.projects.create') == 1)
                                    <div class="card-header">
                                        <h4 class="card-title" id="basic-layout-form">{{__('msg.projects')}}</h4>
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
                                            <form class="form" action="{{route('admin.projects.store')}}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-body">
                                                    <h4 class="form-section"></h4>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="label-control"
                                                                       for="name">{{__('msg.title')}}</label>
                                                                    <input type="text"
                                                                           class="form-control border-primary"
                                                                           placeholder="{{__('msg.title')}}"
                                                                           value="{{ old('title') }}"
                                                                           name="title" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="label-control"
                                                                       for="name">{{__('msg.desc')}}</label>
                                                                    <textarea rows="5" type="text"
                                                                           class="form-control border-primary"
                                                                           placeholder="{{__('msg.desc')}}"
                                                                              name="desc" required>{{ old('desc') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <label class="label-control">{{__('msg.category')}}</label>

                                                                <select class="select2 form-control" name="category_id">
                                                                    @if(count($categories) > 0)
                                                                        @foreach($categories as $cat)
                                                                            <option
                                                                                value="{{$cat->id}}">{{$cat->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <label
                                                                    class="label-control">{{__('msg.business_owner')}}</label>
                                                                <select class="select2 form-control" name="business_owner_id">
                                                                    @if(count($business_owners) > 0)
                                                                        @foreach($business_owners as $business_owner)
                                                                            <option value="{{$business_owner->id}}">{{$business_owner->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="label-control"
                                                                       for="name">{{__('msg.work_period_days')}}</label>
                                                                <input type="number"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.work_period_days')}}"
                                                                       value="{{ old('work_period_days') }}"
                                                                       name="work_period_days" min="1" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="label-control"
                                                                       for="name">{{__('msg.from_price')}}</label>
                                                                <input type="number"
                                                                       step="any"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.from_price')}}"
                                                                       value="{{ old('from_price') }}"
                                                                       name="from_price" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="label-control"
                                                                       for="name">{{__('msg.to_price')}}</label>
                                                                <input type="number"
                                                                       step="any"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.to_price')}}"
                                                                       value="{{ old('to_price') }}"
                                                                       name="to_price" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label
                                                                    class="label-control">{{__('msg.skills')}}</label>
                                                                <select class="select2 form-control" multiple name="skills[]">
                                                                    @if(count($skills) > 0)
                                                                        @foreach($skills as $skill)
                                                                            <option value="{{$skill->id}}">{{$skill->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <label
                                                                    class="label-control">{{__('msg.freelancer')}}</label>
                                                                <select class="select2 form-control" name="freelancer_id">
                                                                    <option value="0">{{__('msg.select_freelancer')}}</option>
                                                                    @if(count($freelancers) > 0)
                                                                        @foreach($freelancers as $freelancer)
                                                                            <option value="{{$freelancer->id}}">{{$freelancer->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <label
                                                                    class="label-control">{{__('msg.status_id')}}</label>
                                                                <select class="select2 form-control" name="status_id">
                                                                    <option value="1">{{__('msg.open')}}</option>
                                                                    <option value="2">{{__('msg.ongoing')}}</option>
                                                                    <option value="3">{{__('msg.completed')}}</option>
                                                                    <option value="4">{{__('msg.canceled')}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label
                                                                    class="label-control">{{__('msg.files')}}</label>
                                                                <input type="file"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.files')}}"
                                                                       value="{{ old('files') }}"
                                                                       multiple
                                                                       name="files[]">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-actions">
                                                        <a href="{{route('admin.projects.index')}}" type="button"
                                                           class="btn btn-warning mr-1 block-page"
                                                           onclick="history.back();">
                                                            <i class="ft-x"></i> {{__('msg.back')}}
                                                        </a>
                                                        <button type="submit" class="btn btn-primary block-page">
                                                            <i class="la la-check-square-o"></i> {{__('msg.save_close')}}
                                                        </button>
                                                        <button type="submit" name="save" value="1"
                                                                class="btn btn-primary block-page">
                                                            <i class="la la-check-square-o"></i> {{__('msg.save')}}
                                                        </button>
                                                    </div>
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
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/css/forms/selects/select2.min.css')}}">
    <style>
        .select2-container--default {
            width: 100% !important;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{asset('public/assets/vendors/js/forms/select/select2.full.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('public/assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>

@endsection
