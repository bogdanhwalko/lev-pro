<?php
use yii\helpers\Url;
?>

<div class="section-full content-inner-1 services-box-area bg-gray" id="services" style="background-color: #d1d1d1;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 section-head text-white text-center">
                <h5 class="title-small">WHAT WE DO FOR YOU</h5>
                <div class="dlab-separator-outer">
                    <div class="dlab-separator bg-primary style-skew"></div>
                </div>
                <h2 class="title">OUR SERVICES</h2>
            </div>
        </div>
        <div class="row m-lr0">

            <div class="col-lg-6 col-md-6 p-lr0">
                <div class="icon-bx-wraper services-box">
                    <div class="icon-content">
                        <div class="m-b30 icon-cell icon-up">
                            <img src="<?= Yii::getAlias('@images/users/our-services/painting.jpg') ?>" alt="Painting" class="img-thumbnail"/>
                        </div>
                        <h3 class="dlab-tilte">Painting</h3>
                        <p>The service painting covers a wide range of works related to preparation, selection of materials and application of paints</p>
                    </div>
                    <a href="<?= Url::to(['gallery/painting']); ?>" class="site-button white align-self-center ml-auto half-btn">
                        <span>Work Examples</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 p-lr0">
                <div class="icon-bx-wraper services-box">
                    <div class="icon-content">
                        <div class="m-b30 icon-cell icon-up">
                            <img src="<?= Yii::getAlias('@images/users/our-services/siding.jpg') ?>" alt="Siding" class="img-thumbnail"/>
                        </div>
                        <h3 class="dlab-tilte">Siding</h3>
                        <p>This is a great way to enhance the appearance of your home, improve its protective qualities, and increase energy efficiency</p>
                        <a href="<?= Url::to(['gallery/siding']); ?>" class="site-button white align-self-center ml-auto half-btn">
                            <span>Work Examples</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>