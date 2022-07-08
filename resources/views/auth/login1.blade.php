<!DOCTYPE html>
<html lang="en">
<head>
    <title>سفیر حسین(ع) 2</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--==============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <!--===============================================================================================-->

</head>
<body style="background-color: #666666;">
<div class="root-app" id="app">
    <div class="login-wrapper">
        <header-component></header-component>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <login-component></login-component>
            <div style="padding-right: 10%">

                @error('tel')
                <strong style="color: red">اطلاعات وارد شده اشتباه است </strong>
                @enderror
                @error('password')
                <strong style="color: red">اطلاعات وارد شده اشتباه است</strong>
                @enderror
                </ul>
            </div>

            <div class="container-login100-form-btn">
                <button class="login100-form-btn form-control" type="submit">
                    ورود
                </button>
            </div>
        </form>
        <div class="row" style="direction:ltr">
            <div class=" col-5 ">

                <a href="/shop">ورود کتابفروشان</a>
            </div>
            <v-spacer></v-spacer>
            <div class="col-5">

                <a href="/distributor">ورود شرکت پخش</a>
            </div>
        </div>

        <div class="footer-bottom mt-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-4 ">
                        <a href="#">
                            <img class="logo" src="{{URL::asset('./images/neshan.jpeg')}}" alt="سفیر حسینی">
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4 col-4 ">
                        <a href="{{ url('http://www.khooshe.org/') }}">
                            <img class="logo" src="{{URL::asset('./images/khooshe.png')}}" alt="سفیر حسینی">
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4 col-4 ">
                        <a href="#">
                            <img class="logo" src="{{URL::asset('./images/shirazeh.png')}}" alt="سفیر حسینی">
                        </a>
                    </div>

                </div>
                <div class="row mt-2">
                    <div class="col-12" style="text-align: center"><span></span>پشتیبانی:
                        <br>
                        <br>
                        <h6>02166123090</h6>
                        <h6>09929912812</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner">
        <div id="carouselExampleIndicators" class=" carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="https://khooshe.org/?p=3235">
                        <img class="d-block w-100 login100-more"
                             src="images/welcome/bg-02.jpg" alt="First slide">
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="https://khooshe.org/?p=3245">
                        <img class="d-block w-100 login100-more"
                             src="images/welcome/bg-03.jpg" alt="Second slide">
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="https://khooshe.org/?p=3249">
                        <img class="d-block w-100 login100-more"
                             src="images/welcome/bg-04.jpg" alt="Third slide">
                    </a>

                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>


</div>


<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    function validate(evt) {
        var theEvent = evt || window.event;

        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            // Handle key press
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>
</body>
</html>
