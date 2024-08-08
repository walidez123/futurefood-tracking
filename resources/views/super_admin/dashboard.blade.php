@extends('layouts.master')
@section('pageTitle', 'لوحه التحكم')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      الرئيسية 
    </h1>
 
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        
            <div class="info-box  bg-gr1">
                <span class="info-box-icon  elevation-1"><i class="fa-solid  fa-basket-shopping"></i></span>
                <div class="info-box-content">
                <span class="info-box-text"> الشركات</span>
                <span class="info-box-number">{{count($companies)}}</span>
                </div>
            </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        
         <div class="info-box  bg-red">
                <span class="info-box-icon  elevation-1"><i class="fa-solid fa-truck"></i></span>
                <div class="info-box-content">
                <span class="info-box-text"> الشركات المفعلة</span>
                <span class="info-box-number">{{\App\Models\User::where('user_type', 'admin')->where('is_company',1)->where('company_active','1')->count()}}</span>
                </div>
            </div>
            
 
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
          <div class="info-box  bg-green">
                <span class="info-box-icon"><i class="fa-solid fa-cart-plus"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">  الشركات الغير مفعلة</span>
                <span class="info-box-number">{{\App\Models\User::where('user_type', 'admin')->where('company_active','0')->count()}}</span>
                </div>
            </div>
        
      </div>
      
    </div>
        <div class="row">
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        
            <div class="info-box bg-blue">
                <span class="info-box-icon  elevation-1"><i class="fa-solid  fa-cart-plus"></i></span>
                <div class="info-box-content">
                <span class="info-box-text"> جميع طلبات المنصة</span>
                <span class="info-box-number">{{\App\Models\Order::count()}}</span>
                </div>
            </div>
      </div>

      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        
            <div class="info-box bg-green">
                <span class="info-box-icon  elevation-1"><i class="fa-solid  fa-cart-plus"></i></span>
                <div class="info-box-content">
                <span class="info-box-text"> عدد طلبات الشهر الحالى</span>
                <span class="info-box-number">{{$orderMonth}}</span>
                </div>
            </div>
      </div>

      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        
            <div class="info-box bg-blue">
                <span class="info-box-icon  elevation-1"><i class="fa-solid  fa-cart-plus"></i></span>
                <div class="info-box-content">
                <span class="info-box-text"> عدد طلبات الشهر سلة</span>
                <span class="info-box-number">{{$orderMonthSalla}}</span>
                </div>
            </div>
      </div>
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        
            <div class="info-box bg-yellow">
                <span class="info-box-icon  elevation-1"><i class="fa-solid  fa-cart-plus"></i></span>
                <div class="info-box-content">
                <span class="info-box-text"> عدد طلبات الشهر زد</span>
                <span class="info-box-number">{{$orderMonthZid}}</span>
                </div>
            </div>
      </div>
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        
            <div class="info-box bg-blue">
                <span class="info-box-icon  elevation-1"><i class="fa-solid  fa-utensils"></i></span>
                <div class="info-box-content">
                <span class="info-box-text"> عدد طلبات الشهر فودكس</span>
                <span class="info-box-number">{{$orderMonthFoodics}}</span>
                </div>
            </div>
      </div>

     
      
    </div>
    <canvas id="ordersChart" width="400" height="100"></canvas>

  
  
           
     
  </section> 
  <!-- /.content -->
</div>
@endsection
@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
        var borderColor = [
        'rgba(255, 99, 132, 1)',    // January
        'rgba(54, 162, 235, 1)',    // February
        'rgba(255, 206, 86, 1)',    // March
        'rgba(75, 192, 192, 1)',    // April
        'rgba(153, 102, 255, 1)',   // May
        'rgba(255, 159, 64, 1)',    // June
        'rgba(199, 199, 199, 1)',   // July
        'rgba(83, 102, 255, 1)',    // August
        'rgba(255, 99, 132, 1)',    // September
        'rgba(54, 162, 235, 1)',    // October
        'rgba(255, 206, 86, 1)',    // November
        'rgba(75, 192, 192, 1)'     // December
    ];
    var backgroundColors = [
        'rgba(255, 99, 132, 0.2)',    // January
        'rgba(54, 162, 235, 0.2)',    // February
        'rgba(255, 206, 86, 0.2)',    // March
        'rgba(75, 192, 192, 0.2)',    // April
        'rgba(153, 102, 255, 0.2)',   // May
        'rgba(255, 159, 64, 0.2)',    // June
        'rgba(199, 199, 199, 0.2)',   // July
        'rgba(83, 102, 255, 0.2)',    // August
        'rgba(255, 99, 132, 0.2)',    // September
        'rgba(54, 162, 235, 0.2)',    // October
        'rgba(255, 206, 86, 0.2)',    // November
        'rgba(75, 192, 192, 0.2)'     // December
    ];
        var ctx = document.getElementById('ordersChart').getContext('2d');
        var ordersChart = new Chart(ctx, {
            type: 'bar', // You can change this to 'line', 'bar', etc.
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'الطلبات',
                    data: @json(array_values($monthlyData)),
                    backgroundColor: backgroundColors,
                    borderColor: borderColor ,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endsection
