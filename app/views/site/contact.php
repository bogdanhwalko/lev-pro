<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<header class="site-header mo-left construct-header header">
<!-- Content -->
<div class="page-content bg-white">
    <!-- inner page banner -->
    <div class="dlab-bnr-inr overlay-black-dark bg-pt contact-bnr" style="background-image:url(images/banner/bnr2.jpg);">
        <div class="container">
            <div class="dlab-bnr-inr-entry">
                <div class="title">
                    <h1 class="text-white">Contact Us</h1>
                    <p>Looking for a design partner<br/> You found</p>
                </div>
                <!-- Breadcrumb row -->
                <div class="breadcrumb-row">

                </div>
                <!-- Breadcrumb row END -->
            </div>
        </div>
    </div>
    <!-- inner page banner END -->
    <!-- Contact Form -->
    <div class="section-full bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 content-inner">
                    <div class="section-head m-b30">
                        <h5 class="title-small">Contact Us</h5>
                        <div class="dlab-separator-outer">
                            <div class="dlab-separator bg-primary style-skew"></div>
                        </div>
                        <h2 class="title">Do You Have Any Question?</h2>
                    </div>
                    <ul class="contact-question">
                        <li>
                            <i class="fa fa-map-marker"></i>
                            <h4 class="title">Address</h4>
                            <p>123 West Street, Melbourne Victoria 3000 Australia</p>
                        </li>
                        <li>
                            <i class="fa fa-envelope-o"></i>
                            <h4 class="title">Email</h4>
                            <p><?= Yii::$app->params['senderEmail']?></p>
                        </li>
                        <li>
                            <i class="fa fa-phone"></i>
                            <h4 class="title">Phone</h4>
                            <p><?= Yii::$app->params['phoneSupport']?></p>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-8 col-md-12 m-b30">
                    <form class="contact-box dzForm" action="script/contact.php">
                        <h3 class="title-box">Write us a few words about your project and we’ll prepare a proposal for you within <strong>24</strong> hours</h3>
                        <div class="dzFormMsg m-b20"></div>
                        <input type="hidden" value="Contact" name="dzToDo" >
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="dzFirstName" type="text" required class="form-control" placeholder="First Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="dzLastName" type="text" required class="form-control" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="dzOther[Phone]" type="text" required class="form-control" placeholder="Phone">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="dzEmail" type="email" class="form-control" required  placeholder="Your Email Id" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <textarea name="dzMessage" rows="4" class="form-control" required placeholder="Tell us about your project or idea"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="g-recaptcha" data-sitekey="<!-- Put reCaptcha Site Key -->" data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback"></div>
                                        <input class="form-control d-none" style="display:none;" data-recaptcha="true" required data-error="Please complete the Captcha">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <button name="submit" type="submit" value="Submit" class="site-button align-self-center ml-auto button-style-2 primary">
                                    <span>Get A Free Quote!</span>
                                    <i class="la la-long-arrow-alt-right"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="section-full bg-gray">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d227748.3825624477!2d75.65046970649679!3d26.88544791796718!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396c4adf4c57e281%3A0xce1c63a0cf22e09!2sJaipur%2C+Rajasthan!5e0!3m2!1sen!2sin!4v1500819483219" class="radius-sm" style="border:0; width:100%; vertical-align:middle; min-height:350px;" allowfullscreen></iframe>
    </div>
    <!-- Contact Form END -->
    <!-- Blog End -->
    <div class="section-full p-tb40 bg-primary construct-action" style="background-image: url(images/pattern/pt5.png);">
        <div class="container">
            <div class="row spno">
                <div class="col-sm-6 col-6">
                    <a href="#"><i class="las la-envelope-open"></i>Email: <?= Yii::$app->params['senderEmail']?></a>
                </div>
                <div class="col-sm-6 col-6 text-right">
                    <a href="#">Support: <?= Yii::$app->params['phoneSupport']?><i class="las la-phone-volume"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content END-->