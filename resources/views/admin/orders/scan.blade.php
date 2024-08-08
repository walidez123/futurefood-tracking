@extends('layouts.master')
@section('pageTitle', __("admin_message.Order"))
@section('nav')
@include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
<div class="content-wrapper">
  <section class="invoice">
    <div class="row">
      <div class="col-lg-6">
        <label>{{ __('admin_message.statuses') }}</label>
        <select id="status_id" class="form-control select2" name="status_id">
          <option value="">
            {{ __('admin_message.Choose a statuses') }}
          </option>
          @foreach ($statuses as $status)
        <option {{ isset($status_id) && $status_id == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
        {{ $status->trans('title') }}
        </option>
      @endforeach
        </select>
      </div>
      <div class="col-xs-12 ">

        <div class="container mt-5">
          <h5>{{ __('admin_message.Order Number') }}</h5>
          <div class="col-lg-6">
            <input type="text" id="orderIDInput" class="form-control mb-2"
              placeholder="{{ __('admin_message.Order Number') }}"><br>
          </div>
          <button id="addOrderBtn" class="btn btn-primary mb-2">{{ __('order.add_new_order') }}</button><br>
          <div class="col-xs-10 ">
            <table id="orderTable" class="table">
              <thead>
                <tr>
                  <th>{{ __('admin_message.Order Number') }}</th>
                  <th>{{ __('order.sender_name') }} </th>
                  <th>{{ __('admin_message.status') }}</th>
                </tr>
              </thead>
              <tbody id="orderTableBody">
              </tbody>
            </table>
            <button id="changeStatusBtn" class="btn btn-success">{{ __('admin_message.Status change') }}</button>
          </div>
        </div>

      </div>


    </div>

</div>

</section>

</div>@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
  $(document).ready(function () {

    var existingOrderIDs = new Set();

    $('#addOrderBtn').click(function () {
      var orderID = $('#orderIDInput').val();

      if (!orderID) {
        alert('Please enter an order ID.');
        return;
      }

      if (existingOrderIDs.has(orderID)) {
        alert('Order ' + orderID + ' already exists in the table.');
        return;
      }

      // Add orderID to the set
      existingOrderIDs.add(orderID);

      // If order doesn't exist, proceed with AJAX request... (rest of your code)
      $.ajax({
        url: '/admin/check-order-exists',
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          orderID: orderID
        },

        success: function (response) {
          // console.log(response.exists) 
          if (response.exists) {
            $('#orderTableBody').append('<tr id="order_' + orderID + '"><td>' + orderID + '</td><td>' + response.username + '</td><td>' + response.status + '</td></tr>');
          } else {
            alert('Order not found.');
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
          // Handle error response
        }
      });

      $('#orderIDInput').val('');
    });


    // Send AJAX request to get order status  
    $('#changeStatusBtn').click(function () {
      var orderIDs = [];
      $('#orderTableBody tr').each(function () {
        orderIDs.push($(this).find('td:first').text());
      });
      var status_id = $('select[name=status_id]').val(); // Get the selected status ID


      // Send AJAX request to change status 
      $.ajax({
        url: '/admin/change-status',
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}', 
          orderIDs: orderIDs,
          status_id: status_id

        },
        success: function (response) {
          if (response.message) {
            // console.log(response.message);
            alert('All order status changed successfully');
            $('#orderTableBody tr').each(function () {
              $(this).find('td:last').text(response.status);
            });
          }
          else {
            alert('wrong');
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
          // Handle error response
        }
      });
    });
  });
</script>
@endsection