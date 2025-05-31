<?php
use yii\helpers\Url;
?>

<div class="section-full content-inner-1 services-box-area bg-white" id="services" style="background-image: url(images/background/construct/bg1.jpg); background-position: top center; background-size: cover; background-repeat: no-repeat;">
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
            <div class="col-lg-3 col-md-3 p-lr0">
                <div class="icon-bx-wraper services-box">
                    <div class="icon-content">
                        <div class="icon-lg m-b30">
                            <a href="#" class="icon-cell icon-up"><img src="<?= Yii::getAlias('@images/icon/construct/pressure-washer2.png'); ?>" alt=""/></a>
                        </div>
                        <h3 class="dlab-tilte">Pressure Washing</h3>
                        <p>The pressure washing service ensures deep cleaning of surfaces by removing dirt, mold, mildew, and other contaminants.</p>
                        <a href="<?= Url::to(['gallery/pressure-washing']); ?>" class="site-button white align-self-center ml-auto half-btn">
                            <span>Work Examples</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 p-lr0">
                <div class="icon-bx-wraper services-box">
                    <div class="icon-content">
                        <div class="icon-lg m-b30">
                            <a href="#" class="icon-cell icon-up"><img src="<?= Yii::getAlias('@images/icon/construct/painting2.png'); ?>" alt=""/></a>
                        </div>
                        <h3 class="dlab-tilte">Painting</h3>
                        <p>The service painting covers a wide range of works related to preparation, selection of materials and application of paints</p>
                    </div>
                    <a href="<?= Url::to(['gallery/painting']); ?>" class="site-button white align-self-center ml-auto half-btn">
                        <span>Work Examples</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 p-lr0">
                <div class="icon-bx-wraper services-box">
                    <div class="icon-content">
                        <div class="icon-lg m-b30">
                            <a href="#" class="icon-cell icon-up"><img src="<?= Yii::getAlias('@images/icon/construct/siding.png'); ?>" alt=""/></a>
                        </div>
                        <h3 class="dlab-tilte">Siding</h3>
                        <p>This is a great way to enhance the appearance of your home, improve its protective qualities, and increase energy efficiency</p>
                        <a href="<?= Url::to(['gallery/siding']); ?>" class="site-button white align-self-center ml-auto half-btn">
                            <span>Work Examples</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 p-lr0">
                <div class="icon-bx-wraper services-box">
                    <div class="icon-content">
                        <div class="icon-lg m-b30">
                            <a href="#" class="icon-cell icon-up"><img src="<?= Yii::getAlias('@images/icon/construct/gutters2.png'); ?>" alt=""/></a>
                        </div>
                        <h3 class="dlab-tilte">Gutters</h3>
                        <p>Regular cleaning and maintenance help protect your home from leaks, water damage, and foundation issues</p>
                        <a href="<?= Url::to(['gallery/gutters']); ?>" class="site-button white align-self-center ml-auto half-btn">
                            <span>Work Examples</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>