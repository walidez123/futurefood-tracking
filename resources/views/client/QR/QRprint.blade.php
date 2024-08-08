@extends('layouts.master')
@section('pageTitle',__('admin_message.Print'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' =>__('admin_message.Print'), 'type' => __('admin_message.Print'), 'iconClass' => 'fa-print', 'url' =>
    route('goods.index'), 'multiLang' => 'false'])
    <!-- Main content -->
      <style>
      .page-logo{
    display:none;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 25px
  
}

td, th {
  border: 1px solid #dddddd;
  text-align: RIGHT;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
span.h4 {
    float: right;
    highet:60px;
}

      @media print {
   .page-header {display:none;}
      .page-logo{
    display:block;
}




span.h4 {
    float: right;
    highet:60px;
}


@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
.main-footer{display:none;}
.printhidden{display:none;}
}

  </style>
    <section class="invoice">
        
        <div class="row invoice-info">

            <!-- /.col -->
               
                    @if(isset($all_good))
                    @foreach($all_good as $good)
                    @for($i=1;$i<=$number;$i++)
                    <div class="col-xs-3 col-md-3 col-lg-3  invoice-col">
                    <div class="col-xs-12 col-md-12 col-lg-12 ">

                    @if($type=='QRcode')

                    {!! QrCode::size(150)->generate($good[0]) !!}
                    <!-- <h4>{{$good[0]}}</h4> -->
                    <center> <h4>{{$good[0]}}</h4></center>

                    @elseif($type=='Barcode')
                    {!! DNS1D::getBarcodeSVG($good[0], 'C128') !!}
                  
                    @endif
                    </div>
        </div>
                    @endfor

                    @endforeach
                    @endif
                    @if(isset($warahouse))
                    @foreach($warahouse as $warahouse1)

                    @for($i=1;$i<=$number;$i++)
                    <div class="col-xs-3 col-md-3 col-lg-3  invoice-col">
                    <div class="col-xs-12 col-md-12 col-lg-12 ">

                    @if($type=='QRcode')
                    
                    {!! QrCode::size(150)->generate($warahouse1[0]) !!}
                   <center> <h4>{{$warahouse1[0]}}</h4></center>

                    @elseif($type=='Barcode')
                    {!! DNS1D::getBarcodeSVG($warahouse1[0], 'C128') !!}


                    @endif
                    </div>
                </div>
                    @endfor
                   
                    @endforeach

                    <!-- content  -->
                    @if(isset($content))


                    @foreach($content as $singlecontent)
                    @foreach($singlecontent as $last)


@for($i=1;$i<=$number;$i++)
<div class="col-xs-3 col-md-3 col-lg-3  invoice-col">
<div class="col-xs-12 col-md-12 col-lg-12 ">

@if($type=='QRcode')

{!! QrCode::size(150)->generate($last->title) !!}
<center> <h4>{{$last->title}}</h4></center>

@elseif($type=='Barcode')
{!! DNS1D::getBarcodeSVG($last->title, 'C128') !!}


@endif
</div>
</div>
@endfor
@endforeach


@endforeach
@endif







                    <!--  -->




                    @endif
              
                <br>
        </div>
          


  
       

    </section>
    <div class="row no-print">

    <div class="col-xs-12">
                <a onclick="window.print()" target="_blank" class="btn btn-default printhidden"><i class="fa fa-print"></i>
                    {{__('admin_message.Print')}}</a>
            </div>
    </div>
    <!-- /.content -->
    
    <!-- /.modal-dialog -->
</div>
</div><!-- /.content-wrapper -->
@endsection
