@extends('layouts.master')
@section('pageTitle', 'Packages')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @if (in_array('add_offers', $permissionsTitle))

  @include('layouts._header-index', ['title' => 'Package', 'iconClass' => 'fa-brands fa-first-order', 'addUrl' =>
  route('Packages.create'), 'multiLang' => 'false'])
  @endif

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
                  <th>title</th>
                  <th>number of Days</th>
                  <th>price</th>
                  <th>area</th>
                  <th>details </th>
                  <th>publish</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if ($offers->currentPage() == 1) {
                        $count = 1;
                    } else {
                        $count = ($offers->currentPage() - 1) * 25 + 1;
                    }
                ?>
                @foreach ($offers as $offer)
                <tr>
                  <th>{{$count}}</th>
              

                  <td class="en ">{{$offer->trans('title')}}</td>
                  <td class="ar ">{{$offer->num_days}}</td>
                  <td class="ar ">{{$offer->price}}</td>
                  <td class="ar ">{{$offer->area}}</td>


                  <td class="en ">{!!$offer->trans('description')!!}</td>
                  <td class=" ">
                    @if($offer->publish==1)
                    publish
                    @else
                     unpublish
                    @endif
                  </td>

                  <td>
                    @if (in_array('edit_offers', $permissionsTitle))

                    <a href="{{route('Packages.edit', $offer->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">Edit</span></a>

                    @endif
                    @if (in_array('delete_offers', $permissionsTitle))
                      <form class="pull-right" style="display: inline;" action="{{route('Packages.destroy', $offer->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
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
                  <th>title</th>
                  <th>number of Days</th>
                  <th>price</th>
                  <th>area</th>

                  <th>details </th>
                  <th>publish</th>
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
