@extends('layouts.master')
@section('pageTitle', 'Order Comments')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' => 'Comments for order '.$order->order_id, 'iconClass' => 'fa-comments', 'addUrl' => '', 'multiLang' => 'false'])

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
                <a class="btn btn-warning" href="javascript:history.back()"><i
                        class="fa fa-reply-all"></i> Back to previous </a>

          <button type="button" class="btn btn-info pull-center" data-toggle="modal"
          data-target="#add-comment">
          <i class="fa fa-commenting"></i>
          Add Comment
      </button>
            </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                    <th>Comment</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>control</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($comments as $comment)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$comment->comment}}</td>
                  <td>{{$comment->user->name}}</td>
                  <td>{{$comment->dateFormatted()}}</td>
                    <td>
                            <form class="pull-right" style="display: inline;" action="{{route('supervisororderscomments.destroy', $comment->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                </button>
                            </form>
                       


                    </td>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Comment</th>
                  <th>User</th>
                  <th>Date</th>
                  <th>control</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div class="modal fade" id="add-comment">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Comment To Order {{$order->order_id}}</h4>
            </div>
            <form action="{{route('supervisororderscomments.store')}}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label  class="control-label">Comment *</label>
                        <textarea style="width:100%" rows="3" name="comment" id="description" required></textarea>
                    </div>
                </div>
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('order.Close')</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
@endsection
