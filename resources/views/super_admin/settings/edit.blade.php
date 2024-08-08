@extends('layouts.master')
@section('pageTitle', 'إعدادات الموقع')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('layouts._header-form', ['title' => 'إعدادات الموقع', 'type' => 'تعديل', 'iconClass' => 'fa fa-cog', 'url' =>
  route('appSettings.edit'), 'multiLang' => 'flase'])

  <!-- Main content -->

  <section class="content ">
    <div class="row">
      <div class="col-md-12">
        <!-- Custom Tabs -->
        <form action="{{route('appSettings.update')}}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#App" data-toggle="tab">الأبليكشن</a></li>
              <!-- <li><a href="#Terms" data-toggle="tab">شروط الخصوصية للمتجر </a></li>
              <li><a href="#Terms2" data-toggle="tab">شروط الخصوصية للمطعم </a></li> -->
              <li><a href="#Terms3" data-toggle="tab">شروط الخصوصية للمندوب   </a></li> 
              <!-- <li><a href="#Terms4" data-toggle="tab">شروط الخصوصية للمندوب مطعم  </a></li>  -->

           
              



            </ul>
            <div class="tab-content">
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="App">

                <div class="form-group">
                  <label for="exampleInputEmail1">Title</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" value="{{$settings->name}}"
                    name="name" placeholder="Title" required>
                    @error('name')
                  <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" value="{{$settings->email}}"
                    name="email" placeholder="Email" required>
                    @error('email')
                  <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Phone</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" value="{{$settings->phone}}"
                    name="phone" placeholder="Phone" required>
                    @error('phone')
                  <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Currency</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" value="{{$settings->currency}}"
                    name="currency" placeholder="currency" required>
                    @error('currency')
                  <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">order number characters</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" value="{{$settings->order_number_characters}}"
                    name="order_number_characters" placeholder="currency" required>
                    @error('order_number_characters')
                  <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

              </div>
             
             
             <div class="tab-pane" id="Terms3">

                <div class="form-group">
                <label for="exampleInputEmail1">شروط الخصوصية باللانجليزى</label>
                    <div class="form-group">
                <textarea class="textarea wysiwyg" name="term_en_d_1" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$settings->term_en_d_1}}</textarea>
                    </div>
                </div>
                  <div class="form-group">
                  <label for="exampleInputEmail1">شروط الخصوصية بالعربى</label>
                    <div class="form-group">
                <textarea class="textarea wysiwyg" name="term_ar_d_1" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$settings->term_ar_d_1}}</textarea>
                    </div>
                </div>

              </div>
             
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
          <div class=" footer">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>

    </div>

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
    <script src="{{ asset('assets/wysiwyg-editor/js/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/wysiwyg-editor/wysiwyg-editor.js') }}"></script>
@endsection
