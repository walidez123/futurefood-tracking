@extends('layouts.master')
@section('pageTitle', 'الإشعارات')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  @include('layouts._header-index', ['title' => 'الإشعارات', 'iconClass' => 'fa-users', 'addUrl' => route('notificationFCM.create'), 'multiLang' => 'false'])

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          
            <!--  -->
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                           <th>From</th>
                         <!--  <th>To</th> -->
                          <th>title</th>
                          <th>Message</th>
                          <th>Date</th>
                </tr>
              </thead>
              <tbody>
                        <tr>
                              <td class="mailbox-name">{{ ! empty($Notificationfcm->sender) ? $Notificationfcm->sender->name : ''}}</td>
                                <td class="mailbox-subject">{{$Notificationfcm->title}}

                               
                                <td class="mailbox-subject"> {{$Notificationfcm->message}}
                                </td>
                                <td class="mailbox-date"><i class="fa fa-clock-o" aria-hidden="true"></i> {{$Notificationfcm->dateFormatted()}}</td>
                                
                              </tr>
                     

              </tbody>
          
            </table>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                           <th>المناديب</th>
                        
                </tr>
              </thead>
              <tbody>
                @foreach($Fcmnotifuction_delegate as $Fcmnotifuction_del)
                        <tr>
                              <td class="mailbox-name">{{ ! empty($Fcmnotifuction_del->recipient) ? $Fcmnotifuction_del->recipient->name : ''}}</td>
                              
                                
                              </tr>
                @endforeach
                     

              </tbody>
          
            </table>
               </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection