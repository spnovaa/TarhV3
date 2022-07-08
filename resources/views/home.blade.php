<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{$tarh_name}}</title>
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
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <!--===============================================================================================-->
    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

</head>
<body style="background-image: linear-gradient(45deg , #c33764 , #1d2671);">
{{--<body style="background-image: linear-gradient(45deg, #d2379b, #102eff);">--}}
<div class="row" style="margin: 0 30px; height: 100vh; text-align: center; justify-content: center">

    <div class="col-lg-4 col-md-12 col-sm-12 center-screen">
        <div class="card landing-logo-wrapper">

            <div class="card-body ">
                <div class="wrap">
                <span class="ribbon5">
                    <span>ورود</span>
                </span>
                </div>

                <div class="row-cols-1">
                    <div class="col-12">
                        <div class="row"
                             style="align-items: center; justify-content: center; color: white; margin-top: 25px">
                            <h3>
                                انتخاب طرح
                            </h3>
                        </div>
                        <hr/>

                        <div class="row" style="color: #BDBDBD; margin-top: 70px; text-align: right; padding: 5px; ">
                            <h6 style="line-height: 2">
                                لطفا طرح مورد نظر خود را جهت ورود یا ثبت نام انتخاب نمایید.
                            </h6>
                        </div>
                        <div style="margin: 40px"></div>
                        <a href="{{ route('terms1') }}">
                            <button class="bn54">
                                <span class="bn54span">مسابقه بزرگ کتابفروشی</span>
                            </button>
                        </a>

                        <a href="./login">
                            <button class="bn54">
                                <span class="bn54span">پویش سفیر حسین (ع)</span>
                            </button>
                        </a>
                        <div style="margin: 30px"></div>
                        <hr/>
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8" style="margin-top: 15px">
                            <span style="font-size: small; direction: rtl">
                                پشتیبانی:
                                02166123090
                            </span>
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="landing-banner center-screen text-center col-lg-8 col-md-12 col-sm-12 ">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"
             style="box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="https://khooshe.org/?p=4337">
                        <img class="d-block landing-banner"
                             src="images/welcome/poster1.jpg" alt="First slide">
                    </a>

                </div>
                <div class="carousel-item">
                    <a href="https://khooshe.org/?p=3311">
                        <img class="d-block landing-banner"
                             src="images/welcome/bg-05.jpg" alt="Second slide">
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="https://khooshe.org/?p=3324">
                        <img class="d-block landing-banner"
                             src="images/welcome/bg-06.jpg" alt="Third slide">
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
    <h6 hidden>Powered By Spnova@aut.ac.ir</h6>
</div>
<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>
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
