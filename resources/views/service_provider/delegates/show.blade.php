@extends('layouts.master')
@section('pageTitle',__('admin_message.Show Delegate'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
    <section class="content">
       <div class="container">
          <div class="row">
              <div class="col-lg-12">
                 <div class="box box-solid">
                    <div class="col-xs-12 col-md-3">
                    <img class="profile-user-img img-responsive img-circle"
                            src="{{asset('storage/'.$delegate->avatar)}}" alt="User profile picture">

                    </div>
                     <div class="col-xs-12 col-md-3">
                        <p class="box-title">اسم المندوب</p>
                        <p>{{$delegate->name}}</p>
                      
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.Functional code')}}</p>
                        <p>{{$delegate->code}}</p>
                         
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.Residency_number')}}</p>
                        <p>{{$delegate->Residency_number}}</p>
                         
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.Phone')}}</p>
                        <p>{{$delegate->phone}}</p>
                      </div>

                      <div class="col-xs-12 col-md-3">
                        <p class="box-title"> {{__('admin_message.Email')}}</p>
                        <p> {{$delegate->email}}</p>
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.City')}} </p>
                        <p>{{ is_null($delegate->city) ? '' : $delegate->city->trans('title') }} </p>
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.neighborhood')}} </p>
                        <p>   {{ is_null($delegate->neighborhood) ? '' : $delegate->neighborhood->trans('title') }}</p>
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">  {{__('admin_message.work type')}}</p>
                        <p> @if($delegate->work_type == 1)
                                    {{__('admin_message.Full time')}}
                                    @elseif($delegate->work_type == 2)
                                    {{__('admin_message.Part time')}}
                                    @else
                                    {{__('admin_message.By Order')}}
                                    @endif </p>
                      </div>
                      @if($delegate->work_type == 3)
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.Enter the amount required for one order')}} </p>
                        <p>{{$delegate->payment}} </p>
                      </div>
                      @endif
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.Date of hiring')}} </p>
                        <p>{{$delegate->date}}</p>
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.Supervisor')}}</p>
                        <p>      @foreach($supervisors as $supervisor)
                                    {{$supervisor->name}}|


                                    @endforeach</p>
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title"> {{__('admin_message.Service provider')}}</p>
                        <p>{{$delegate->service_provider}}</p>
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.Clients')}}</p>
                        <p>   @foreach($Delegate_clients as $client)
                                    {{ is_null($client->user) ? '' : $client->user->name }} |

                                    @endforeach</p>
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.bank account number')}}</p>
                        <p>    {{$delegate->bank_name}}  </p>
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.bank name')}}</p>
                        <p> {{$delegate->bank_account_number}} </p>
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.type')}} {{__('admin_message.vehicle')}}</p>
                        <p> {{ is_null($delegate->vehicle) ? '' : $delegate->vehicle->type_en }}  </p>
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.vehicle_number')}}</p>
                        <p>  {{ is_null($delegate->vehicle) ? '' : $delegate->vehicle->vehicle_number_en }}  </p>
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <p class="box-title">{{__('admin_message.license photo')}}</p>
                         @if($delegate->license_photo==NULL)
                            <img src="{{asset('storage/'.$webSetting->logo)}}" class="img-circle" alt="User Image"
                                width="50" height="50">
                            @else
                            <a download="{{asset('storage/'.$delegate->license_photo)}}" class="pull-right">
                                <img src="{{asset('storage/'.$delegate->license_photo)}}" class="img-circle"
                                    alt="User Image" width="50" height="50">
                            </a>
                            @endif
                      </div>
                      <div class="col-xs-12 col-md-3">
                          <p class="box-title">{{__('admin_message.residence photo')}}</p>
                          @if($delegate->license_photo==NULL)
                                <img src="{{asset('storage/'.$webSetting->logo)}}" class="img-circle" alt="User Image"
                                    width="50" height="50">

                                @else
                                <a download="{{asset('storage/'.$delegate->residence_photo)}}" class="pull-right">
                                    <img src="{{asset('storage/'.$delegate->residence_photo)}}" class="img-circle"
                                        alt="User Image" width="50" height="50">
                                    @endif
                      </div>
                 </div>
              </div>
               


 
            
          </div>
       </div>




        <div class="row"> 
            <div class="col-md-12">

                <ul class="nav nav-pills nav-stacked col-md-3 bg-gray">

                    <li class="active"><a data-toggle="tab" href="#menu1">{{__('admin_message.all')}}</a></li>
                    <li><a data-toggle="tab" href="#menu2">{{__('admin_message.today')}}</a></li>
                    <li><a data-toggle="tab" href="#menu3">{{__('admin_message.yesterday')}}</a></li>
                    <li><a data-toggle="tab" href="#menu4">{{__('admin_message.Last 30 days')}}</a></li>
                </ul>


                <div class="tab-content col-md-9">
                    <div id="menu1" class="tab-pane fade in active">
                        @foreach($statuses as $status)
                        <div class="col-sm-6 col-md-6 ">
                            <div class="small-box  bg-gray"
                               >
                                <h4 class="text-center">

                                    {{$status->orders()->where('delegate_id', $delegate->id)->count()}}
                                </h4>
                                <p class="text-center">{{$status->trans('title')}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="menu2" class="tab-pane fade in">
                        <?php $today = (new \Carbon\Carbon)->today(); ?>
                        @foreach($statuses as $status)
                        <div class="col-sm-6 col-md-6 ">
                            <div class="small-box  bg-gray"
                                >
                                <h4 class="text-center">

                                    {{$status->orders()->whereDate('created_at', $today)->where('delegate_id', $delegate->id)->count()}}
                                </h4>
                                <p class="text-center">{{$status->trans('title')}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="menu3" class="tab-pane fade in">
                        <?php $yesterday = (new \Carbon\Carbon)->yesterday(); ?>
                        @foreach($statuses as $status)
                        <div class="col-sm-6 col-md-6 ">
                            <div class="small-box  bg-gray"
                               >
                                <h4 class="text-center">

                                    {{$status->orders()->whereDate('created_at', $yesterday)->where('delegate_id', $delegate->id)->count()}}
                                </h4>
                                <p class="text-center">{{$status->trans('title')}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="menu4" class="tab-pane fade in">
                        <?php $month = (new \Carbon\Carbon)->subMonth()->submonths(1); ?>
                        @foreach($statuses as $status)
                        <div class="col-sm-6 col-md-6 ">
                            <div class="small-box  bg-gray">
                                <h4 class="text-center">

                                    {{$status->orders()->whereDate('created_at', '>', $month)->where('delegate_id', $delegate->id)->count()}}
                                </h4>
                                <p class="text-center">{{$status->trans('title')}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>


            </div>

        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection