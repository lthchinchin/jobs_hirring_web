<!DOCTYPE html>
<html lang="en">

<head>
    <title>IT job hirring</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</head>
<style>
    
    #f {
        margin-top: 20px;
        background-color: #2e3d4d!important;
        
    }
    #nav{
        background-color: #2e3d4d!important;
    }
</style>

<body>

    <nav id="nav" class="navbar navbar-expand-sm bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="{{URL::to('/')}}">Logo</a>

        <!-- Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{URL::to('/dog')}}">Relax</a>
            </li>
            <!-- Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    Diagram
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{URL::to('/diagram')}}">Program Language</a>
                    <a class="dropdown-item" href="#">Link 2</a>
                    <a class="dropdown-item" href="#">Link 3</a>
                </div>
            </li>
            <?php
            if (Session('acc_id') != null) {
            ?>
                <li class="nav-item">
                    <a class="disabled nav-link" id="accname" href="">{{ Session::get('acc_name')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{URL::to('/admin-jobhirring')}}">Manage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{URL::to('/logout')}}">Logout</a>
                </li>
            <?php
            }
            ?>
        </ul>
    </nav>
    <br>

    <!-- <div class="container">
        <h3>Navbar With Dropdown</h3>
        <p>This example adds a dropdown menu in the navbar.</p>
    </div> -->
    @yield('content')
</body>
<footer id="f" class="py-4 bg-dark text-white-50">
    <div class="container text-center">
        <small>Copyright &copy; Your Website</small>
    </div>
</footer>


</html>