@extends('admin.layouts.app')
@section('title','Users')
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
                                        href="{{route('admin.users.index')}}">{{__('msg.users')}}</a>
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
                                @if(admin()->check_route_permission('admin.users.create') == 1)
                                    <div class="card-header">
                                        <h4 class="card-title" id="basic-layout-form">{{__('msg.user')}}</h4>
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
                                            <form class="form" action="{{route('admin.users.store')}}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-body">
                                                    <h4 class="form-section"></h4>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group row justify-content-center">
                                                                <div class="avatar-upload">
                                                                    <div class="avatar-edit">
                                                                        <input type="file" name="image" id="imageUpload"
                                                                               accept=".png, .jpg, .jpeg"/>
                                                                        <label for="imageUpload"
                                                                               class="imageUploadlabel"><i
                                                                                class="la la-pencil edit_user"></i></label>
                                                                    </div>
                                                                    <div class="avatar-preview">
                                                                        <div id="imagePreview"
                                                                             style="background-image: url({{asset('public/assets/images/plus-96.png')}});">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <label class=" label-control"
                                                                       for="name">{{__('msg.name')}}</label>

                                                                    <input type="text" id="name"
                                                                           class="form-control border-primary"
                                                                           placeholder="{{__('msg.name')}}"
                                                                           value="{{ old('name') }}"
                                                                           name="name" maxlength="20" required>
                                                                    @error('name')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <label class=" label-control"
                                                                       for="name">{{__('msg.business_name')}}</label>

                                                                    <input type="text" id="name"
                                                                           class="form-control border-primary"
                                                                           placeholder="{{__('msg.business_name')}}"
                                                                           value="{{ old('business_name') }}"
                                                                           name="business_name" maxlength="50" required>
                                                                    @error('business_name')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <label class=" label-control"
                                                                       for="email">{{__('msg.email')}}</label>

                                                                    <input type="email" id="email"
                                                                           class="form-control border-primary"
                                                                           placeholder="{{__('msg.email')}}"
                                                                           value="{{ old('email') }}" name="email"
                                                                           required>
                                                                    @error('email')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <label class=" label-control"
                                                                       for="sort_id">{{__('msg.phone')}}</label>

                                                                <input type="tel"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.phone')}}"
                                                                       value="{{old('phone')}}" name="phone"
                                                                       required>
                                                                @error('phone')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <label class=" label-control"
                                                                       for="sort_id">{{__('msg.id_num')}}</label>

                                                                <input type="text"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.id_num')}}"
                                                                       value="{{old('id_num')}}" name="id_num"
                                                                       >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="label-control">{{__('msg.birth_date')}}</label>
                                                                <input type="text"
                                                                       class="form-control flatpickr border-primary"
                                                                       value="{{ old('birth_date') }}" name="birth_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <label class=" label-control"
                                                                       for="sort_id">{{__('msg.password')}}</label>

                                                                    <input type="password" id="password"
                                                                           class="form-control border-primary"
                                                                           placeholder="{{__('msg.password')}}"
                                                                           value="{{ old('password') }}" name="password"
                                                                           required>
                                                                    @error('password')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="label-control">{{__('msg.user_type')}}</label>

                                                                    <select class="select2 form-control" name="user_type">
                                                                          <option value="1">{{__('msg.freelancer')}}</option>
                                                                          <option value="2">{{__('msg.business_owner')}}</option>
                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="label-control" for="sort_id">{{__('msg.status_id')}}</label>
                                                                    <select class="select2 form-control" id="status_id" name="status_id">
                                                                          <option value="1">{{__('msg.approve')}}</option>
                                                                          <option value="2">{{__('msg.suspend')}}</option>
                                                                          <option value="3">{{__('msg.not_approve')}}</option>
                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-none block_ex_date_dev">
                                                            <div class="form-group">
                                                                <label class="label-control">{{__('msg.block_ex_date')}}</label>
                                                                <input type="text"
                                                                       class="form-control flatpickr border-primary"
                                                                       value="{{ old('block_ex_date') }}" name="block_ex_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="label-control">{{__('msg.skills')}}</label>
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
                                                            <div class="form-group">
                                                                <label class="label-control">{{__('msg.tags')}}</label>
                                                                    <select class="select2 form-control" multiple name="tags[]">
                                                                        @if(count($tags) > 0)
                                                                            @foreach($tags as $tag)
                                                                                <option value="{{$tag->id}}">{{$tag->name}}</option>
                                                                            @endforeach
                                                                        @endif

                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="label-control">{{__('msg.country')}}</label>
                                                                    <select class="select2 form-control" name="country_id">
                                                                        @if(count($countries) > 0)
                                                                            @foreach($countries as $country)
                                                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                                            @endforeach
                                                                        @endif

                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="label-control">{{__('msg.about_me')}}</label>
                                                                <textarea rows="9"
                                                                       class="form-control border-primary"
                                                                          name="about_me">{{ old('about_me') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label class="col-md-6 label-control"
                                                                       for="sort_id">{{__('msg.is_confirm_email')}}</label>
                                                                <div class="col-md-6">
                                                                    <div class="float-left">
                                                                        <input type="checkbox" name="is_confirm_email"
                                                                               class="switchBootstrap"
                                                                               id="switchBootstrap2"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label class="col-md-6 label-control"
                                                                       for="sort_id">{{__('msg.is_confirm_phone')}}</label>
                                                                <div class="col-md-6">
                                                                    <div class="float-left">
                                                                        <input type="checkbox" name="is_confirm_phone"
                                                                               class="switchBootstrap"
                                                                               id="switchBootstrap3"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label class="col-md-6 label-control"
                                                                       for="sort_id">{{__('msg.is_confirm_id')}}</label>
                                                                <div class="col-md-6">
                                                                    <div class="float-left">
                                                                        <input type="checkbox" name="is_confirm_id"
                                                                               class="switchBootstrap"
                                                                               id="switchBootstrap4"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-actions">
                                                        <a href="{{route('admin.users.index')}}" type="button"
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .select2-container--default {
            width: 100% !important;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{asset('public/assets/js/file_upload.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/forms/select/select2.full.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('public/assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(".flatpickr").flatpickr({
        dateFormat: "d/m/Y",
        minDate: "today",
        enableTime: false,
    });
    $(document).on('change','#status_id',function (){
       var item = $('#status_id :selected').val();
       if(item == 2)
           $('.block_ex_date_dev').removeClass('d-none');
       else
           $('.block_ex_date_dev').addClass('d-none');
    });
</script>
@endsection
