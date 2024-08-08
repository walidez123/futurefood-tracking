@if($otps->count() > 0)

@if (in_array('show_otp_order', $permissionsTitle))

  <div class="row">
  <div class="col-md-12">

    <p>{{__("app.Requests to OTP client")}}</p>
    <table class="table table-bordered table-striped table-hover ">
      <thead>
        <tr>        
          <th>{{__("admin_message.code")}}</th>
          <th>{{__("admin_message.Delegate")}}</th>
          <th>{{__("admin_message.status")}}</th>
          <th>{{__("admin_message.confirmation")}}</th>
          <th>{{__("admin_message.availabe to")}}</th>
          <th>{{__("admin_message.created date")}}</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $date = now()->format('Y-m-d');
          ?>
        @foreach ($otps as $i=>$otp)
        @if($otp->validate_to < $date) <tr style="color: red;">

          @else
          <tr>

            @endif

            <th>{{$otp->code}}</th>
            <th>{{$otp->delegate->name}}</th>
            <th>{{$otp->status->trans('title')}}</th>
            <th>
              @if($otp->is_used==0)
              {{__("admin_message.Not confirmed")}}
              @else
              {{__("admin_message.confirmation")}}
              @endif
            </th>
            @if($otp->validate_to < $date) <th style="color: red;"> {{$otp->validate_to}}</th>
              @else
              <th> {{$otp->validate_to}}</th>


              @endif
              <th> {{$otp->created_at}}</th>
          </tr>
          @endforeach
      </tbody>
    </table>
  </div>

  </div>
  @endif
  @endif