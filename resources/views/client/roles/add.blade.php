@extends('layouts.master')
@section('pageTitle', 'أضافة دور')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'دور', 'type' => 'أضافة', 'iconClass' => 'fa-lock', 'url' =>
    route('roles.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('roles.store')}}" method="POST">
                @csrf

                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> أضافة دور</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">أسم</label>
                                <input type="text" class="form-control" name="title" id="exampleInputEmail1"
                                    placeholder="Role Name" required>
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('permissions.title') }}</th>
                                        <th><i class="fa fa-eye" aria-hidden="true"></i> {{ __('permissions.view') }}</th>
                                        <th><i class="fa fa-plus" aria-hidden="true"></i> {{ __('permissions.add') }}</th>
                                        <th><i class="fa fa-edit" aria-hidden="true"></i> {{ __('permissions.edit') }}</th>
                                        <th><i class="fa fa-trash" aria-hidden="true"></i> {{ __('permissions.delete') }}</th>
                                        <th><i class="fa fa-qrcode" aria-hidden="true"></i> {{ __('permissions.qrcode') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5">
                                            <center>
                                                <h4>{{ __('permissions.admin_permissions') }}</h4> <input type="checkbox" id="checkAll">{{ __('permissions.select_all') }}
                                            </center>
                                        </td>
                                    </tr>
                                    @if (in_array(1, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.stores') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="9"></td>
                                        <td><input type="checkbox" name="permissions[]" value="10"></td>
                                        <td><input type="checkbox" name="permissions[]" value="11"></td>
                                        <td><input type="checkbox" name="permissions[]" value="12"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.restaurants') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="75"></td>
                                        <td><input type="checkbox" name="permissions[]" value="76"></td>
                                        <td><input type="checkbox" name="permissions[]" value="77"></td>
                                        <td><input type="checkbox" name="permissions[]" value="78"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(3, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.warehouse_clients') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="150"></td>
                                        <td><input type="checkbox" name="permissions[]" value="151"></td>
                                        <td><input type="checkbox" name="permissions[]" value="152"></td>
                                        <td><input type="checkbox" name="permissions[]" value="153"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(4, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.fulfillment_clients') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="207"></td>
                                        <td><input type="checkbox" name="permissions[]" value="208"></td>
                                        <td><input type="checkbox" name="permissions[]" value="209"></td>
                                        <td><input type="checkbox" name="permissions[]" value="210"></td>
                                    </tr>
                                    @endif
                                    
                                    <tr>
                                        <td>الفواتير</td>
                                        <td><input type="checkbox" name="permissions[]" value="83"></td>
                                        <td><input type="checkbox" name="permissions[]" value="84"></td>
                                        <td><input type="checkbox" name="permissions[]" value="85"></td>
                                        <td><input type="checkbox" name="permissions[]" value="86"></td>
                                    </tr>
                                
                                    <tr>
                                        <td>التقارير الخارجية</td>
                                        <td><input type="checkbox" name="permissions[]" value="103"></td>
                                        <td><input type="checkbox" name="permissions[]" value="104"></td>
                                        <td><input type="checkbox" name="permissions[]" value="105"></td>
                                        <td><input type="checkbox" name="permissions[]" value="106"></td>
                                    </tr>
                                   
                                   
                                    <tr>
                                        <td>فروع الشركة</td>
                                        <td><input type="checkbox" name="permissions[]" value="60"></td>
                                        <td><input type="checkbox" name="permissions[]" value="61"></td>
                                        <td><input type="checkbox" name="permissions[]" value="62"></td>
                                        <td><input type="checkbox" name="permissions[]" value="63"></td>
                                    </tr>
                                    <tr>
                                        <td>الأدوار</td>
                                        <td><input type="checkbox" name="permissions[]" value="28"></td>
                                        <td><input type="checkbox" name="permissions[]" value="29"></td>
                                        <td><input type="checkbox" name="permissions[]" value="30"></td>
                                        <td><input type="checkbox" name="permissions[]" value="31"></td>
                                    </tr>
                                    <tr>
                                        <td>المستخدمين</td>
                                        <td><input type="checkbox" name="permissions[]" value="32"></td>
                                        <td><input type="checkbox" name="permissions[]" value="33"></td>
                                        <td><input type="checkbox" name="permissions[]" value="34"></td>
                                        <td><input type="checkbox" name="permissions[]" value="35"></td>
                                    </tr>
                                    
                                    @if (in_array(3, $user_type)|| in_array(4, $user_type))

                                    <tr>
                                        <td>فروع المستودع</td>
                                        <td><input type="checkbox" name="permissions[]" value="119"></td>
                                        <td><input type="checkbox" name="permissions[]" value="120"></td>
                                        <td><input type="checkbox" name="permissions[]" value="121"></td>
                                        <td><input type="checkbox" name="permissions[]" value="122"></td>
                                    </tr>

                                    <tr>
                                        <td>المنتجات / البضائع</td>
                                        <td><input type="checkbox" name="permissions[]" value="123"></td>
                                        <td><input type="checkbox" name="permissions[]" value="124"></td>
                                        <td><input type="checkbox" name="permissions[]" value="125"></td>
                                        <td><input type="checkbox" name="permissions[]" value="126"></td>
                                        <td><input type="checkbox" name="permissions[]" value="183"></td>

                                        

                                    </tr>
                                
                                    <tr>
                                        <td> طباعة QR</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                        <td><input type="checkbox" name="permissions[]" value="131"></td>

                                    </tr>
                                    <tr>
                                        <td>{{__('admin_message.Packaging goods/cartons')}}</td>
                                        <td><input type="checkbox" name="permissions[]" value="211"></td>
                                        <td><input type="checkbox" name="permissions[]" value="212"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="213"></td>

                                       
                                    </tr>
                                    @endif
                                   
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Title</th>
                                        <th> <i class="fa fa-eye" aria-hidden="true"></i> Show</th>
                                        <th> <i class="fa fa-plus" aria-hidden="true"></i> Add</th>
                                        <th> <i class="fa fa-edit" aria-hidden="true"></i> Edit</th>
                                        <th> <i class="fa fa-trash" aria-hidden="true"></i> Delete </th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div><!-- /.box -->
                </div>

        </div>
        <div class=" footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script>
$("#checkAll").click(function() {

    $('input:checkbox').not(this).prop('checked', this.checked);

});
</script>
@endsection