<?php
use yii\helpers\Url;
?>

<section class="hero-section" id="home">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container">
            <div class="hero-inner">
                <p class="hero-tagline">Licensed & Insured · Kirkland, WA</p>
                <h1 class="hero-title">Your Dream<br><span>Is Our Work</span></h1>
                <p class="hero-subtitle">Professional painting & siding contractor</p>
                <div class="hero-actions">
                    <a href="<?= Url::to('/contact') ?>" class="site-button primary button-style-2">
                        <span>Get Free Estimate</span>
                        <i class="la la-long-arrow-alt-right"></i>
                    </a>
                    <a href="/#projects" class="hero-link-secondary">
                        <i class="la la-images"></i> View Our Work
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <strong>100+</strong>
                        <span>Projects Done</span>
                    </div>
                    <div class="hero-stat">
                        <strong>5★</strong>
                        <span>Rated Service</span>
                    </div>
                    <div class="hero-stat">
                        <strong>Free</strong>
                        <span>Estimate</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-scroll-hint">
        <a href="/#about-us"><i class="fa fa-chevron-down"></i></a>
    </div>
</section>
