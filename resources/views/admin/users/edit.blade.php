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
                                <li class="breadcrumb-item active">{{__('msg.edit_user')}}
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
                                @if(admin()->check_route_permission('admin.users.edit') == 1)
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
                                    @include('admin.layouts.alerts.success')
                                    @include('admin.layouts.alerts.errors')
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            @if($user)
                                                <form class="form" action="{{route('admin.users.update',$user->id)}}"
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
                                                                            <input type="file" name="image" id="imageUpload"
                                                                                   accept=".png, .jpg, .jpeg"/>
                                                                            <label for="imageUpload"
                                                                                   class="imageUploadlabel"><i
                                                                                    class="la la-pencil edit_user"></i></label>
                                                                        </div>
                                                                        <div class="avatar-preview">
                                                                            <div id="imagePreview"
                                                                                 style="background-image: url({{isset($user->image) && $user->image->file_path ? asset('public'.$user->image->file_path) : asset('public/assets/images/plus-96.png')}});">
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
                                                                           value="{{ $user->name }}"
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
                                                                           value="{{ $user->business_name }}"
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
                                                                           value="{{ $user->email }}" name="email"
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
                                                                           value="{{$user->phone}}" name="phone"
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
                                                                           value="{{$user->id_num}}" name="id_num"
                                                                           >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="label-control">{{__('msg.birth_date')}}</label>
                                                                    <input type="text"
                                                                           class="form-control flatpickr border-primary"
                                                                           value="{{$user->birth_date ? date('d/m/Y',strtotime($user->birth_date))  : ''}}" name="birth_date">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group ">
                                                                    <label class=" label-control"
                                                                           for="sort_id">{{__('msg.password')}}</label>

                                                                    <input type="password" id="password"
                                                                           class="form-control border-primary"
                                                                           placeholder="{{__('msg.password')}}"
                                                                           value="{{ old('password') }}" name="password">
                                                                    @error('password')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="label-control">{{__('msg.user_type')}}</label>

                                                                    <select class="select2 form-control" name="user_type">
                                                                        <option value="1" {{$user->user_type == 1 ? 'selected' : ''}}>{{__('msg.freelancer')}}</option>
                                                                        <option value="2" {{$user->user_type == 2 ? 'selected' : ''}}>{{__('msg.business_owner')}}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="label-control" for="sort_id">{{__('msg.status_id')}}</label>
                                                                    <select class="select2 form-control" id="status_id" name="status_id">
                                                                        <option value="1" {{$user->status_id == 1 ? 'selected' : ''}}>{{__('msg.approve')}}</option>
                                                                        <option value="2" {{$user->status_id == 2 ? 'selected' : ''}}>{{__('msg.suspend')}}</option>
                                                                        <option value="3" {{$user->status_id == 3 ? 'selected' : ''}}>{{__('msg.not_approve')}}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 d-none block_ex_date_dev">
                                                                <div class="form-group">
                                                                    <label class="label-control">{{__('msg.block_ex_date')}}</label>
                                                                    <input type="text"
                                                                           class="form-control flatpickr border-primary"
                                                                           value="{{ $user->block_ex_date ? date('d/m/Y',strtotime($user->block_ex_date)) : ''}}" name="block_ex_date">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="label-control">{{__('msg.skills')}}</label>
                                                                    <select class="select2 form-control" multiple name="skills[]">
                                                                        @if(count($skills) > 0)
                                                                            @foreach($skills as $skill)
                                                                                <option value="{{$skill->id}}" {{$user->skills && in_array($skill->id,json_decode($user->skills)) ? 'selected' : ''}}>{{$skill->name}}</option>
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
                                                                                <option value="{{$tag->id}}" {{$user->tags && in_array($tag->id,json_decode($user->tags)) ? 'selected' : ''}}>{{$tag->name}}</option>
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
                                                                                <option value="{{$country->id}}" {{$user->country_id == $country->id ? 'selected' : ''}}>{{$country->name}}</option>
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
                                                                              name="about_me">{{ $user->about_me }}</textarea>
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
                                                                                   {{$user->is_confirm_email == 1 ? 'checked' : ''}}
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
                                                                                   {{$user->is_confirm_phone == 1 ? 'checked' : ''}}
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
                                                                                   {{$user->is_confirm_id == 1 ? 'checked' : ''}}
                                                                                   class="switchBootstrap"
                                                                                   id="switchBootstrap4"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label class="label-control"
                                                                           for="sort_id">{{__('msg.files')}}</label>
                                                                    <ul>
                                                                    @if(isset($user->files) && count($user->files) > 0)
                                                                        @foreach($user->files as $file)
                                                                                <li class="row_{{$file->id}}"><a target="_blank" href="{{asset('public'.$file->file_path)}}">{{$file->file_name}}</a><span item_id="{{$file->id}}" class="la la-trash text-danger delete_file cursor-pointer"></span></li>
                                                                        @endforeach
                                                                    @endif
                                                                    </ul>
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
    <div class="modal fade text-left" id="deleteItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">{{__('msg.delete_item')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{asset('public/assets/images/remove.png')}}">
                    <h5>{{__('msg.confirm_delete_item')}}</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{__('msg.back')}}</button>
                    <button type="button" class="btn btn-outline-danger confirm_delete">{{__('msg.confirm')}}</button>
                </div>
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
        $(document).ready(function (){
            $('#status_id').change();
        })
        $(document).on('change','#status_id',function (){
            var item = $('#status_id :selected').val();
            if(item == 2)
                $('.block_ex_date_dev').removeClass('d-none');
            else
                $('.block_ex_date_dev').addClass('d-none');
        });
        $(document).on('click','.delete_file',function (){
            $('#deleteItem').modal('show');
            var item_id = $(this).attr('item_id')
            $(document).on('click','.confirm_delete',function (){
                $.ajax({
                    type : 'post',
                    url: "{{route('admin.file.delete')}}",
                    data:{
                        '_token' : "{{csrf_token()}}",
                        'id' : item_id
                    },
                    success: function (data) {

                        if (data.status == true) {
                            $('#success_msg').show();
                            $('#deleteItem').modal('hide');
                            $('.row_' + data.id).remove();
                        }
                    }, error: function (reject) {

                    }
                })
            })

        });
    </script>
@endsection
