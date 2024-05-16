@extends('layouts.admin')
@section('title', 'Create Product Stock')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="">Main</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="">Product Stock</a>
                                </li>
                                <li class="breadcrumb-item active">Add Stock To Product</li>
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
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Add Stock To Product</h4>
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
                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form"
                                              action="{{route('admin.products.stock.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="product_id" value="{{$id}}">
                                            <div class="form-body">

                                                <h4 class="form-section">
                                                    <i class="ft-home"></i>
                                                    Main Data Product
                                                </h4>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">Product code</label>
                                                            <input type="text" id="sku"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   value="{{old('sku')}}"
                                                                   name="sku">
                                                            @error("sku")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">Enable Inventory</label>
                                                            <select name="manage_stock" class="select2 form-control"
                                                                    id="manage_stock">
                                                                <optgroup label="Choose Type">
                                                                    <option value="0" selected>Disabled</option>
                                                                    <option value="1">Enable</option>
                                                                </optgroup>
                                                            </select>
                                                            @error('manage_stock')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">In Stock</label>
                                                            <select name="in_stock" class="select2 form-control" >
                                                                <optgroup label="Choose">
                                                                    <option value="1">Available</option>
                                                                    <option value="0">Not Available</option>
                                                                </optgroup>
                                                            </select>

                                                            @error('in_stock')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6" style="display:none;"  id="qtyDiv">
                                                        <div class="form-group">
                                                            <label for="projectinput1">Quantity</label>
                                                            <input type="number" id="sku"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   value="{{old('qty')}}"
                                                                   name="qty">

                                                            @error('qty')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i>
                                                    Back
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i>
                                                    Create
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).on('change', '#manage_stock', function () {
            if($(this).val() === '1') {
                $('#qtyDiv').show();
            } else {
                $('#qtyDiv').hide();
            }
        })
    </script>
@stop
