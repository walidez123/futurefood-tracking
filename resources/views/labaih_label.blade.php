@extends('website.layouts.master')
@section('pageTitle', __('website.home'))
@section('content')


 
<section class="flat-row flat-contact">

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
            {!!$data!!}
            </div>
        </div>
    </div>
</section>
    @endsection