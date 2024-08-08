@extends('layouts.master')
@section('pageTitle', 'Edit Rate Order')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', ['title' => 'Rate Order', 'type' => 'Edit', 'iconClass' => 'fa-map-marker', 'url' => route('rate_orders.index'), 'multiLang' => 'false'])
    
        <!-- Main content -->
        <section class="content">
            <div class="row">
    
                <form action="{{route('rate_orders.update', $rate_order->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Edit Rate Order</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
    
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Customer Name</label>
                                    <input type="text" class="form-control" value="{{$rate_order->name}}" name="name" id="exampleInputEmail1"
                                        placeholder="Name">
                                    @error('title')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Customer Mobile</label>
                                    <input type="text" class="form-control" value="{{$rate_order->mobile}}" name="mobile" id="exampleInputMobile1"
                                        placeholder="Name">
                                    @error('title')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="rate">Rate</label>
                                    <input type="number" step="1" min="0" max="5" class="form-control" value="{{$rate_order->rate}}"  name="rate" id="exampleInputRate" placeholder="rate" required>
                                </div>
                                <div class="form-group">
                                    <label for="review">review </label>
                                    <textarea class="form-control" name="review" id="exampleInputReview"
                                        placeholder="review">{{$rate_order->review}}</textarea>
                                </div>
    
                            </div>
                        </div><!-- /.box -->
                    </div>
    
            </div>
            <div class=" footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form> <!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection