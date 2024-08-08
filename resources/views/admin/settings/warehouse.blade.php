@extends('layouts.master')
@section('pageTitle', __('admin_message.Site settings'))
@section('nav')
@include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __('admin_message.Site settings'), 'type' =>__('admin_message.Edit'), 'iconClass' => 'fa fa-cog', 'url'
    =>
    route('settings.edit'), 'multiLang' => 'flase'])

    <!-- Main content -->

    <section class="content ">
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <form action="{{route('settings.update.company')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                  
                    <div class="tab-content">
         
                        <div class="tab-pane  active" id="Termsmile">
                        <div class="form-group">
                                <label for="exampleInputEmail1">{{__('admin_message.Stand abbreviation')}}</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    value="{{$user->stand_number_characters}}" name="stand_number_characters" placeholder="{{__('admin_message.Stand abbreviation')}}" required>
                                @error('stand_number_characters')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!--  -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{__('admin_message.Floor abbreviation')}}</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    value="{{$user->floor_number_characters}}" name="floor_number_characters" placeholder="{{__('admin_message.Floor abbreviation')}}" required>
                                @error('floor_number_characters')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!--  -->
                            @if (in_array(3, $user_type))

                            <div class="form-group">
                                <label for="exampleInputEmail1">{{__('admin_message.Package abbreviation')}}</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    value="{{$user->package_number_characters}}" name="package_number_characters" placeholder="{{__('admin_message.Package abbreviation')}}" required>
                                @error('package_number_characters')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @endif

                            @if ( in_array(4, $user_type))



                            <div class="form-group">
                                <label for="exampleInputEmail1">{{__('admin_message.Shelves abbreviation')}}</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    value="{{$user->shelves_number_characters}}" name="shelves_number_characters" placeholder="{{__('admin_message.Shelves abbreviation')}}" required>
                                @error('shelves_number_characters')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @endif
                           

                          
                        </div>



                        <!--  -->
                    </div>
                    <!--  -->
                    <!-- nav-tabs-custom -->
                    <div class=" footer">
                        <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
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