@extends('admin.layouts.app')
@section('title','Countries')
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
                                        href="{{route('admin.countries.index')}}">{{__('msg.countries')}}</a>
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
                                @if(admin()->check_route_permission('admin.countries.create') == 1)
                                    <div class="card-header">
                                        <h4 class="card-title" id="basic-layout-form">{{__('msg.countries')}}</h4>
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
                                            <form class="form" action="{{route('admin.countries.store')}}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-body">
                                                    <h4 class="form-section"></h4>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label class="col-md-3 label-control"
                                                                       for="name">{{__('msg.name_ar')}}</label>
                                                                <div class="col-md-9">
                                                                    <input type="text"
                                                                           class="form-control border-primary"
                                                                           placeholder="{{__('msg.name_ar')}}"
                                                                           value="{{ old('name_ar') }}"
                                                                           name="name_ar" maxlength="30" required>
                                                                    @error('name_ar')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label class="col-md-3 label-control"
                                                                       for="name">{{__('msg.name_en')}}</label>
                                                                <div class="col-md-9">
                                                                    <input type="text"
                                                                           class="form-control border-primary"
                                                                           placeholder="{{__('msg.name_en')}}"
                                                                           value="{{ old('name_en') }}"
                                                                           name="name_en" maxlength="30" required>
                                                                    @error('name_en')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-actions">
                                                        <a href="{{route('admin.countries.index')}}" type="button"
                                                           class="btn btn-warning mr-1 block-page"
                                                           onclick="history.back();">
                                                            <i class="ft-x"></i> {{__('msg.back')}}
                                                        </a>
                                                        <button type="submit" class="btn btn-primary block-page">
                                                            <i class="la la-check-square-o"></i> {{__('msg.save_close')}}
                                                        </button>
                                                        <button type="submit" name="save" value="1"
                                                                class="btn btn-primary block-page">
                                                            <i class="la la-check-square-o la "></i> {{__('msg.save')}}
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
