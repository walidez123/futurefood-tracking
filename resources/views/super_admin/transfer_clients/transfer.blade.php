@extends('layouts.master')
@section('pageTitle', 'transfer clients')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => ' clients', 'type' =>  'transfer','iconClass' => 'fa-window-restore', 'url' =>
    route('faqs.index'), 'multiLang' => 'false'])

    
  <!-- Main content -->
  <section class="content">
    <div class="row">
      @if(session('success'))
          <div id="success-alert" class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif

      @if(session('error'))
          <div id="error-alert" class="alert alert-danger">
              {{ session('error') }}
          </div>
      @endif
      
      <form role="form" action="{{route('transfer-clients.store')}}" method="POST" enctype="multipart/form-data">
      @csrf
   
      <div class="col-md-12 col-xs-12">
        <!-- general form elements -->
        <div class="box box-primary" style="padding: 10px;">
          <div class="box-header with-border">
            <h3 class="box-title"> Transfer clients</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
            <div class="box-body">
                  <div class="form-group">
                      <label for="lastname" class="control-label">@lang('admin_message.client_name') <span
                              class="text-danger">*</span></label>
                      <div class="">
                          <select id="client_id" class="form-control select2" name="client_id" >
                              <option value="">@lang('app.select', ['attribute' => __('app.city')])</option>
                              @foreach ($clients as $city)
                                  <option value="{{ $city->id }}">{{ $city->store_name }}</option>
                              @endforeach

                          </select>
                          @error('client_id')
                              <span class="invalid-feedback text-danger" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="lastname" class="control-label">@lang('admin_message.company_name') <span
                            class="text-danger">*</span></label>
                    <div class="">
                        <select id="to_company_id" class="form-control select2" name="to_company_id" required>
                            <option value="">@lang('app.select', ['attribute' => __('app.city')])</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{$company->store_name}}</option>
                            @endforeach

                        </select>
                        @error('to_company_id')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                 
             
              
            
                <div class=" footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div> 
               </form> <!-- /.row -->
            </div>
        </div><!-- /.box -->
      </section>
  
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{ asset('assets/wysiwyg-editor/js/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/wysiwyg-editor/wysiwyg-editor.js') }}"></script>
<script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script>
    $(function() {
        $('.select2').select2()
    });
</script>
@endsection