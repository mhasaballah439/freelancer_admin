@extends('admin.layouts.app')
@section('title','Settings')
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
                                @if(admin()->check_route_permission('admin.home_settings.edit') == 1)
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">{{__('msg.setting')}}</h4>
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
                                        @if($setting)
                                            <form class="form" action="{{route('admin.home_settings.update')}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            <div class="form-body">
                                                <h4 class="form-section"></h4>

                                                <div class="row">
                                                    <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="activeAr-tab1"
                                                               data-toggle="tab" href="#activeTerms"
                                                               aria-controls="activeTerms" aria-expanded="true">
                                                                {{__('msg.app')}}</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="activeEn-tab1" data-toggle="tab"
                                                               href="#activePolicy" aria-controls="activePolicy"
                                                               aria-expanded="false">{{__('msg.partners')}}</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="activeEn-tab1" data-toggle="tab"
                                                               href="#activeAppImages" aria-controls="activeAppImages"
                                                               aria-expanded="false">{{__('msg.app_images')}}</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content px-1 pt-1">
                                                        <div role="tabpanel" class="tab-pane active" id="activeTerms"
                                                             aria-labelledby="activeTerms-tab1"
                                                             aria-expanded="true">
                                                            <div class="form-group container row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.app_android')}}</label>
                                                                <input type="text" class="form-control border-primary"
                                                                          placeholder="{{__('msg.app_android')}}"
                                                                          name="app_android" value="{{$setting->app_android}}">
                                                            </div>
                                                            <div class="form-group container row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.app_ios')}}</label>
                                                                <input type="text" class="form-control border-primary"
                                                                          placeholder="{{__('msg.app_ios')}}"
                                                                          name="app_ios" value="{{$setting->app_ios}}">
                                                            </div>
                                                            <div class="form-group container row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.app_title_ar')}}</label>
                                                                <input type="text" class="form-control border-primary"
                                                                          placeholder="{{__('msg.app_title_ar')}}"
                                                                          name="app_title_ar" value="{{$setting->app_title_ar}}">
                                                            </div>
                                                            <div class="form-group container row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.app_title_en')}}</label>
                                                                <input type="text" class="form-control border-primary"
                                                                          placeholder="{{__('msg.app_title_en')}}"
                                                                          name="app_title_en" value="{{$setting->app_title_en}}">
                                                            </div>
                                                            <div class="form-group container row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.app_desc_ar')}}</label>
                                                                <textarea rows="5" class="form-control border-primary"
                                                                          placeholder="{{__('msg.app_desc_ar')}}"
                                                                          name="app_desc_ar">{{$setting->app_desc_ar}}</textarea>
                                                            </div>
                                                            <div class="form-group container row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.app_desc_en')}}</label>
                                                                <textarea rows="5" class="form-control border-primary"
                                                                          placeholder="{{__('msg.app_desc_en')}}"
                                                                          name="app_desc_en">{{$setting->app_desc_en}}</textarea>

                                                            </div>
                                                            <hr>
                                                            <div class="form-group container row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.footer_text_ar')}}</label>
                                                                <textarea rows="5" class="form-control border-primary"
                                                                          placeholder="{{__('msg.footer_text_ar')}}"
                                                                          name="footer_text_ar">{{$setting->footer_text_ar}}</textarea>
                                                            </div>
                                                            <div class="form-group container row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.footer_text_en')}}</label>
                                                                <textarea rows="5" class="form-control border-primary"
                                                                          placeholder="{{__('msg.footer_text_en')}}"
                                                                          name="footer_text_en">{{$setting->footer_text_en}}</textarea>

                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="activePolicy" role="tabpanel"
                                                             aria-labelledby="activePolicy-tab1"
                                                             aria-expanded="false">
                                                            <div class="row container mt-2">
                                                                <?php $partners_files = isset($setting->files) && count($setting->files) > 0 ? $setting->files()->where('type','=','partners')->get() : [] ?>
                                                                @if(count($partners_files) > 0)
                                                                    @foreach($partners_files as $file)
                                                                        <div class="col-md-3 mt-2 row_{{$file->id}}">
                                                                            <span style="position: absolute ;margin: -18px;" item_id="{{$file->id}}" class="la la-trash text-danger delete_file cursor-pointer"></span>
                                                                            <img src="{{asset('public'.$file->file_path)}}" style="width: 80px">
                                                                        </div>
                                                                    @endforeach
                                                                @endif

                                                            </div>
                                                            <div class="form-group container row mt-2">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.partners')}}</label>
                                                                <input type="file" multiple class="form-control border-primary"
                                                                       placeholder="{{__('msg.partners')}}"
                                                                       name="files[]">
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="activeAppImages" role="tabpanel"
                                                             aria-labelledby="activeAppImages-tab1"
                                                             aria-expanded="false">
                                                            <div class="row container mt-2">
                                                                <?php $app_files = isset($setting->files) && count($setting->files) > 0 ? $setting->files()->where('type','=','app_files')->get() : [] ?>
                                                                @if(count($app_files) > 0)
                                                                    @foreach($app_files as $file)
                                                                        <div class="col-md-3 mt-2 row_{{$file->id}}">
                                                                            <span style="position: absolute ;margin: -18px;" item_id="{{$file->id}}" class="la la-trash text-danger delete_file cursor-pointer"></span>
                                                                            <img src="{{asset('public'.$file->file_path)}}" style="width: 80px">
                                                                        </div>
                                                                    @endforeach
                                                                @endif

                                                            </div>
                                                            <div class="form-group container row mt-2">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.app_images')}}</label>
                                                                <input type="file" multiple class="form-control border-primary"
                                                                       placeholder="{{__('msg.app_images')}}"
                                                                       name="app_files[]">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-actions">
                                                    <button type="submit"
                                                            class="btn btn-primary btn-block text-center">
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

@section('scripts')

    <script>
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
