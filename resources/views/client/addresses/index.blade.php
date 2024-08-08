@extends('layouts.master')
@section('pageTitle', 'Addresses')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' =>  __('app.address'), 'iconClass' => 'fa-map-marker', 'addUrl' => route('addresses.create'), 'multiLang' => 'false'])

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            @if(session('success'))
              <div class="alert alert-success" id="successMessage">
                  {{ session('success') }}
              </div>
              <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
              <script>
                  // Wait for the document to be ready
                  $(document).ready(function() {
                      // Set a timeout to hide the success message after 3 seconds
                      setTimeout(function() {
                          $('#successMessage').fadeOut('fast');
                      }, 4000); // 3000 milliseconds = 3 seconds
                  });
              </script>
          @endif
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>@lang('app.city')</th>
                  <th>@lang('app.phone')</th>
                  <th>@lang('app.address')</th>
                  <th>@lang('address.location on map')</th>
                  <th>@lang('address.The main branch')</th>

                  
                  <th>@lang('app.control')</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($addresses as $address)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{! empty( $address->city ) ? $address->city->trans('title') : '' }}</td>
                  <td>{{$address->phone}}</td>
                  <td>{{$address->address}}</td>
                  @if($address->link)
                      <td><a
                        href="{{ $address->link }}"
                        target="_blank">{{ __("admin_message.Open Location on Google Maps") }}</a>
                      </td>
                    @else
                      <td><a
                        href="https://www.google.com/maps/search/?api=1&query={{ $address->latitude }},{{ $address->longitude }}"
                        target="_blank">{{ __("admin_message.Open Location on Google Maps") }}</a>
                      </td>
                    @endif

                  <td>
                  @if($address->main_address==1)

                  {{__('admin_message.Yes')}}
                  @else
                 {{__('admin_message.No')}}

                  @endif
                  </td>
                  <td>
                    <a href="{{route('addresses.edit', $address->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">@lang('app.edit')</span></a>

                    <form style="display: inline;" action="{{route('addresses.destroy', $address->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> @lang('app.delete')
                        </button>
                      </form>
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>@lang('app.city')</th>
                  <th>@lang('app.phone')</th>
                  <th>@lang('app.address')</th>
                  <th>@lang('address.location on map')</th>
                  <th>@lang('address.The main branch')</th>

                  <th>@lang('app.control')</th>
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
