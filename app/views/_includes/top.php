<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Page Title -->
    <title>Fitzone<?php
        if(isset($data['pageDetails']['pg_title'])){
            echo ' | ' . escape(ucwords($data['pageDetails']['pg_title']));
        }?>
    </title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo DIST ?>/img/logo/favicon.png" type="image/x-icon">
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo DIST ?>/css/animate-3.7.0.css">
    <link rel="stylesheet" href="<?php echo DIST ?>/css/font-awesome-4.7.0.min.css">
    <link rel="stylesheet" href="<?php echo DIST ?>/fonts/flat-icon/flaticon.css">
    <link rel="stylesheet" href="<?php echo DIST ?>/css/bootstrap-4.1.3.min.css">
    <link rel="stylesheet" href="<?php echo DIST ?>/css/owl-carousel.min.css">
    <link rel="stylesheet" href="<?php echo DIST ?>/css/nice-select.css">
    <link rel="stylesheet" href="<?php echo DIST ?>/css/main.css">
    <meta name="author" content="Radoslaw Soltan">
    <meta name="description" content="<?php
        if(isset($data['pageDetails']['pg_desc'])){
            echo escape(ucwords($data['pageDetails']['pg_desc']));
        }
        else{
            echo "Fitzone Website";
        }
    ?>">
    <meta name="keywords" content="<?php
        if(isset($data['pageDetails']['pg_keys'])){
            echo escape(ucwords($data['pageDetails']['pg_keys']));
        }
        else{
            echo "Fitzone Gym Fitness Join Premium";
        }
    ?>">
</head>
<body>
<?php if(isset($name) && Session::exists($name)){ ?>
    <div class="flash">
        <?php echo Session::flash($name)?>
    </div>
<?php }?>