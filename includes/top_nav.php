<?php
$_pageName = $_SERVER['SCRIPT_NAME'];
if($_pageName == 'jobsearch.php')
    $_class_active = 'class="active"';
elseif($_pageName == 'examoverview.php')
    $_class_active = 'class="active"';
else
    $_class_active = '';
?>

 <div class="header_bg1">
    <div class="container">
      <div class="row header">
        <div class="logo navbar-left">
            <h1><a href="home">Smartguidance</a></h1>
        </div>
        <!--<div class="h_search navbar-right">
            <form>
                <input type="text" class="text" value="Enter text here" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Enter text here';}">
                <input type="submit" value="search">
            </form>
        </div>-->
        <div class="clearfix"></div>
    </div>

 <nav>
    <ul class="dropdown">
            <li><a href="#">HOME</a> </li>

            <li><a href="#">ABOUT US</a> </li>

            <li class="drop"><a href="#">JOB SEARCH</a>
                <ul class="sub_menu">
                    <li><a param="1" href="home.php">Lorem</a></li>
                    <li><a param="1" href="#">Ipsum</a></li>
                    <li><a param="1" href="#">Dolor</a></li>
                    <li><a param="1" href="#">Lipsum</a></li>
                    <li><a param="1" href="#">Consectetur </a></li>
                    <li><a param="1" href="#">Duis</a></li>
                    <li><a param="1" href="#">Sed</a></li>
                    <li><a param="1" href="#">Natus</a></li>
                    <li><a param="1" href="#">Excepteur</a></li>
                </ul>
            </li>
            <li class="drop"><a href="#">EXAM OVERVIEW</a>
                <ul class="sub_menu">
                    <li><a href="#">Lorem</a></li>
                    <li><a href="#" >Ipsum</a></li>
                    <li><a href="#">Dolor</a></li>
                    <li><a href="#">Lipsum</a></li>
                    <li><a href="#">Consectetur </a></li>
                    <li><a href="#">Duis</a></li>
                    <li><a href="#">Sed</a></li>
                    <li><a href="#">Natus</a></li>
                    <li><a href="#">Excepteur</a></li>
                    <li><a href="#">Voluptas</a></li>
                    <li><a href="#">Voluptate</a></li>
                </ul>
            </li>
            <li class="drop"><a href="#" id="firstline_3">EXAM GUIDANCE</a>
                <ul class="sub_menu">
                    <li><a param="3" href="career.php">Lorem</a></li>
                    <li><a href="#">Ipsum</a></li>
                    <li><a href="#">Dolor</a></li>
                    <li><a href="#">Lipsum</a></li>
                    <li><a href="#">Consectetur </a></li>
                </ul>
            </li>

            <li class="drop"><a href="#" id="firstline_3">COURSES</a>
                <ul class="sub_menu">
                    <li><a param="3" href="career.php">Lorem</a></li>
                    <li><a href="#">Ipsum</a></li>
                    <li><a href="#">Dolor</a></li>
                    <li><a href="#">Lipsum</a></li>
                    <li><a href="#">Consectetur </a></li>
                </ul>
            </li>

             <li class="drop"><a href="#" id="firstline_3">NOTES</a>
                <ul class="sub_menu">
                    <li><a param="3" href="career.php">Lorem</a></li>
                    <li><a href="#">Ipsum</a></li>
                    <li><a href="#">Dolor</a></li>
                    <li><a href="#">Lipsum</a></li>
                    <li><a href="#">Consectetur </a></li>
                </ul>
            </li>

            <li><a href="#">CONTACT</a> </li>
        </ul>
</nav>



  <div class="clearfix"></div>
 </div>
</div>