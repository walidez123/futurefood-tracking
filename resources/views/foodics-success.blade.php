@extends('website.layouts.master')
@section('pageTitle', __('website.home'))
@section('content')


 
<section class="flat-row flat-contact">

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
            <h1>تم الربط بنجاح</h1>
                <h2>سوف يتواصل معك فريق المبيعات</h2>
                <h3>Email: <a href="mailto:{{$webSetting->email}}">{{$webSetting->email}}</a></h3>
                <h3>Phone: 
                <a href="tel: {{$webSetting->phone}}"> {{$webSetting->phone}}</a>
                   </h3>
            </div>
        </div>
    </div>
</section>
    @endsection