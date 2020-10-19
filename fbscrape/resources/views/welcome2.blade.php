<!DOCTYPE html>
<html lang="en">

<head>
    <title>IT job hiring</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</head>
<style>
    #adname:hover {
        background-color: #93a9c4;
    }

    #f {
        margin-top: 150px;
        background: #2e3d4d !important;
    }

    #nav {
        background-color: #2e3d4d !important;
    }
</style>

<body>

    <nav id="nav" class="navbar navbar-expand-sm bg-dark navbar-dark">
        <!-- Brand -->
        <a href="{{URL::to('/')}}"><img id="img_product" src="{{asset('public/logo.png')}}" alt="logo_img" width="50px" height="50px" /></a>

        <!-- Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <!-- <a class="nav-link" href="{{URL::to('/dog')}}">Relax</a> -->
            </li>
            <!-- Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbardrop" data-toggle="dropdown">Diagram</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{URL::to('/diagram')}}">Program Language</a>
                    <a class="dropdown-item" href="{{URL::to('/diagram2')}}">Company</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{URL::to('/topic')}}">Topic</a>
            </li>
            <?php if (Session('acc_id') == null) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="{{URL::to('/login')}}">Login</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="disabled nav-link" id="accname" href="">{{ Session::get('acc_name')}}</a>
            </li>
            <?php
            if (Session('acc_id') != null) {
                if (Session('acc_level') == 1) {
            ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown">Manage</a>
                        <div class="dropdown-menu">
                            <a id="adname" class="dropdown-item" style="text-align: center;" href="#">{{Session::get('acc_name')}}</a>
                            <a class="dropdown-item" href="{{URL::to('/admin-jobhiring')}}">Data</a>
                            <a class="dropdown-item" href="{{URL::to('/admin-account')}}">Users Account</a>
                            <a class="dropdown-item" href="{{URL::to('/logout')}}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </li>
                <?php
                } else {
                ?>
                    <li class="nav-item">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" id="navbardrop" data-toggle="dropdown"></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{URL::to('/change-password')}}" id="myacc">My Account</a>
                            <a class="dropdown-item" href="{{URL::to('/logout')}}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </li>
                    </li>
            <?php
                }
            }
            ?>
        </ul>
    </nav>

    @yield('content')
</body>
<footer id="f" class="py-4 bg-dark text-white-50">
    <div class="container text-center">
        <small>Copyright &copy; Your Website</small>
    </div>


</footer>


</html>