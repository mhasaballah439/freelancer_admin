@extends('admin.layouts.app')
@section('title','Transactions')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section id="file-export">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                @if(admin()->check_route_permission('admin.transactions.index') == 1)
                                    <div class="card-header" style="padding-bottom: 0px">
                                        <h4 class="card-title">{{__('msg.transactions')}}</h4>
                                        <a class="heading-elements-toggle"><i
                                                class="la la-ellipsis-v font-medium-3"></i></a>
                                        <form metho="get" class="mt-1">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="label-control" for="name">{{__('msg.filter')}}</label>
                                                    <select class="form-control" name="status" onchange="this.form.submit()">
                                                        <option value="" >{{__('msg.select_status')}}</option>
                                                        <option value="1" {{request('status') == 1 ? 'selected' : ''}}>{{__('msg.pending')}}</option>
                                                        <option value="2" {{request('status') == 2 ? 'selected' : ''}}>{{__('msg.approved')}}</option>
                                                        <option value="3" {{request('status') == 3 ? 'selected' : ''}}>{{__('msg.rejected')}}</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </form>
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
                                    <div class="card-content collapse show" style="margin-top: -12px">
                                        <div class="card-body card-dashboard">
                                            <table class="table table-hover table-responsive table-responsive-xl table-bordered file-export">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">{{__('msg.status')}}</th>
                                                    <th class="text-center">{{__('msg.project')}}</th>
                                                    <th class="text-center">{{__('msg.freelancer')}}</th>
                                                    <th class="text-center">{{__('msg.business_owner')}}</th>
                                                    <th class="text-center">{{__('msg.type')}}</th>
                                                    <th class="text-center">{{__('msg.payment')}}</th>
                                                    <th class="text-center">{{__('msg.price')}}</th>
                                                    <th class="text-center">{{__('msg.created_at')}}</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($transactions as $transaction)
                                                    <tr>
                                                        <td class="text-center">#{{$transaction->id}}</td>
                                                        <td class="text-center status_{{$transaction->id}}">
                                                            @if($transaction->status_id == 1 || $transaction->status_id == 0)
                                                                <select class="form-group change_status">
                                                                    <option value="1"
                                                                            transaction_id="{{$transaction->id}}" {{$transaction->status_id == 1 ? 'selected' : ''}}>{{__('msg.pending')}}</option>
                                                                    <option value="2"
                                                                            transaction_id="{{$transaction->id}}" {{$transaction->status_id == 2 ? 'selected' : ''}}>{{__('msg.approved')}}</option>
                                                                    <option value="3"
                                                                            transaction_id="{{$transaction->id}}" {{$transaction->status_id == 3 ? 'selected' : ''}}>{{__('msg.rejected')}}</option>
                                                                </select>
                                                            @else
                                                                {{$transaction->status_name}}
                                                            @endif
                                                        </td>
                                                        <td class="text-center">{{$transaction->project->name ?? '-'}}</td>
                                                        <td class="text-center">{{$transaction->freelancer->name ?? '-'}}</td>
                                                        <td class="text-center">{{$transaction->business_owner->name ?? '-'}}</td>
                                                        <td class="text-center">{{$transaction->type_name}}</td>
                                                        <td class="text-center">{{$transaction->payment}}</td>
                                                        <td class="text-center">{{(float)$transaction->price}}</td>
                                                        <td class="text-center">{{date('d/m/Y H:i',strtotime($transaction->created_at))}}</td>

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
    <button type="button" class="d-none" id="type-success">Success</button>
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css"
          href="{{asset('public/assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css-rtl/plugins/extensions/toastr.css')}}">
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
    <script src="{{asset('public/assets/vendors/js/extensions/toastr.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).on('change', '.change_status', function () {
            $('#deleteItem').modal('show');
            var item_id = $(this).find('option:selected').attr('transaction_id');
            var status_id = $(this).find('option:selected').val();

            $.ajax({
                type: 'post',
                url: "{{route('admin.change_transaction_status')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': item_id,
                    'status_id': status_id
                },
                success: function (data) {

                    if (data.status == true) {
                        toastr.success('تم تغيير الحالة بنجاح');
                        $('.status_' + data.id).text(data.status_name);
                    }
                }, error: function (reject) {

                }
            })

        });
    </script>
@endsection
