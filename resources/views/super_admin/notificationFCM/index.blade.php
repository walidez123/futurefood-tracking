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
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                          <!-- <th>From</th>
                           <th>To</th> -->
                          <th>title</th>
                          <th>Message</th>
                          <th>Date</th>
                </tr>
              </thead>
              <tbody>
                  @forelse ($Notificationfcm as $notification)
                        <tr>
                                <!-- <td class="mailbox-name">{{ ! empty($notification->sender) ? $notification->sender->name : ''}}</td>
                                <td class="mailbox-name">{{ ! empty($notification->recipient) ? $notification->recipient->name : ''}}</td> -->
                                <td class="mailbox-subject">{{$notification->title}}

                               
                                <td class="mailbox-subject"> {{$notification->message}}
                                </td>
                                <td class="mailbox-date"><i class="fa fa-clock-o" aria-hidden="true"></i> {{$notification->dateFormatted()}}</td>
                                <td> 
                                <a href="{{route('notificationFCM.show', $notification->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">التفاصيل</span></a>
                                  <form class="pull-right" style="display: inline;" action="{{route('notificationFCM.destroy', $notification->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل تريد مسح الإشعار ?');">
                          <i class="fa fa-true" aria-hidden="true"></i> مسح
                        </button>
                      </form> </td>
                              </tr>
                        @empty
                            <center>
                                    <i class="fa fa-bell fa-5x"></i>
                                    <h3>@lang('app.notifications', ['attribute' => __('app.no_have')])</h3>
                            </center>
                        @endforelse

              </tbody>
          
            </table>
            <nav>
                        <ul class="pager">
                          {{ $Notificationfcm->appends($_GET)->links() }}
                        </ul>

                      </nav>          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection