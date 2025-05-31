<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Lev Pro Construction';
?>

<!-- Content -->
<div class="page-content bg-white">
    <?= $this->render('slider'); ?>
    <!-- contact area -->
    <div class="content-block">
        <!-- Call To Action End -->
        <div class="section-full call-action bg-primary wow fadeIn" data-wow-duration="2s" data-wow-delay="0.2s" style="background-image:url(images/pattern/pt5.png);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 text-black">
                        <h2 class="title">Building today to inspire tomorrow </h2>
                        <p class="m-b0">Our projects are a combination of experience, innovation, and your vision.</p>
                    </div>
                    <div class="col-lg-3 d-flex">
                        <a href="<?= Url::to('contact'); ?>" class="site-button black align-self-center ml-auto button-style-2">
                            <span>Contact Us</span>
                            <i class="la la-long-arrow-alt-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Call To Action End -->

        <!-- About Us -->
            <?= $this->render('about-us'); ?>
        <!-- About Us End -->

        <!-- Services -->
            <?= $this->render('services'); ?>
        <!-- Services End -->
        <!-- Our Services -->
            <?php echo $this->render('our-services'); ?>
        <!-- Our Services END -->

        <?php //echo $this->render('team'); ?>

        <!-- Testimonial -->
        <?php echo $this->render('testimonial'); ?>
        <!-- Testimonial End -->

        <?php // $this->render('blog'); ?>

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
    <!-- contact area END -->
</div>
<!-- Content END -->