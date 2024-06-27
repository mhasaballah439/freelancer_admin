@extends('admin.layouts.app')
@section('title','Permissions')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">{{__('msg.dashboard')}} </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('admin.admins.index')}}">{{__('msg.admins')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{__('msg.add_permissions')}}
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
                                @if(admin()->check_route_permission('admin.permissions.index') == 1)
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">{{$admin->name ?? ''}}</h4>
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
                                        <div class="card-body">
                                            <form class="form form-horizontal w-100" id="mainAdd"  method="post" action="{{route('admin.save.permissions',$admin->id)}}" >
                                                @csrf
                                                @foreach ($links as $link)
                                                    <div class="box_permission">
                                                        <ul>
                                                            <li>
                                                                <input type="checkbox" id="option_{{$link->id}}"  class="form-check-input parent" name="permission[]" value="{{$link->id}}"
                                                                       {{$admin->is_hav_link($link->id) ? 'checked' : ''}}
                                                                  ><label for="option"> {{$link->name}}</label>

                                                                        <ul>
                                                                            @foreach($link->sub_links_permitions as $child)
                                                                                <li><label><input class="form-check-input subOption_{{$link->id}}"
                                                                                                  name="permission[]" type="checkbox" value="{{$child->id}}"
                                                                                            {{$admin->is_hav_link($child->id) ? 'checked' : ''}}
                                                                                        > {{$child->name}}
                                                                                    </label>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>

                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endforeach
                                                <div class="col-md-12 text-center">
                                                    <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1">
                                                        {{__('msg.save')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
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
    <style>
        .box_permission{
            display: inline-flex;
            flex-direction: column;
            border: 2px solid;
            padding: 15px;
            margin: 6px;
        }
        .parent{
            font-size: 16px;
            color: black;
            font-weight: bold;
            margin-bottom: 2%;
            display: flex;
            align-items: center;
        }
        .child{
            display: flex;
            align-items: center;
            margin-right: 10%;
        }
    </style>
@endsection
@section('scripts')
<script src="{{asset('public/assets/js/permitions.js')}}"
@endsection
