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
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                           
                            @if(in_array(1,$user_type))
                            <li class="active"><a href="#Termsmile"
                                    data-toggle="tab">{{__('admin_message.Electronic contract, terms and conditions (Last mile)')}}
                                </a></li>
                            @endif
                            @if(in_array(2,$user_type))

                            <li><a href="#Termres"
                                    data-toggle="tab">{{__('admin_message.Electronic contract, terms and conditions (Restaurants)')}}
                                </a></li>
                            @endif

                            @if(in_array(3,$user_type))

                            <li><a href="#Terms10"
                                    data-toggle="tab">{{__('admin_message.Electronic contract, terms and conditions (Warehouses)')}}
                                </a></li>
                            @endif

                            @if(in_array(4,$user_type))

                          <li><a href="#Terms11"
                            data-toggle="tab">{{__('admin_message.Electronic contract, terms and conditions')}} ({{__('fulfillment.fulfillment')}})
                         </a></li>
                          @endif

                        </ul>
                    </div>
                    <div class="tab-content">
         
                        <div class="tab-pane  active" id="Termsmile">
                            <ul class="nav nav-tabs">


                                <li class="active"><a href="#Terms"
                                        data-toggle="tab">{{__('admin_message.Customer terms and conditions')}} </a>
                                </li>
                              
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="Terms">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            {{ __('admin_message.Privacy Terms in English') }}
                                        </label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="terms_en"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $user->terms_en }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="exampleInputEmail1">{{ __('admin_message.Privacy Terms in Arabic') }}</label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="terms_ar"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $user->terms_ar }}</textarea>
                                        </div>
                                    </div>

                                </div>
                               
                            </div>
                        </div>

                        <div class="tab-pane fade" id="Termres">
                            <ul class="nav nav-tabs">


                                <li class="active"><a href="#Terms2"
                                        data-toggle="tab">{{__('admin_message.Restaurants terms and conditions')}} </a>
                                </li>
                            
                                <!--  -->
                            </ul>

                            <div class="tab-content">
                                <!-- /.tab-pane -->
                                <div class="tab-pane active" id="Terms2">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            {{ __('admin_message.Privacy Terms in English') }}
                                        </label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="term_en_res"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $user->term_en_res }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="exampleInputEmail1">{{ __('admin_message.Privacy Terms in Arabic') }}</label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="term_ar_res"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $user->term_ar_res }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>

                               
                        </div>
                        <!-- warehouser -->
                        <div class="tab-pane fade" id="Terms10">
                            <ul class="nav nav-tabs">


                                <li class="active"><a href="#Terms12"
                                        data-toggle="tab">{{__('admin_message.Customer terms and conditions')}} </a>
                                </li>
                             
                                <!--  -->
                            </ul>

                            <div class="tab-content">
                                <!-- /.tab-pane -->
                                <div class="tab-pane active"  id="Terms12">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            {{ __('admin_message.Privacy Terms in English') }}
                                        </label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="term_en_warehouse"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $user->term_en_warehouse }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="exampleInputEmail1">{{ __('admin_message.Privacy Terms in Arabic') }}</label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="term_ar_warehouse"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $user->term_ar_warehouse }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end warehouse -->
                        <!-- statrt Fulfument -->
                        <div class="tab-pane fade" id="Terms11">
                            <ul class="nav nav-tabs">


                                <li class="active"><a href="#Terms12"
                                        data-toggle="tab">{{__('admin_message.Customer terms and conditions')}} </a>
                                </li>
                             
                                <!--  -->
                            </ul>

                            <div class="tab-content">
                                <!-- /.tab-pane -->
                                <div class="tab-pane active"  id="Terms11">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            {{ __('admin_message.Privacy Terms in English') }}
                                        </label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="term_en_fulfillment"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $user->term_en_fulfillment }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="exampleInputEmail1">{{ __('admin_message.Privacy Terms in Arabic') }}</label>
                                        <div class="form-group">
                                            <textarea class="textarea wysiwyg" name="term_ar_fulfillment"
                                                placeholder="Place some text here"
                                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $user->term_ar_fulfillment }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end -->



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