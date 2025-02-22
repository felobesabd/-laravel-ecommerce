@extends('layouts.admin')

@section('title', 'SubCategories')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{__('dashboard.sub_cat')}}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin.index')}}">{{__('dashboard.main')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{__('dashboard.sub_cat')}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('dashboard.cat.all_cat')}}</h4>
                                    <a class="heading-elements-toggle">
                                        <i class="la la-ellipsis-v font-medium-3"></i>
                                    </a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <a data-action="collapse">
                                                    <i class="ft-minus"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="reload">
                                                    <i class="ft-rotate-cw"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="expand">
                                                    <i class="ft-maximize"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="close">
                                                    <i class="ft-x"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <table
                                            class="table display nowrap table-striped table-bordered scroll-horizontal">
                                            <thead class="">
                                            <tr>
                                                <th>{{__('dashboard.name')}}</th>
                                                <th>{{__('dashboard.main_cat')}}</th>
                                                <th>{{__('dashboard.name_link')}}</th>
                                                <th>{{__('dashboard.status')}}</th>
                                                <th>{{__('dashboard.cat.photo_cat')}}</th>
                                                <th>{{__('dashboard.actions')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @isset($subcategories)
                                                @foreach($subcategories as $subcategory)
                                                    <tr>
                                                        <td>{{$subcategory-> name}}</td>
                                                        <td>{{$subcategory-> _parent-> name}}</td>
                                                        <td>{{$subcategory-> slug}}</td>
                                                        <td>{{$subcategory-> getActive()}}</td>
                                                        <td> <img style="width: 150px; height: 100px;" src=" "></td>
                                                        <td>
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Basic example">
                                                                <a href="{{route('admin.subcategories.edit',$subcategory -> id)}}"
                                                                   class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">
                                                                    {{__('dashboard.edit')}}
                                                                </a>

                                                                <a href="{{route('admin.subcategories.delete',$subcategory -> id)}}"
                                                                   class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">
                                                                    {{__('dashboard.delete')}}
                                                                </a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                            </tbody>
                                        </table>
                                        <div class="justify-content-center d-flex">
                                            {{$subcategories->links()}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@stop
