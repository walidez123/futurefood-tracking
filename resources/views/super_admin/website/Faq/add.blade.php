@extends('layouts.master')
@section('pageTitle', 'Add faq')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'Faq', 'type' => 'Add', 'iconClass' => 'fa-window-restore', 'url' =>
    route('faqs.index'), 'multiLang' => 'false'])

    
  <!-- Main content -->
  <section class="content">
    <div class="row">
      
      <form role="form" action="{{route('faqs.store')}}" method="POST" enctype="multipart/form-data">
      @csrf
   
      <div class="col-md-12 col-xs-12">
        <!-- general form elements -->
        <div class="box box-primary" style="padding: 10px;">
          <div class="box-header with-border">
            <h3 class="box-title"> Add faq</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
            <div class="box-body">
                  <div class="form-group">
                          <label for="exampleInputEmail1" class="">question </label>                            
                          <input type="text" name="question" class="form-control " id="exampleInputEmail1" placeholder="question " >
                  </div>
                  <div class="form-group">
                          <label for="exampleInputEmail1" class="">question Arabic </label>                            
                          <input required type="text" name="question_ar" class="form-control " id="exampleInputEmail1" placeholder="question " >
                  </div>
                 
              <div class="form-group">
                  <label for="exampleInputEmail1">answer</label>
                  <textarea   class=" textarea wysiwyg" name="answer" id="exampleInputEmail1" placeholder="answer"></textarea>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">answer Arabic</label>
                  <textarea   class=" textarea wysiwyg" name="answer_ar" id="answer_ar" placeholder="answer"></textarea>
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



@endsection