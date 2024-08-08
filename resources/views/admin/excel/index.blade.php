
          <table>
              <thead>
                <tr>
                  <th></th>
                  <th>الكود الوظيفى</th>
                  <th>المندوب</th>
                  <th>المدينة</th>
                  <th>العميل</th>
                  <th> طلبات المستلمة</th>
                  <th> طلبات تم تسليمها</th>
                  <th>الطلبات المسترجعة</th>
                  <th> المبلغ المتحصل</th>
                  <th>  التاريخ</th>
                </tr>
              </thead>
              <tbody>
                <?php $count=0; ?>
              
                @foreach ($reports as $report)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{!empty($report->delegate) ? $report->delegate->code : ''}}</td>
                  <td>{{!empty($report->delegate) ? $report->delegate->name : ''}}</td>
                  <td>{{!empty($report->delegate->city) ? $report->delegate->city->title : ''}}</td>
                  <td>{{!empty($report->client) ? $report->client->store_name : ''}}</td>
                  <td>{{$report->Recipient}}</td>
                  <td>{{$report->Received}}</td>
                  <td>{{$report->Returned}}</td>
                  <td>{{$report->total}}</td>
                  <td>{{$report->date}}</td>
                </tr>
                <?php $count++ ?>
                @endforeach
                <tr>
                <td>الإجمالى</td>
                  <td></td>
                  <td></td>
                  <td></td>

                  <td></td>
                  <td> {{$Recipient}}</td>
                  <td> {{$Received}} </td>
                  <td> {{$Returned}}</td>
                  <td>  {{$total}}</td>
                  <td></td>
                </tr>


              </tbody>
            
            </table>



          

       
