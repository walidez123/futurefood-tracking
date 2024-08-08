@extends('layouts.master')
@section('pageTitle', 'Rate Orders')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Customer Name</th>
                  <th>Customer Mobile</th>
                  <th>Order No#</th>
                  <th>rate No</th>
                  <th>Review</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if ($rate_orders->currentPage() == 1) {
                        $count = 1;
                    } else {
                        $count = ($rate_orders->currentPage() - 1) * 50 + 1;
                    }
                ?>
                @foreach ($rate_orders as $rate)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$rate->name}}</td>
                  <td>{{$rate->mobile}}</td>
                  <td> 
                  
                  <a href="{{route('client-orders.show', $rate->order_id)}}" title="View"
                       style="margin: 2px;">
                       <span class="hidden-xs hidden-sm">{{$rate->order_no}}</span>
                    </a>
                  </td>
                  <td>{{$rate->rate}}</td>
                  <td>{{$rate->review}}</td>
                  <td>
                    @if (in_array('edit_rate', $permissionsTitle))
                     <a href="{{route('rate_orders.edit', $rate->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">Edit</span></a>   
                    @endif
                    
                      @if (in_array('delete_rate', $permissionsTitle))
                      <form class="pull-right" style="display: inline;" action="{{route('rate_orders.destroy', $rate->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Do you want Delete This Record ?');">
                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                          </button>
                        </form>  
                      @endif
                    
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Customer Name</th>
                  <th>Customer Mobile</th>
                  <th>Order No#</th>
                  <th>rate No</th>
                  <th>Review</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection