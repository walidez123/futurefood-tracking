@extends('layouts.master')

@if($work==1)
@section('pageTitle',__('admin_message.Clients'))

@elseif($work==2)
@section('pageTitle',__('admin_message.restaurants'))
@elseif($work==3)
@section('pageTitle',__('admin_message.Warehouse Clients'))
@elseif($work==4)
@section('pageTitle',__('fulfillment.fulfillment_clients') )
@endif
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">  
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  @include('layouts._header-index', ['title' => 'Client API', 'iconClass' => 'fa-link', 'addUrl' => '', 'multiLang' => 'false'])
  @if($work==1)
  @if (in_array('add_client', $permissionsTitle))


  @include('layouts._header-index', ['title' =>__('admin_message.Clients'), 'iconClass' => 'fa-link', 'addUrl' => '', 'multiLang' => 'false'])
  @endif
  @elseif($work==2)
  @if (in_array('add_resturant', $permissionsTitle))

    @include('layouts._header-index', ['title' =>__('admin_message.restaurants'), 'iconClass' => 'fa-link', 'addUrl' => '', 'multiLang' => 'false'])
@endif
@elseif($work==3)
@if (in_array('add_client_warehouse', $permissionsTitle))

@include('layouts._header-index', ['title' =>__('admin_message.Warehouse Clients'), 'iconClass' => 'fa-link', 'addUrl' => '', 'multiLang' => 'false'])
@endif

@elseif($work==4)
@if (in_array('add_client_fulfillment', $permissionsTitle))

@include('layouts._header-index', ['title' =>__('fulfillment.fulfillment_clients'), 'iconClass' => 'fa-link', 'addUrl' => '', 'multiLang' => 'false'])

@endif
@endif
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> 
            @if (in_array('add_api_client', $permissionsTitle))

          <button type="button" class="btn btn-info pull-center" data-toggle="modal"
          data-target="#add-api">
          <i class="fa fa-link"></i>
          Generate Api To Client
      </button>
      @endif
            </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Avatar</th>
                  <th>Name</th>
                  <th>Store</th>
                  <th>domain</th>
                  <th>Api Token</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($apiList as $client)
                <tr>
                  <td>{{$count}}</td>
                  @if($client->provider!=NULL)

                  <td><img class="img-circle" src="{{$client->avatar}}" height="75" width="75"></td>
                  @elseif($client->avatar==NULL||$client->avatar=="avatar/avatar.png")
                  <td><img class="img-circle" src="{{asset('storage/'.$webSetting->logo)}}" height="75" width="75"></td>

                  @else
                  <td><img class="img-circle" src="{{asset('storage/'.$client->avatar)}}" height="75" width="75"></td>


                  @endif       <td>{{$client->name}}</td>
                  <td>{{$client->store_name}}</td>
                  <td>{{$client->domain}}</td>
                  <td style="word-break: break-word;">{{$client->api_token}}</td>
                  <td>
                  @if (in_array('delete_api_client', $permissionsTitle))
                    <form class="pull-right" style="display: inline;" action="{{route('clients-api.destroy', $client->id)}}" method="POST">
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
                  <th>Avatar</th>
                  <th>Name</th>
                  <th>Store</th>
                  <th>domain</th>
                  <th>Api Token</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
            {{ $apiList->appends(Request::query())->links() }}
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div class="modal fade" id="add-api">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add client api</h4>
            </div>
            <form action="{{route('clients-api.store')}}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label  class="control-label">Clients *</label>
                            <select style="width:100%" class="form-control select2" name="user_id" required>
                                <option value="">Select Client</option>
                                @foreach ($clients as $client)
                                <option value="{{$client->id}}">{{$client->name}} | {{$client->store_name}}</option>
                                @endforeach

                            </select>
                            @error('user_id')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label  class="control-label">Domain *</label>
                            <input type="text" class="form-control" name="domain" id="domain" required>
                        </div>
                      
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('order.Close')</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
@endsection

@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
@endsection