<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{$appSetting->name}} | 404</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" ></script>
    <style type="text/css">
        body{
          margin-top: 150px;
            background-color: #FF3838;
        }
        .error-main{
          background-color: #fff;
          box-shadow: 0px 10px 10px -10px #5D6572;
        }
        .error-main h1{
          font-weight: bold;
          color: #FF3838;
          font-size: 100px;
          text-shadow: 2px 4px 5px #6E6E6E;
        }
        .error-main h6{
          color: #42494F;
        }
        .error-main p{
          color: #9897A0;
          font-size: 14px; 
        }
    </style>
</head>
<body>
    <div class="container">
      <div class="row text-center">
        <div class="col-lg-6 offset-lg-3 col-sm-6 offset-sm-3 col-12 p-3 error-main">
          <div class="row">
            <div class="col-lg-8 col-12 col-sm-10 offset-lg-2 offset-sm-1">
              <h1 class="m-0">404</h1>
              <h6>هذه الصفحة غير موجودة - {{$webSetting->Trans('title')}}</h6>
              <p>للرجوع للصفحة السابقة <span class="text-info">
                <a href="javascript:history.back()">اضغط هنا</a>
                
              </span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>