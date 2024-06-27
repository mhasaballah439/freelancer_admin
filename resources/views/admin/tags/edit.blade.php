@extends('admin.layouts.app')
@section('title','tags')
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
                                        href="{{route('admin.tags.index')}}">{{__('msg.tags')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{__('msg.edit')}}
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
                                @if(admin()->check_route_permission('admin.tags.edit') == 1)
                                    <div class="card-header">
                                        <h4 class="card-title" id="basic-layout-form">{{__('msg.tags')}}</h4>
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
                                    @include('admin.layouts.alerts.success')
                                    @include('admin.layouts.alerts.errors')
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            @if($tag)
                                                <form class="form"
                                                      action="{{route('admin.tags.update',$tag->id)}}"
                                                      method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-body">
                                                        <h4 class="form-section"></h4>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group row justify-content-center">
                                                                    <div class="avatar-upload">
                                                                        <div class="avatar-edit">
                                                                            <input type="file" name="image"
                                                                                   id="imageUpload"
                                                                                   required
                                                                                   accept=".png, .jpg, .jpeg"/>
                                                                            <label for="imageUpload"
                                                                                   class="imageUploadlabel"><i
                                                                                    class="la la-pencil edit_user"></i></label>
                                                                        </div>
                                                                        <div class="avatar-preview">
                                                                            <div id="imagePreview"
                                                                                 style="background-image: url({{isset($tag->image) ? asset('public/'.$tag->image->file_path) : ''}});">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label class="col-md-3 label-control"
                                                                           for="name">{{__('msg.name_ar')}}</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text"
                                                                               class="form-control border-primary"
                                                                               placeholder="{{__('msg.name_ar')}}"
                                                                               value="{{ $tag->name_ar }}"
                                                                               name="name_ar" required>
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
                                                                               value="{{ $tag->name_en }}"
                                                                               name="name_en" maxlength="20" required>
                                                                        @error('name_en')
                                                                        <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-actions">
                                                            <button type="button"
                                                                    class="btn btn-warning mr-1 block-page"
                                                                    onclick="history.back();">
                                                                <i class="ft-x"></i> {{__('msg.back')}}
                                                            </button>
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
                                            @else
                                                <p class="alert alert-danger">{{__('msg.not_found')}}</p>
                                            @endif
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
@section('scripts')
    <script src="{{asset('public/assets/js/file_upload.js')}}" type="text/javascript"></script>
@endsection