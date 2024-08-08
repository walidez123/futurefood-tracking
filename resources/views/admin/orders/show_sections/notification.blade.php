  <!-- notifucation -->
  @if(count($order->notification_details)>0)
  <div class="row">
    <div class="col-md-12">
      <p>@lang('app.notifications', ['attribute' =>  ''])</p>
      <table class="table table-bordered table-striped table-hover ">
        <thead>
          <tr>        
            <th>{{__("admin_message.from")}}</th>
            <th>{{__("admin_message.to")}}</th>
            <th>{{__("admin_message.Title")}}</th>
            <th>{{__("admin_message.Message")}}</th>
            <!-- <th>{{__("admin_message.")}}</th> -->
            <th>{{__("admin_message.created date")}}</th>
          </tr>
        </thead>
        <tbody>
       
          @foreach ($order->notification_details as $i=>$notification)
        
              <th>{{ ! empty($notification->sender) ? $notification->sender->name : ''}}</th>
              <th>{{ ! empty($notification->recipient) ? $notification->recipient->name : ''}}</th>

              <th>{{$notification->title}}</th>
              <th>{{$notification->message}}</th>
              <!-- <th>
                @if($notification->is_readed==0)
                {{__("admin_message.read")}}
                @else
                {{__("admin_message.unread")}}
                @endif
              </th> -->
              <th>{{$notification->dateFormatted()}}</th>
             
            
            </tr>
            @endforeach
        </tbody>
      </table>
      </div>

    </div>




  @endif
  <!-- end notifucation -->