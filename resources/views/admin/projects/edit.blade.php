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
                                @if(admin()->check_route_permission('admin.projects.edit') == 1)
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
                                    @include('admin.layouts.alerts.success')
                                    @include('admin.layouts.alerts.errors')
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            @if($project)
                                                <form class="form"
                                                      action="{{route('admin.projects.update',$project->id)}}"
                                                      method="post"
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
                                                                           value="{{ $project->title }}"
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
                                                                              name="desc" required>{{ $project->desc }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group ">
                                                                    <label class="label-control">{{__('msg.category')}}</label>

                                                                    <select class="select2 form-control" name="category_id">
                                                                        @if(count($categories) > 0)
                                                                            @foreach($categories as $cat)
                                                                                <option
                                                                                    value="{{$cat->id}}" {{$project->category_id == $cat->id ? 'selected' : ''}}>{{$cat->name}}</option>
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
                                                                                <option value="{{$business_owner->id}}" {{$project->business_owner_id == $business_owner->id ? 'selected' : ''}}>{{$business_owner->name}}</option>
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
                                                                           value="{{ $project->work_period_days }}"
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
                                                                           value="{{ (float)$project->from_price }}"
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
                                                                           value="{{ (float)$project->to_price }}"
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
                                                                                <option value="{{$skill->id}}" {{$project->skills && is_array(json_decode($project->skills)) && in_array($skill->id,json_decode($project->skills)) ? 'selected' : ''}}>{{$skill->name}}</option>
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
                                                                                <option value="{{$freelancer->id}}" {{$project->freelancer_id == $freelancer->id ? 'selected' : ''}}>{{$freelancer->name}}</option>
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
                                                                        <option value="1" {{$project->status_id == 1 ? 'selected' : ''}}>{{__('msg.open')}}</option>
                                                                        <option value="2" {{$project->status_id == 2 ? 'selected' : ''}}>{{__('msg.ongoing')}}</option>
                                                                        <option value="3" {{$project->status_id == 3 ? 'selected' : ''}}>{{__('msg.completed')}}</option>
                                                                        <option value="4" {{$project->status_id == 4 ? 'selected' : ''}}>{{__('msg.canceled')}}</option>
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
                                                                @if(isset($project->files))
                                                                    <ul>
                                                                        @foreach($project->files as $file)
                                                                            <li class="row_{{$file->id}}"><a href="{{asset('public'.$file->file_path)}}" target="_blank">{{$file->file_name}}</a> <span item_id="{{$file->id}}" class="la la-trash text-danger delete_file cursor-pointer"></span></li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-12 mt-1">
                                                                <h4 class="text-center">{{__('msg.offers')}}</h4>
                                                                <hr>
                                                            </div>
                                                            <table
                                                                class="table table-striped table-bordered dom-jQuery-events">
                                                                <thead>
                                                                <tr>
                                                                    <th class="text-center">{{__('msg.freelancer')}}</th>
                                                                    <th class="text-center">{{__('msg.work_period_days')}}</th>
                                                                    <th class="text-center">{{__('msg.price')}}</th>
                                                                    <th class="text-center">{{__('msg.desc')}}</th>
                                                                    <th class="text-center">{{__('msg.action')}}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tableTimes">
                                                                @if(isset($project->offers) && count($project->offers) > 0)
                                                                    @foreach($project->offers as $item)
                                                                        <tr class="row_{{$item->id}}">
                                                                            <td class="text-center">{{$item->freelancer->name ?? ''}}</td>
                                                                            <td class="text-center">{{$item->work_period_days}}</td>
                                                                            <td class="text-center">{{(float)$item->price}}</td>
                                                                            <td class="text-center">{{mb_strimwidth($item->desc,0,200,'....')}}</td>
                                                                            <td class="d-flex align-items-center justify-content-sm-center">
                                                                                <button type="button" item_id="{{$item->id}}" class="item_delete btn-sm btn btn-danger">
                                                                                    <i class="la la-trash"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                            </table>
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
    <link rel="stylesheet" type="text/css"
          href="{{asset('public/assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <style>
        .select2-container--default {
            width: 100% !important;
        }
        #DataTables_Table_0_wrapper {
            margin-top: 10px;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{asset('public/assets/vendors/js/tables/datatable/datatables.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('public/assets/js/scripts/tables/datatables/datatable-advanced.js')}}"
            type="text/javascript"></script>

    <script src="{{asset('public/assets/vendors/js/forms/select/select2.full.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('public/assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>

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

        $(document).on('click','.item_delete',function (){
            $('#deleteItem').modal('show');
            var item_id = $(this).attr('item_id')
            $(document).on('click','.confirm_delete',function (){
                $.ajax({
                    type : 'post',
                    url: "{{route('admin.offer.delete')}}",
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
