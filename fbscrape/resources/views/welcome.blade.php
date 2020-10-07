<!DOCTYPE html>
<html>
<?php

use Illuminate\Support\Facades\Session;

include_once 'format.php';
$fm = new Format();
?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<head>
    <style>
        .control-label {
            font-weight: bold;
        }
    </style>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .topnav {
            overflow: hidden;
            background-color: #555555;
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active:hover {
            background-color: #73be76;
            color: black;
        }

        .topnav a.active {
            background-color: #4CAF50;
            color: white;
        }

        #accname {
            text-decoration: none;
            pointer-events: none;
            cursor: default;

        }
    </style>

</head>

<body>
    <div class="topnav" >
        <a class="active" href="{{URL::to('/')}}">Home</a>
        <a href="{{URL::to('/diagram')}}">Diagram</a>
        <div class="w3-dropdown-hover">
            <button class="w3-button">Dropdowntest</button>
            <div class="w3-dropdown-content w3-bar-block w3-card-4">
                <a href="#" class="w3-bar-item w3-button">Link 1</a>
                <a href="#" class="w3-bar-item w3-button">Link 2</a>
                <a href="#" class="w3-bar-item w3-button">Link 3</a>
            </div>
        </div>
        <a href="{{URL::to('/dog')}}">Relax</a>
        <a href="{{URL::to('/admin-jobhirring')}}">Manage</a>
        <?php
        if (Session('acc_id') != null) {
        ?>
            <a id="accname" href="">{{ Session::get('acc_name')}}</a>
            <a href="{{URL::to('/logout')}}">Logout</a>
        <?php
        } else {
        ?>
            <a href="{{URL::to('/login')}}"> Login</a>
        <?php
        }
        ?>
    </div>
    @yield('content')
</body>

</html>