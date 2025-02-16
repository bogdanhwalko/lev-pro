<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<header class="site-header mo-left onepage construct-header header">
    <!-- main header -->
    <div class="top-bar">
        <div class="container">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="dlab-topbar-left">
                    <ul>
                        <li><a href="javascript:void(0);"><i class="fa fa-envelope-o m-r5 tetx-primary"></i><?= Yii::$app->params['senderEmail']?></a></li>

                    </ul>
                </div>
                <div class="dlab-topbar-right">
                    <ul>
                        <li><a href="javascript:void(0);">About Us</a></li>
                        <li><a href="javascript:void(0);">Refund Policy</a></li>
                        <li><a href="javascript:void(0);">Help Desk</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="sticky-header main-bar-wraper navbar-expand-lg">
        <div class="main-bar clearfix onepage">
            <div class="container clearfix">
                <!-- website logo -->
                <div class="logo-header mostion">
                    <a href="<?=Yii::$app->homeUrl?>">
                        <?= Html::img('@web/images/logo.png', ['alt' => ""]); ?>
                    </a>
                </div>
                <!-- nav toggle button -->
                <button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <!-- extra nav -->
                <div class="extra-nav">
                    <div class="extra-cell">
                        <a href="<?= Url::to('contact'); ?>" class="site-button align-self-center ml-auto button-style-2 primary">
                            <span>Get in Touch</span>
                            <i class="la la-long-arrow-alt-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Quik search -->
                <div class="dlab-quik-search ">
                    <form action="#">
                        <input name="search" value="" type="text" class="form-control" placeholder="Type to search">
                        <span id="quik-search-remove"><i class="ti-close"></i></span>
                    </form>
                </div>
                <!-- main nav -->
                <div class="header-nav navbar-collapse collapse justify-content-end onepage" id="navbarNavDropdown">
                    <div class="logo-header d-md-block d-lg-none">
                        <a href="index.html">
                            <?= \yii\helpers\Html::img('@web/images/logo.png', ['alt' => ""]); ?>
                        </a>
                    </div>
                    <ul class="nav navbar-nav navbar">
                        <li><a href="#home" class="scroll nav-link active">Home</a></li>
                        <li><a href="#about-us" class="scroll nav-link">About Us</a></li>
                        <li><a href="#services" class="scroll nav-link">Services</a></li>
                        <li><a href="#projects" class="scroll nav-link">Projects</a></li>
                        <li><a href="#team" class="scroll nav-link">Team</a></li>
                        <li><a href="#client" class="scroll nav-link">Client Says</a></li>
                        <li><a href="#blog" class="scroll nav-link">Blog</a></li>
                    </ul>
                    <div class="dlab-social-icon ind-social">
                        <ul>
                            <li><a class="site-button-link facebook fa fa-facebook" href="javascript:void(0);"></a></li>
                            <li><a class="site-button-link twitter fa fa-twitter" href="javascript:void(0);"></a></li>
                            <li><a class="site-button-link linkedin fa fa-linkedin" href="javascript:void(0);"></a></li>
                            <li><a class="site-button-link instagram fa fa-instagram" href="javascript:void(0);"></a></li>
                        </ul>
                        <p>2020 Tradezone</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main header END -->
</header>
<!-- header END -->