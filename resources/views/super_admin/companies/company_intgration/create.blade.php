@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
@endsection
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="nav-tabs-custom">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(Session::has('error'))
<div class="alert alert-danger">
  {{ Session::get('error')}}
</div>
@endif

                    <form enctype="multipart/form-data" action="{{ route('company_providers.store') }}" method="POST"
                        class="box  col-md-12" style="border: 0px; padding:10px;">
                        <input type="hidden" name="user_id" value="{{$user_id}}">
                        @csrf


                                <div class="col-xs-3 form-group">
                                    <label for="firstname" class="control-label"> * اسم الشركة </label>
                                    <div>
                                        <select required class="form-control" name="provider_name" id="">
                                            <option {{old('provider_name')=="salla" ? 'selected' : ''}} value="salla">salla</option>
                                            <option {{old('provider_name')=="zid" ? 'selected' : ''}} value="zid">zid</option>
                                            <option {{old('provider_name')=="foodics" ? 'selected' : ''}} value="foodics">foodics</option>


                                        </select>
                                        @error('provider_name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                
                                <div class="col-xs-3 form-group">
                                    <label for="firstname" class="control-label"> * app_id </label>
                                    <div>
                                        <input  type="text" name="app_id" value="{{old('app_id')}}" class="form-control" id="fullname"
                                            placeholder="app_id" required>
                                        @error('app_id')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-3 form-group">
                                    <label for="firstname" class="control-label"> * client id </label>
                                    <div>
                                        <input  type="text" name="client_id" value="{{old('client_id')}}" class="form-control" id="fullname"
                                            placeholder="client_id" required>
                                        @error('client_id')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-3 form-group">
                                    <label for="firstname" class="control-label"> *  client secrete </label>
                                    <div>
                                        <input  type="text" name="client_secrete" value="{{old('client_secrete')}}" class="form-control" id="fullname"
                                            placeholder="client secrete" required>
                                        @error('client_secrete')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label for="firstname" class="control-label"> * SALLA_WEBHOOK_CLIENT_SECRET </label>
                                    <div>
                                        <input  type="text" name="SALLA_WEBHOOK_CLIENT_SECRET" value="{{old('SALLA_WEBHOOK_CLIENT_SECRET')}}" class="form-control" id="fullname"
                                            placeholder="SALLA_WEBHOOK_CLIENT_SECRET" required>
                                        @error('SALLA_WEBHOOK_CLIENT_SECRET')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- <div class="col-xs-3 form-group">
                                    <label for="firstname" class="control-label"> *  auth_base_url </label>
                                    <div>
                                        <input  type="text" name="auth_base_url" value="{{old('auth_base_url')}}" class="form-control" id="fullname"
                                            placeholder="auth_base_url" required>
                                        @error('auth_base_url')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> -->
                                <!-- <div class="col-xs-3 form-group">
                                    <label for="firstname" class="control-label"> * base_url  </label>
                                    <div>
                                        <input  type="text" name="base_url" value="{{old('base_url')}}" class="form-control" id="fullname"
                                            placeholder="base_url" required>
                                        @error('base_url')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> -->

                                <div class="col-xs-3 form-group">
                                    <label for="firstname" class="control-label"> * tag_name  </label>
                                    <div>
                                        <input  type="text" name="tag_name" value="{{old('tag_name')}}" class="form-control" id="fullname"
                                            placeholder="tag_name">
                                        @error('tag_name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-3 form-group">
                                    <label for="firstname" class="control-label"> *  نوع التطبيق </label>
                                    <div>
                                        <select required class="form-control" name="app_type" id="">
                                            <option {{old('app_type')=="1" ? 'selected' : ''}} value="1">عميل ميل أخير</option>
                                            <option {{old('app_type')=="2" ? 'selected' : ''}} value="2">مطعم</option>
                                            <option {{old('app_type')=="4" ? 'selected' : ''}} value="4">فولفمنت</option>


                                        </select>
                                        @error('app_type')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-3 form-group">
                                    <label for="firstname" class="control-label"> * التفعيل  </label>
                                    <div>
                                        <select class="form-control" name="active" id="">
                                            <option {{old('active')==1 ? 'selected' : ''}}  value="1">تفعيل</option>
                                            <option {{old('active')==0 ? 'selected' : ''}} value="0">إلغاء التفعيل</option>

                                        </select>
                                    </div>
                                </div>
                                
                              
                        <!-- /.tab-content -->
                        <div class=" footer col-lg-12">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>

                </div>
                <!-- /.nav-tabs-custom -->
            </div>


        </section>
        <!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

@section('js')
    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2()
        });
    </script>
@endsection
