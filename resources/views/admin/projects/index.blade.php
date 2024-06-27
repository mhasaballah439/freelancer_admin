@extends('admin.layouts.app')
@section('title','Projects')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section id="file-export">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                @if(admin()->check_route_permission('admin.projects.index') == 1)
                                    <div class="card-header" style="padding-bottom: 0px">
                                        <h4 class="card-title">{{__('msg.projects')}}</h4>
                                        <form method="get ">
                                            <div class="row mt-2">
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="label-control">{{__('msg.category')}}</label>

                                                        <select class="select2 form-control" name="category">
                                                            <option value="">{{__('msg.select_category')}}</option>
                                                            @if(count($categories) > 0)
                                                                @foreach($categories as $cat)
                                                                    <option
                                                                        value="{{$cat->id}}" {{ $cat->id == request()->get('category') ? 'selected' : ''}}>{{$cat->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="label-control">{{__('msg.business_owner')}}</label>
                                                        <select class="select2 form-control" name="business_owner">
                                                            <option value="">{{__('msg.select_business_owner')}}</option>
                                                            @if(count($business_owners) > 0)
                                                                @foreach($business_owners as $business_owner)
                                                                    <option value="{{$business_owner->id}}" {{ $business_owner->id == request()->get('category') ? 'selected' : ''}}>{{$business_owner->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit"
                                                            class="btn btn-primary mt-2">{{__('msg.search')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                        <a class="heading-elements-toggle"><i
                                                class="la la-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                @if(admin()->check_route_permission('admin.projects.create') == 1)
                                                    <li>
                                                        <a href="{{route('admin.projects.create')}}"
                                                           style="border-radius: 10px;padding: 10px"
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
                                            <table class="table table-striped table-responsive table-bordered file-export">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">{{__('msg.freelancer')}}</th>
                                                    <th class="text-center">{{__('msg.business_owner')}}</th>
                                                    <th class="text-center">{{__('msg.title')}}</th>
                                                    <th class="text-center">{{__('msg.category')}}</th>
                                                    <th class="text-center">{{__('msg.status')}}</th>
                                                    <th class="text-center">{{__('msg.work_period_days')}}</th>
                                                    <th class="text-center">{{__('msg.from_price')}}</th>
                                                    <th class="text-center">{{__('msg.to_price')}}</th>
                                                    <th class="text-center">{{__('msg.action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($projects as $project)
                                                    <tr class="row_{{$project->id}}">
                                                        <td class="text-center">{{$project->id}}</td>
                                                        <td class="text-center">{{$project->freelancer->name ?? '-'}}</td>
                                                        <td class="text-center">{{$project->business_owner->name ?? '-'}}</td>
                                                        <td class="text-center">{{$project->title}}</td>
                                                        <td class="text-center">{{$project->category->name ?? '-'}}</td>
                                                        <td class="text-center">{{$project->status_name}}</td>
                                                        <td class="text-center">{{$project->work_period_days}}</td>
                                                        <td class="text-center">{{(float)$project->from_price}}</td>
                                                        <td class="text-center">{{(float)$project->to_price}}</td>
                                                        <td class="d-flex align-items-center justify-content-sm-center">
                                                            @if(admin()->check_route_permission('admin.projects.delete') == 1)
                                                                <a href="#" item_id="{{$project->id}}"
                                                                   class="item_delete btn btn-danger btn-sm">
                                                                    <i class="la la-trash"></i></a>
                                                            @endif
                                                            @if(admin()->check_route_permission('admin.projects.show') == 1)
                                                                <a href="{{route('admin.projects.show',$project-> id)}}"
                                                                   class="block-page ml-1 btn btn-warning btn-sm"><i
                                                                        class="la la-eye"></i></a>
                                                            @endif
                                                                @if(admin()->check_route_permission('admin.projects.edit') == 1)
                                                                <a href="{{route('admin.projects.edit',$project-> id)}}"
                                                                   class="block-page ml-1 btn btn-primary btn-sm"><i
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
                    <div class="form-group">
                        <label class="label-control"
                               for="name">{{__('msg.delete_cause')}}</label>

                        <textarea rows="3"
                                  class="form-control border-primary"
                                  id="delete_cause"
                                  placeholder="{{__('msg.delete_cause')}}"
                                  name="delete_cause" required>{{ old('delete_cause') }}</textarea>
                        <span class="text-danger d-none" id="delete_cause_error">Filed is required</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary"
                            data-dismiss="modal">{{__('msg.back')}}</button>
                    <button type="button" class="btn btn-outline-danger confirm_delete">{{__('msg.confirm')}}</button>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="d-none" id="type-success">Success</button>
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css"
          href="{{asset('public/assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/css/forms/selects/select2.min.css')}}">
    <style>
        .select2-container--default {
            width: 100% !important;
        }
</style>
@endsection
@section('scripts')
<script src="{{asset('public/assets/vendors/js/tables/datatable/datatables.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/tables/datatable/dataTables.buttons.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/tables/buttons.html5.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/js/tables/buttons.print.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/scripts/tables/datatables/datatable-advanced.js')}}"
            type="text/javascript"></script>
<script src="{{asset('public/assets/vendors/js/forms/select/select2.full.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('public/assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
    <script>
        $(document).on('click', '.item_delete', function () {
            $('#deleteItem').modal('show');
            var item_id = $(this).attr('item_id')

            $(document).on('click', '.confirm_delete', function () {
                var delete_cause = $('#delete_cause').val();
                console.log(delete_cause);
                if (delete_cause.trim() === '') {
                    $('#delete_cause_error').removeClass('d-none')
                } else {
                    $('#delete_cause_error').addClass('d-none')

                    $.ajax({
                        type: 'post',
                        url: "{{route('admin.projects.delete')}}",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'id': item_id,
                            'delete_cause': delete_cause
                        },
                        success: function (data) {

                            if (data.status == true) {
                                $('#success_msg').show();
                                $('#deleteItem').modal('hide');
                                $('#delete_cause').text('');
                                $('.row_' + data.id).remove();
                            }
                        }, error: function (reject) {

                        }
                    })
                }
            })

        });
    </script>

@endsection
