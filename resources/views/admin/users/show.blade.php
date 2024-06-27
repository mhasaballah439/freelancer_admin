@extends('admin.layouts.app')
@section('title','Users')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            @if($user)
                <div class="content-body">
                    <div id="user-profile">
                        <div class="row">
                            <div class="col-12">
                                <div class="card profile-with-cover">
                                    <div class="card-img-top img-fluid bg-cover height-300"
                                         style="background: url({{asset('public/assets/images/freelancer.png')}});"></div>
                                    <div class="media profil-cover-details w-100">
                                        <div class="media-left pl-2 pt-2">
                                            @if(isset($user->image))
                                                <a href="#" class="profile-image">
                                                    <img src="{{asset('public'.$user->image->file_path)}}"
                                                         width="90px"
                                                         class="rounded-circle img-border height-100"
                                                         alt="Card image">
                                                </a>
                                            @endif
                                        </div>

                                        <div class="media-body pt-3 px-2">
                                            <div class="row">
                                                <div class="col">
                                                    <h3 class="card-title text-white">{{$user->name}} ({{$user->business_name}})</h3>
                                                </div>

                                                <div class="col text-right">
                                                    <div class="btn-group d-none d-md-block float-right ml-2"
                                                         role="group" aria-label="Basic example">
                                                        <a href="#" class="btn btn-success"
                                                           style="border: #28d094 !important;"><i
                                                                class="la la-dashcube"></i> {{__('msg.message')}}</a>
                                                        @if(admin()->check_route_permission('admin.users.edit') == 1)
                                                            <a href="{{route('admin.users.edit',$user-> id)}}"
                                                               class="btn btn-success"
                                                               style="border: #28d094 !important;"><i
                                                                    class="la la-cog"></i></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <nav class="navbar navbar-light navbar-profile align-self-end">
                                        <button class="navbar-toggler d-sm-none" type="button" data-toggle="collapse"
                                                aria-expanded="false"
                                                aria-label="Toggle navigation"></button>
                                        <div class="d-flex justify-content-center">
                                            @for($i = 1; $i<=5 ; $i++)
                                                <li class="la la-star" style="{{$user->stars >= $i ? 'color: #fdbe00e0;' : ''}}"></li>
                                            @endfor
                                            <span class="ml-1">({{$user->stars}})</span>
                                        </div>
                                        <nav class="navbar navbar-expand-lg">
                                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                                <ul class="navbar-nav mr-auto
                                                nav nav-tabs nav-linetriangle no-hover-bg nav-justified">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="active-tab1" data-toggle="tab"
                                                           href="#link1" aria-controls="link1"
                                                           aria-expanded="true">
                                                            <i class="la la-user"></i> {{__('msg.profile')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="link-tab2" data-toggle="tab"
                                                           href="#link2" aria-controls="link2"
                                                           aria-expanded="false"><i class="la la-briefcase"></i>
                                                            {{__('msg.projects')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="link-tab3" data-toggle="tab"
                                                           href="#link3" aria-controls="link3"
                                                           aria-expanded="false"><i class="la la-image"></i>
                                                            {{__('msg.portfolio')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="link-tab4" data-toggle="tab"
                                                           href="#link4" aria-controls="link4"
                                                           aria-expanded="false"><i class="la la-star"></i>
                                                            {{__('msg.rates')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="link-tab5" data-toggle="tab"
                                                           href="#link5" aria-controls="link5"
                                                           aria-expanded="false"
                                                        ><i class="la la-bell-o"></i>
                                                            {{__('msg.notifications')}}</a>
                                                    </li>
                                                </ul>

                                            </div>
                                        </nav>
                                    </nav>
                                    <div class="tab-content px-1 pt-1">
                                        <div role="tabpanel" class="tab-pane active" id="link1"
                                             aria-labelledby="active-tab1"
                                             aria-expanded="true">
                                            <div class="row">
                                                <div class="col-md-4 col-4">
                                                    <p>{{__('msg.email')}} : {{ $user->email }}</p>
                                                    <p>{{__('msg.phone')}} : {{ $user->phone }}</p>
                                                    <p>{{__('msg.is_confirm_phone')}}
                                                        : {{ $user->is_confirm_phone == 1 ? 'true' : 'false' }}</p>
                                                    <p>{{__('msg.birth_date')}}
                                                        : {{ $user->birth_date ? date('d/m/Y',strtotime($user->birth_date)) : ''}}</p>
                                                </div>
                                                <div class="col-md-4 col-4">
                                                    <p>{{__('msg.user_type')}} : {{ $user->user_type_name }}</p>
                                                    <p>{{__('msg.status_id')}} : {{ $user->status_name }}</p>
                                                    <p>{{__('msg.is_confirm_id')}}
                                                        : {{ $user->is_confirm_id == 1 ? 'true' : 'false' }}</p>
                                                </div>
                                                <div class="col-md-4 col-4">
                                                    <p>{{__('msg.country')}} : {{ $user->country->name ?? '' }}</p>
                                                    <p>{{__('msg.is_confirm_email')}}
                                                        : {{ $user->is_confirm_email == 1 ? 'true' : 'false' }}</p>
                                                    <p>{{__('msg.id_num')}}
                                                        : {{ $user->id_num }}</p>

                                                </div>
                                                <div class="col-md-4 col-4">
                                                    {{__('msg.tags')}} : @if(count($user->tags_list) > 0 )
                                                        <ul>
                                                            @foreach($user->tags_list as $tag)
                                                                <li>{{$tag->name}}</li>
                                                            @endforeach
                                                        </ul>
                                                        @endif
                                                </div>
                                                <div class="col-md-4 col-4">
                                                    {{__('msg.skills')}} : @if(count($user->skills_list) > 0 )
                                                        <ul>
                                                            @foreach($user->skills_list as $skill)
                                                                <li>{{$skill->name}}</li>
                                                            @endforeach
                                                        </ul>
                                                        @endif
                                                </div>
                                            </div>
                                            <p>
                                            <hr>
                                            </p>
                                            <p>{{ $user->about_me }}</p>
                                        </div>
                                        <div class="tab-pane" id="link2" role="tabpanel" aria-labelledby="link-tab2"
                                             aria-expanded="false">
                                            <table class="table table-striped table-bordered dom-jQuery-events">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">{{__('msg.business_owner')}}</th>
                                                    <th class="text-center">{{__('msg.title')}}</th>
                                                    <th class="text-center">{{__('msg.category')}}</th>
                                                    <th class="text-center">{{__('msg.status')}}</th>
                                                    <th class="text-center">{{__('msg.work_days')}}</th>
                                                    <th class="text-center">{{__('msg.price')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($projects as $project)
                                                    <tr class="row_{{$project->id}}">
                                                        <td class="text-center">{{$project->id}}</td>
                                                        <td class="text-center">{{$project->business_owner->name ?? '-'}}</td>
                                                        <td class="text-center">{{$project->title}}</td>
                                                        <td class="text-center">{{$project->category->name ?? '-'}}</td>
                                                        <td class="text-center">{{$project->status_name}}</td>
                                                        <td class="text-center">{{$project->freelancer_work_days}}</td>
                                                        <td class="text-center">{{(float)$project->work_price}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="link3" role="tabpanel" aria-labelledby="link-tab3"
                                             aria-expanded="false">
                                            <div class="row match-height">
                                                @if(isset($user->portfolio))
                                                    @foreach($user->portfolio as $portfilo)
                                                        <div class="col-xl-3 col-md-6 col-sm-12">
                                                            <div class="card" style="height: 438.641px;">
                                                                <div class="card-content">
                                                                    <img class="card-img-top img-fluid" src="{{isset($portfilo->image) ? asset('public'.$portfilo->image->file_path) : ''}}" alt="Card image cap">
                                                                    <div class="card-body">
                                                                        <h4 class="card-title">{{$portfilo->title}}</h4>
                                                                        <p class="card-text">{{substr($portfilo->desc, 0, 100)}}</p>
                                                                        <a href="{{$portfilo->url}}" class="card-link blue">{{__('msg.work_link')}}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                            </div>
                                        </div>
                                        <div class="tab-pane" id="link4" role="tabpanel" aria-labelledby="link-tab4"
                                             aria-expanded="false">
                                            <table class="table table-striped table-bordered dom-jQuery-events">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">{{__('msg.project')}}</th>
                                                    <th class="text-center">{{__('msg.business_owner')}}</th>
                                                    <th class="text-center">{{__('msg.rate')}}</th>
                                                    <th class="text-center">{{__('msg.text')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($rates as $rate)
                                                    <tr>
                                                        <td class="text-center">{{$rate->id}}</td>
                                                        <td class="text-center">{{$rate->project->title ?? '-'}}</td>
                                                        <td class="text-center">{{$rate->business_owner->name ?? '-'}}</td>
                                                        <td class="d-flex justify-content-center">
                                                            @for($i = 1; $i<=5 ; $i++)
                                                                <li class="la la-star" style="{{$user->stars >= $i ? 'color: #fdbe00e0;' : ''}}"></li>
                                                            @endfor
                                                        </td>
                                                        <td class="text-center">{{$rate->text}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="link5" role="tabpanel" aria-labelledby="link-tab5"
                                             aria-expanded="false">
                                            <table class="table table-striped table-bordered dom-jQuery-events">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">{{__('msg.title')}}</th>
                                                    <th class="text-center">{{__('msg.text')}}</th>
                                                    <th class="text-center">{{__('msg.created_at')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($notifacations as $notify)
                                                    <tr>
                                                        <td class="text-center">{{$notify->id}}</td>
                                                        <td class="text-center">{{$notify->title ?? '-'}}</td>
                                                        <td class="text-center">{{$notify->notify ?? '-'}}</td>
                                                        <td class="text-center">{{date('d/m/Y H:i',strtotime($notify->created_at))}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                        <p class="alert alert-danger">{{__('msg.not_found')}}</p>
                    @endif
                </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/pages/users.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('public/assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <style>
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
@endsection
