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
                                @if(admin()->check_route_permission('admin.settings.edit') == 1)
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
                                            <form class="form" action="{{route('admin.settings.update')}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            <div class="form-body">
                                                <h4 class="form-section"></h4>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 label-control"
                                                                   for="name">{{__('msg.logo')}}</label>
                                                            <div class="avatar-upload">
                                                                <div class="avatar-edit">
                                                                    <input type="file" name="logo" id="imageUpload"
                                                                           required
                                                                           accept=".png, .jpg, .jpeg"/>
                                                                    <label for="imageUpload" class="imageUploadlabel"><i
                                                                            class="la la-pencil edit_user"></i></label>
                                                                </div>
                                                                <div class="avatar-preview">
                                                                    <div id="imagePreview"
                                                                         style="background-image: url({{asset('public/'.$setting->logo)}});">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 label-control"
                                                                   for="name">{{__('msg.fav_icon')}}</label>
                                                            <div class="avatar-upload">
                                                                <div class="avatar-edit">
                                                                    <input type="file" name="fav_icon" id="imageUploadFav"
                                                                           required
                                                                           accept=".png, .jpg, .jpeg"/>
                                                                    <label for="imageUploadFav" class="imageUploadlabel"><i
                                                                            class="la la-pencil edit_user"></i></label>
                                                                </div>
                                                                <div class="avatar-preview">
                                                                    <div id="imagePreviewFav"
                                                                         style="background-image: url({{asset('public/'.$setting->fav_icon)}});">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 label-control">{{__('msg.phone')}}</label>
                                                            <div class="col-md-9">
                                                                <input type="text"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.phone')}}"
                                                                       value="{{$setting->phone }}"
                                                                       name="phone">
                                                                @error('hone')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 label-control">{{__('msg.email')}}</label>
                                                            <div class="col-md-9">
                                                                <input type="text"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.email')}}"
                                                                       value="{{ $setting->email}}"
                                                                       name="email">
                                                                @error('email')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 label-control">{{__('msg.whatsapp')}}</label>
                                                            <div class="col-md-9">
                                                                <input type="text"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.whatsapp')}}"
                                                                       value="{{ $setting->whatsapp}}"
                                                                       name="whatsapp">
                                                                @error('whatsapp')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 label-control">{{__('msg.facebook')}}</label>
                                                            <div class="col-md-9">
                                                                <input type="text"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.facebook')}}"
                                                                       value="{{ $setting->facebook}}"
                                                                       name="facebook">
                                                                @error('facebook')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 label-control">{{__('msg.instagram')}}</label>
                                                            <div class="col-md-9">
                                                                <input type="text"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.instagram')}}"
                                                                       value="{{ $setting->instagram}}"
                                                                       name="instagram">
                                                                @error('instagram')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 label-control">{{__('msg.twitter')}}</label>
                                                            <div class="col-md-9">
                                                                <input type="text"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.twitter')}}"
                                                                       value="{{ $setting->twitter}}"
                                                                       name="twitter">
                                                                @error('twitter')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 label-control">{{__('msg.profit_rate')}}</label>
                                                            <div class="col-md-9">
                                                                <input type="number"
                                                                       step="any"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.profit_rate')}}"
                                                                       value="{{ (float)$setting->profit_rate}}"
                                                                       name="profit_rate">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 label-control">{{__('msg.min_project_price')}}</label>
                                                            <div class="col-md-9">
                                                                <input type="number"
                                                                       step="any"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.min_project_price')}}"
                                                                       value="{{ (float)$setting->min_project_price}}"
                                                                       name="min_project_price">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="label-control col-md-3">{{__('msg.tax')}}</label>
                                                            <div class="col-md-9">
                                                            <select class="select2 form-control" name="tax">
                                                                @for($i = 0 ; $i <= 100 ;$i++)
                                                                    <option value="{{$i}}" {{ $setting->tax == $i ? 'selected' : ''}}>{{$i}}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="activeAr-tab1"
                                                               data-toggle="tab" href="#activeTerms"
                                                               aria-controls="activeTerms" aria-expanded="true">
                                                                {{__('msg.terms_conditions')}}</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="activeEn-tab1" data-toggle="tab"
                                                               href="#activePolicy" aria-controls="activePolicy"
                                                               aria-expanded="false">{{__('msg.policy')}}</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="activeEn-tab1" data-toggle="tab"
                                                               href="#activeFooter" aria-controls="activeFooter"
                                                               aria-expanded="false">{{__('msg.about_us')}} </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="activeEn-tab1" data-toggle="tab"
                                                               href="#activeSeo" aria-controls="activeSeo"
                                                               aria-expanded="false">{{__('msg.seo')}} </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="activeEn-tab1" data-toggle="tab"
                                                               href="#activestring_text" aria-controls="activestring_text"
                                                               aria-expanded="false">{{__('msg.string_text')}} </a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content px-1 pt-1">
                                                        <div role="tabpanel" class="tab-pane active" id="activeTerms"
                                                             aria-labelledby="activeTerms-tab1"
                                                             aria-expanded="true">
                                                            <div class="form-group row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.terms_conditions_ar')}}</label>
                                                                <textarea rows="5" class="form-control border-primary summernote"
                                                                          placeholder="{{__('msg.terms_conditions_ar')}}"
                                                                          name="terms_conditions_ar">{{$setting->terms_conditions_ar}}</textarea>
                                                                @error('terms_conditions_ar')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror

                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.terms_conditions_en')}}</label>
                                                                <textarea rows="5" class="form-control border-primary summernote"
                                                                          placeholder="{{__('msg.terms_conditions_en')}}"
                                                                          name="terms_conditions_en">{{$setting->terms_conditions_en}}</textarea>
                                                                @error('terms_conditions_en')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror

                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="activePolicy" role="tabpanel"
                                                             aria-labelledby="activePolicy-tab1"
                                                             aria-expanded="false">
                                                            <div class="form-group row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.policy_ar')}}</label>
                                                                <textarea rows="5" class="form-control border-primary summernote"
                                                                          placeholder="{{__('msg.policy_ar')}}"
                                                                          name="policy_ar">{{$setting->policy_ar}}</textarea>
                                                                @error('policy_ar')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror

                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.policy_en')}}</label>
                                                                <textarea rows="5" class="form-control border-primary summernote"
                                                                          placeholder="{{__('msg.policy_en')}}"
                                                                          name="policy_en">{{$setting->policy_en}}</textarea>
                                                                @error('policy_en')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror

                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="activeFooter" role="tabpanel"
                                                             aria-labelledby="activeFooter-tab1"
                                                             aria-expanded="false">
                                                            <div class="form-group row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.about_us')}}</label>
                                                                <textarea rows="5" class="form-control border-primary summernote"
                                                                          placeholder="{{__('msg.about_us')}}"
                                                                          name="about_us_ar">{{$setting->about_us_ar}}</textarea>
                                                                @error('about_us_ar')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror

                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.about_us')}}</label>
                                                                <textarea rows="5" class="form-control border-primary summernote"
                                                                          placeholder="{{__('msg.about_us_en')}}"
                                                                          name="about_us_en">{{$setting->about_us_en}}</textarea>
                                                                @error('about_us_en')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror

                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="activeSeo" role="tabpanel"
                                                             aria-labelledby="activeSeo-tab1"
                                                             aria-expanded="false">
                                                            <div class="form-group row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.seo_title')}}</label>
                                                                <input type="text" id="seo_title"
                                                                       class="form-control border-primary"
                                                                       placeholder="{{__('msg.seo_title')}}"
                                                                       value="{{$setting->seo_title}}"
                                                                       name="seo_title">
                                                                @error('title_en')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror

                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.seo_desc')}}</label>
                                                                <textarea rows="3" class="form-control border-primary"
                                                                          placeholder="{{__('msg.seo_desc')}}"
                                                                          name="seo_desc">{{$setting->seo_desc}}</textarea>
                                                                @error('seo_desc')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror

                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="label-control"
                                                                       for="url">{{__('msg.seo_keyword')}}</label>
                                                                <textarea rows="3" class="form-control border-primary"
                                                                          placeholder="{{__('msg.seo_keyword')}}"
                                                                          name="seo_keyword">{{$setting->seo_keyword}}</textarea>
                                                                @error('seo_keyword')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror

                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="activestring_text" role="tabpanel"
                                                             aria-labelledby="activestring_text-tab1"
                                                             aria-expanded="false">

                                                            <section class="mt-2" id="form-repeater">

                                                                <div class="repeater-default container">
                                                                    <div data-repeater-list="string_text">
                                                                        @if($setting->string_text && $setting->string_text != 'null')
                                                                            @foreach(json_decode($setting->string_text) as $item)
                                                                                <div class="d-flex align-items-center container" data-repeater-item>
                                                                                    <div class="row">
                                                                                        <div class="form-group col-md-4">
                                                                                            <label
                                                                                                for="email-addr">{{__('msg.code')}}</label>
                                                                                            <br>
                                                                                            <input type="text"
                                                                                                   class="form-control"
                                                                                                   name="code" value="{{$item->code}}" placeholder="{{__('msg.code')}}">
                                                                                        </div>
                                                                                        <div class="form-group col-md-4">
                                                                                            <label
                                                                                                for="email-addr">{{__('msg.name_ar')}}</label>
                                                                                            <br>
                                                                                            <input type="text"
                                                                                                   class="form-control"
                                                                                                   name="name_ar" value="{{$item->name_ar}}" placeholder="{{__('msg.name_ar')}}">
                                                                                        </div>

                                                                                        <div class="form-group col-md-4">
                                                                                            <label
                                                                                                for="email-addr">{{__('msg.name_en')}}</label>
                                                                                            <br>
                                                                                            <input type="text"
                                                                                                   class="form-control"
                                                                                                   name="name_en" value="{{$item->name_en}}" placeholder="{{__('msg.name_en')}}">
                                                                                        </div>

                                                                                    </div>
                                                                                    <hr>
                                                                                </div>

                                                                            @endforeach
                                                                        @else
                                                                            <div class="d-flex align-items-center container" data-repeater-item>
                                                                                <div class="row">
                                                                                    <div class="form-group col-md-4">
                                                                                        <label
                                                                                            for="email-addr">{{__('msg.code')}}</label>
                                                                                        <br>
                                                                                        <input type="text"
                                                                                               class="form-control"
                                                                                               name="code" placeholder="{{__('msg.code')}}">
                                                                                    </div>
                                                                                    <div class="form-group col-md-4">
                                                                                        <label
                                                                                            for="email-addr">{{__('msg.name_ar')}}</label>
                                                                                        <br>
                                                                                        <input type="text"
                                                                                               class="form-control"
                                                                                               name="name_ar" placeholder="{{__('msg.name_ar')}}">
                                                                                    </div>

                                                                                    <div class="form-group col-md-4">
                                                                                        <label
                                                                                            for="email-addr">{{__('msg.name_en')}}</label>
                                                                                        <br>
                                                                                        <input type="text"
                                                                                               class="form-control"
                                                                                               name="name_en" placeholder="{{__('msg.name_en')}}">
                                                                                    </div>

                                                                                </div>
                                                                                <hr>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="form-group overflow-hidden">
                                                                        <div class="col-12">
                                                                            <button type="button"
                                                                                    data-repeater-create=""
                                                                                    class="btn btn-primary">
                                                                                <i class="ft-plus"></i> {{__('msg.add_string')}}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
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
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/css/editors/summernote.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/css/forms/selects/select2.min.css')}}">
    <style>
        .select2-container--default {
            width: 100% !important;
        }
        .flatpickr{
            padding: 6px;
        }

        .note-editor.note-frame.panel.panel-default{
            width: 100%;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{asset('public/assets/js/file_upload.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/editors/summernote/summernote.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/forms/select/select2.full.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('public/assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('public/assets/js/scripts/forms/form-repeater.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                tabsize: 2,
                height: 300,
            });
        })

    </script>
@endsection
