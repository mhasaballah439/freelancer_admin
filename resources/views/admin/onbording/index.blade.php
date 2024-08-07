@extends('admin.layouts.app')
@section('title','Onbording')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section id="file-export">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                @if(admin()->check_route_permission('admin.onbording.index') == 1)
                                <div class="card-header" style="padding-bottom: 0px">
                                    <h4 class="card-title">{{__('msg.slider')}}</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            @if(admin()->check_route_permission('admin.onbording.create') == 1)
                                                <li>
                                                    <a href="{{route('admin.onbording.create')}}" style="border-radius: 10px;padding: 10px"
                                                       class="btn-info block-page">
                                                        {{__('msg.create')}}
                                                    </a>
                                                </li>
                                            @endif
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('admin.layouts.alerts.success')
                                @include('admin.layouts.alerts.errors')
                                <div class="card-content collapse show" style="margin-top: -12px">
                                    <div class="card-body card-dashboard">
                                            <table class="table table-striped table-bordered file-export">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">{{__('msg.title')}}</th>
                                                    <th class="text-center">{{__('msg.active')}}</th>
                                                    <th class="text-center">{{__('msg.action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($onbording as $onbord)
                                                    <tr class="row_{{$onbord->id}}">
                                                        <td class="text-center">
                                                            <img src="{{asset('public/'.$onbord->image)}}" width="70px">
                                                        </td>
                                                        <td class="text-center">{{$onbord->title}}</td>
                                                        <td class="text-center">
                                                            @if(admin()->check_route_permission('admin.onbording.update.status') == 1)
                                                            <div class="form-group pb-1">
                                                                <input type="checkbox" item_id="{{$onbord->id}}" name="active"
                                                                       class="switch active_item" id="switch{{$onbord->id}}"
                                                                    {{$onbord->active == 1 ? 'checked' : ''}}/>
                                                            </div>
                                                            @else
                                                                {{$onbord->active == 1 ? __('msg.active') : __('msg.inactive')}}
                                                            @endif
                                                        </td>

                                                        <td class="d-flex align-items-center justify-content-sm-center">
                                                            @if(admin()->check_route_permission('admin.onbording.delete') == 1)
                                                            <a href="#" item_id="{{$onbord->id}}" class="delete_item btn-sm btn btn-danger">
                                                                <i class="la la-trash"></i></a>
                                                            @endif
                                                                @if(admin()->check_route_permission('admin.onbording.edit') == 1)
                                                            <a href="{{route('admin.onbording.edit',$onbord-> id)}}"
                                                               class="block-page ml-2 btn-sm btn btn-primary"><i
                                                                    class="la la-pencil"></i></a>
                                                                @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
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
    <button type="button" class="d-none" id="type-success">Success</button>
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css-rtl/plugins/extensions/toastr.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('public/assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/tables/datatable/dataTables.buttons.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/tables/buttons.html5.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/tables/buttons.print.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/scripts/tables/datatables/datatable-advanced.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/extensions/toastr.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/scripts/extensions/toastr.js')}}" type="text/javascript"></script>
    <script>
        $(document).on('click','.delete_item',function (){
            $('#deleteItem').modal('show');
            var item_id = $(this).attr('item_id')
            $(document).on('click','.confirm_delete',function (){
                $.ajax({
                    type : 'post',
                    url: "{{route('admin.onbording.delete')}}",
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
        $(document).on('change','.active_item',function (){
            var item_id = $(this).attr('item_id');
            var active = $(this).is(':checked');
            console.log(active)
                $.ajax({
                    type : 'post',
                    url: "{{route('admin.onbording.update.status')}}",
                    data:{
                        '_token' : "{{csrf_token()}}",
                        'id' : item_id,
                        'active' : active,
                    },
                    success: function (data) {

                        if (data.status == true) {
                            $('#type-success').click();
                        }
                    }
                })
        });
    </script>
@endsection
