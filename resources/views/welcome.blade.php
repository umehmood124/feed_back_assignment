<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feedback Application</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('icons/fb-icon.ico')}}">
    <!-- Include your CSS styles here -->

    <link rel="stylesheet" type="text/css" href="{{asset('public/app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/app-assets/vendors/css/forms/wizard/bs-stepper.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/app-assets/vendors/css/forms/select/select2.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/app-assets/css/bootstrap.css') }}">


</head>
<body class="antialiased">
<div id="app">

    <!-- Your Vue component will be rendered here -->
    <!-- Make sure your Vue component is properly compiled and included in the JavaScript file -->
    <!-- For example, if your Vue component is named 'login_page', it should be rendered here -->
{{--    <login_page></login_page>--}}
    <router-view></router-view>
</div>

<!-- Include your compiled JavaScript file -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- Include any additional scripts if needed -->
</body>
</html>
