<?php

$this->title = ucwords(str_replace('-', ' ', $title));

$metaMap = [
    'painting' => [
        'description' => 'Browse LevPro Construction\'s painting projects. Professional interior and exterior painting in Kirkland, Bellevue, Redmond and greater Seattle area. Licensed & insured.',
        'keywords'    => 'painting projects Kirkland WA, exterior painting examples Seattle, interior painting gallery, house painting contractor Bellevue, painting portfolio Washington',
    ],
    'siding' => [
        'description' => 'Browse LevPro Construction\'s siding installation projects. Professional siding services in Kirkland, Bellevue, Redmond and greater Seattle area. Licensed & insured.',
        'keywords'    => 'siding installation Kirkland WA, siding projects gallery Seattle, siding contractor Bellevue, house siding examples Washington, vinyl siding Redmond',
    ],
];

$meta = $metaMap[$category] ?? [
    'description' => 'Browse LevPro Construction project gallery — professional painting and siding services in Kirkland, WA and greater Seattle area.',
    'keywords'    => 'LevPro Construction projects, painting siding gallery Kirkland WA',
];

$this->params['meta_description'] = $meta['description'];
$this->params['meta_keywords']    = $meta['keywords'];

use yii\helpers\Html;
use newerton\fancybox3\FancyBox;

$this->registerCss("
.project-gallery-block {
    margin-bottom: 30px;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 6px;
}

@media (min-width: 576px) {
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 10px;
    }
}

@media (min-width: 992px) {
    .gallery-grid {
        gap: 12px;
    }
}

.gallery-item {
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background: #f1f1f1;
    border-radius: 6px;
}

.gallery-item a {
    display: block;
    width: 100%;
    height: 100%;
}

.gallery-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

#load-more-wrapper {
    text-align: center;
    padding: 30px 0 50px;
}

#load-more-btn {
    min-width: 200px;
}

#load-more-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
");

?>
<div class="container bg-white" id="projects">
    <div style="width:100%;text-align:center;padding:40px 0 20px">
        <h5 class="title-small">GALLERY &amp; EXAMPLE</h5>
        <div class="dlab-separator-outer">
            <div class="dlab-separator bg-primary style-skew"></div>
        </div>
        <h2 class="font-weight-700 m-b0"><?= Html::encode($title) ?></h2>
    </div>
    <div class="row spno">
        <?= FancyBox::widget([
            'target' => '[data-fancybox="gallery"]',
            'config' => [
                'loop'             => true,
                'arrows'           => true,
                'infobar'          => true,
                'toolbar'          => true,
                'gutter'           => true,
                'buttons'          => ['slideShow', 'fullScreen', 'thumbs', 'close'],
                'animationEffect'  => 'zoom',
                'transitionEffect' => 'fade',
            ],
        ]) ?>

        <div id="projects-container" style="width:100%">
            <?php foreach ($projects as $project): ?>
                <div class="project-gallery-block">
                    <h3><?= Html::encode($project['name']) ?></h3>
                    <div class="gallery-grid">
                        <?php foreach ($project['images'] as $image): ?>
                            <div class="gallery-item">
                                <?= Html::a(
                                    Html::img($image, [
                                        'class'   => 'gallery-img',
                                        'alt'     => $project['name'],
                                        'loading' => 'lazy',
                                    ]),
                                    $image,
                                    [
                                        'data-fancybox' => 'project-' . $project['id'],
                                        'data-caption'  => $project['name'],
                                    ]
                                ) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <?php if ($loaded < $total): ?>
    <div id="load-more-wrapper">
        <button
            id="load-more-btn"
            class="site-button button-style-2 primary"
            data-offset="<?= $loaded ?>"
            data-total="<?= $total ?>"
            data-category="<?= Html::encode($category) ?>"
        >
            Завантажити ще
        </button>
    </div>
    <?php endif; ?>
</div>

<script>
(function () {
    var btn = document.getElementById('load-more-btn');
    if (!btn) return;

    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function buildProjectBlock(project) {
        var html = '<div class="project-gallery-block">'
            + '<h3>' + escHtml(project.name) + '</h3>'
            + '<div class="gallery-grid">';

        project.images.forEach(function (img) {
            html += '<div class="gallery-item">'
                + '<a href="' + img + '" data-fancybox="project-' + project.id
                + '" data-caption="' + escHtml(project.name) + '">'
                + '<img src="' + img + '" class="gallery-img" alt="' + escHtml(project.name) + '" loading="lazy">'
                + '</a></div>';
        });

        html += '</div></div>';
        return html;
    }

    btn.addEventListener('click', function () {
        var offset   = parseInt(btn.dataset.offset, 10);
        var total    = parseInt(btn.dataset.total, 10);
        var category = btn.dataset.category;

        btn.disabled    = true;
        btn.textContent = 'Завантаження…';

        fetch('/gallery/' + category + '/more?offset=' + offset)
            .then(function (r) { return r.json(); })
            .then(function (projects) {
                var container = document.getElementById('projects-container');

                projects.forEach(function (project) {
                    var div = document.createElement('div');
                    div.innerHTML = buildProjectBlock(project);
                    container.appendChild(div.firstChild);
                });

                var newOffset = offset + projects.length;
                btn.dataset.offset = newOffset;

                if (newOffset >= total || projects.length === 0) {
                    document.getElementById('load-more-wrapper').style.display = 'none';
                } else {
                    btn.disabled    = false;
                    btn.textContent = 'Завантажити ще';
                }
            })
            .catch(function () {
                btn.disabled    = false;
                btn.textContent = 'Завантажити ще';
            });
    });
}());
</script>
