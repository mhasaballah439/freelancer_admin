@extends('admin.layouts.app')
@section('title','Projects')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            @if($project)
                @if(admin()->check_route_permission('admin.projects.show') == 1)
                    <div class="content-header row">
                        <div class="content-header-left col-md-6 col-12 mb-2">
                            <h3 class="content-header-title">{{$project->title}}</h3>
                            <div class="row breadcrumbs-top">
                                <div class="breadcrumb-wrapper col-12">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a
                                                href="{{route('dashboard.index')}}">{{__('msg.dashboard')}} </a>
                                        </li>
                                        <li class="breadcrumb-item"><a
                                                href="{{route('admin.projects.index')}}">{{__('msg.projects')}}</a>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-detached content-left">
                        <div class="content-body">
                            <section class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-head">
                                            <div class="card-header">
                                                <h4 class="card-title">{{$project->title}}</h4>
                                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                <div class="heading-elements">
                                                    @if(count($project->skills_list) > 0)
                                                        @foreach($project->skills_list as $skill)
                                                            <span class="badge badge-default badge-success">{{$skill->name}}</span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="px-1">
                                                <ul class="list-inline list-inline-pipe text-center p-1 border-bottom-grey border-bottom-lighten-3">
                                                    <li>{{__('msg.business_owner')}}:
                                                        <span class="text-muted">{{$project->business_owner->name ?? '-'}}</span>
                                                    </li>
                                                    <li>{{__('msg.start_date')}}:
                                                        <span class="text-muted">{{date('d/m/Y',strtotime($project->st_date))}}</span>
                                                    </li>
                                                    <li>{{__('msg.end_date')}}:
                                                        <span class="text-muted">{{date('d/m/Y',strtotime($project->end_date))}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- project-info -->
                                        <div id="project-info" class="card-body row">
                                            <div class="project-info-count col-lg-4 col-md-12">
                                                <div class="project-info-icon">
                                                    <h2>{{isset($project->offers) && count($project->offers) > 0 ? count($project->offers) : 0}}</h2>
                                                    <div class="project-info-sub-icon">
                                                        <span class="la la-user"></span>
                                                    </div>
                                                </div>
                                                <div class="project-info-text pt-1">
                                                    <h5>{{__('msg.offers')}}</h5>
                                                </div>
                                            </div>
                                            <div class="project-info-count col-lg-4 col-md-12">
                                                <div class="project-info-icon">
                                                    <h2>1</h2>
                                                    <div class="project-info-sub-icon">
                                                        <span class="la la-calendar-check-o"></span>
                                                    </div>
                                                </div>
                                                <div class="project-info-text pt-1">
                                                    <h5>{{__('msg.project_phases')}}</h5>
                                                </div>
                                            </div>
                                            <div class="project-info-count col-lg-4 col-md-12">
                                                <div class="project-info-icon">
                                                    <h6>{{date('d/m/Y H:i',strtotime($project->created_at))}}</h6>
                                                    <div class="project-info-sub-icon">
                                                        <span class="la la-calendar-check-o"></span>
                                                    </div>
                                                </div>
                                                <div class="project-info-text pt-1">
                                                    <h5>{{__('msg.created_at')}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- project-info -->
                                        <div class="card-body">
                                            <div class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                                <span>{{__('msg.project_status')}}</span>
                                            </div>
                                            <div class="row py-2">
                                                <div class="col-lg-12 col-md-12">
                                                    @if($project->status_id == 1)
                                                        <div class="insights px-2">
                                                            <div>
                                                                <span class="text-info h3">20%</span>
                                                                <span class="h4 float-right">{{$project->status_name}}</span>
                                                            </div>
                                                            <div class="progress progress-md mt-1 mb-0">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                     style="width: 20%" aria-valuenow="20"
                                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    @elseif($project->status_id == 2)
                                                        <div class="insights px-2">
                                                            <div>
                                                                <span class="text-info h3">50%</span>
                                                                <span class="h4 float-right">{{$project->status_name}}</span>
                                                            </div>
                                                            <div class="progress progress-md mt-1 mb-0">
                                                                <div class="progress-bar bg-primary" role="progressbar"
                                                                     style="width: 50%" aria-valuenow="50"
                                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    @elseif($project->status_id == 3)
                                                        <div class="insights px-2">
                                                            <div>
                                                                <span class="text-info h3">100%</span>
                                                                <span class="h4 float-right">{{$project->status_name}}</span>
                                                            </div>
                                                            <div class="progress progress-md mt-1 mb-0">
                                                                <div class="progress-bar bg-success" role="progressbar"
                                                                     style="width: 100%" aria-valuenow="100"
                                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    @elseif($project->status_id == 4)
                                                        <div class="insights px-2">
                                                            <div>
                                                                <span class="text-info h3">0%</span>
                                                                <span class="h4 float-right">{{$project->status_name}}</span>
                                                            </div>
                                                            <div class="progress progress-md mt-1 mb-0">
                                                                <div class="progress-bar bg-danger" role="progressbar"
                                                                     style="width: 5%" aria-valuenow="5"
                                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Task Progress -->
                            <section class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header mb-0">
                                            <h4 class="card-title">{{__('msg.offers')}}</h4>
                                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-content">
                                                <div class="card-body  py-0 px-0">
                                                    <div class="list-group">
                                                        @if(isset($project->offers))
                                                            @foreach($project->offers as $offer)
                                                                <a href="{{route('admin.users.show',$offer->freelancer_id)}}" target="_blank" class="list-group-item">
                                                                    <div class="media">
                                                                        <div class="media-left pr-1">
                            <span class="avatar avatar-sm avatar-online rounded-circle">
                              <img src="{{isset($project->freelancer->image) ? asset('public'.$project->freelancer->image->file_path) : asset('public/assets/images/logo.png')}}" alt="avatar"><i></i></span>
                                                                        </div>
                                                                        <div class="media-body w-100">
                                                                            <h6 class="media-heading mb-0">{{$offer->freelancer->name ?? ''}}</h6>
                                                                        </div>
                                                                        <div class="media-body w-100">
                                                                            <h6 class="media-heading mb-0">{{$offer->price}} {{__('msg.sar')}}</h6>
                                                                        </div>
                                                                        <div class="media-body w-100">
                                                                            <h6 class="media-heading mb-0">{{mb_strimwidth($offer->desc,0,200,'....')}}</h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            @endforeach
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="sidebar-detached sidebar-right">
                        <div class="sidebar">
                            <div class="project-sidebar-content">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{__('msg.project_overview')}}</h4>
                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">

                                            <p>
                                                {{$project->desc}}
                                            </p>
                                            <p>
                                                <strong>{{__('msg.files')}}</strong>
                                            </p>
                                            @if(isset($project->files))
                                                <ol>
                                                    @foreach($project->files as $file)
                                                        <li><a href="{{asset('public'.$file->file_path)}}" target="_blank">{{$file->file_name}}</a></li>
                                                    @endforeach
                                                </ol>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @include('admin.layouts.alerts.error_perm')
                @endif
            @else
                <p class="alert alert-danger">{{__('msg.not_found')}}</p>
            @endif
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
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/pages/project.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('public/assets/js/scripts/pages/project-summary-task.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/scripts/pages/project-summary-bug.js')}}" type="text/javascript"></script>
@endsection
