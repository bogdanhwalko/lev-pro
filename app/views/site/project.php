<?php
/** @var yii\web\View $this */
/** @var app\models\WorkProject $project */
/** @var app\models\WorkProjectPost[] $posts */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\web\View;
use newerton\fancybox3\FancyBox;

$this->title = $project->title;
$this->params['meta_description'] = $project->intro
    ? mb_substr(strip_tags($project->intro), 0, 160)
    : $project->title;

$commentUrl = Url::to(['/site/project-comment']);

// hero background: uploaded cover → first post photo → gradient fallback
$heroImg = $project->getCoverImage();
if (!$heroImg) {
    foreach ($posts as $p) {
        $imgs = $p->getImages();
        if (!empty($imgs)) {
            $heroImg = $p->getImageUrl(basename($imgs[0]));
            break;
        }
    }
}
$lastUpdate = !empty($posts) ? end($posts)->created_at : $project->created_at;

$initial = function (string $name): string {
    $name = trim($name);
    return $name === '' ? '?' : mb_strtoupper(mb_substr($name, 0, 1));
};

$this->registerCss(<<<CSS
.wp-page { font-family: 'Poppins', sans-serif; background: #f6f7f9; }

/* ---- Hero ---- */
.wp-hero {
    position: relative;
    padding: 130px 0 70px;
    color: #fff;
    text-align: center;
    background: #1a1a1a center/cover no-repeat;
}
.wp-hero::before {
    content: ""; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(0,0,0,.82) 0%, rgba(0,0,0,.6) 55%, rgba(255,186,0,.25) 100%);
}
.wp-hero > .container { position: relative; z-index: 1; }
.wp-hero-box {
    display: inline-block;
    max-width: 820px;
    background: rgba(10,10,10,.62);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 18px;
    padding: 34px 48px;
    box-shadow: 0 20px 60px rgba(0,0,0,.4);
}
@media (max-width: 575px) { .wp-hero-box { padding: 22px 20px; } }
.wp-hero .wp-eyebrow {
    display: inline-flex; align-items: center; gap: 7px;
    background: #ffba00; color: #1a1a1a;
    font-weight: 700; font-size: 11.5px; letter-spacing: 1.6px; text-transform: uppercase;
    padding: 7px 16px; border-radius: 50px; margin-bottom: 20px;
}
.wp-hero h1 {
    display: block; color: #fff !important; font-weight: 800; font-size: 2.9rem;
    margin: 0 auto 16px; line-height: 1.12; letter-spacing: -.5px;
    text-shadow: 0 2px 22px rgba(0,0,0,.55);
}
.wp-hero h1::after {
    content: ""; display: block; width: 64px; height: 4px; border-radius: 3px;
    background: #ffba00; margin: 18px auto 0;
}
.wp-hero .wp-intro { color: #dcdcdc; max-width: 640px; margin: 0 auto 22px; font-size: 1.02rem; line-height: 1.6; }
.wp-hero .wp-meta { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; }
.wp-hero .wp-meta span {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14);
    color: #eaeaea; font-size: 12.5px; font-weight: 500;
    padding: 6px 14px; border-radius: 50px;
}
.wp-hero .wp-meta i { color: #ffba00; }
@media (max-width: 575px) { .wp-hero { padding: 110px 0 50px; } .wp-hero h1 { font-size: 2.1rem; } }

/* ---- Timeline ---- */
.wp-timeline { max-width: 860px; margin: 0 auto; padding: 60px 16px 30px; position: relative; }
.wp-timeline::before {
    content: ""; position: absolute; left: 30px; top: 12px; bottom: 12px;
    width: 3px; background: linear-gradient(#ffba00, #ececec);
}
.wp-entry { position: relative; padding-left: 76px; margin-bottom: 42px; }
.wp-marker {
    position: absolute; left: 18px; top: 4px;
    width: 28px; height: 28px; border-radius: 50%;
    background: #fff; border: 3px solid #ffba00;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 0 0 5px rgba(255,186,0,.15);
}
.wp-marker i { color: #ffba00; font-size: 12px; }
.wp-date {
    display: inline-block; background: #1a1a1a; color: #fff;
    font-size: 12px; font-weight: 600; letter-spacing: .4px;
    padding: 4px 12px; border-radius: 20px; margin-bottom: 12px;
}
.wp-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 8px 30px rgba(0,0,0,.06);
    padding: 24px; transition: transform .2s ease, box-shadow .2s ease;
}
.wp-card:hover { transform: translateY(-3px); box-shadow: 0 14px 38px rgba(0,0,0,.1); }
.wp-text { line-height: 1.7; margin: 0 0 16px; color: #333; font-size: 1rem; }
.wp-text > :first-child { margin-top: 0; }
.wp-text > :last-child { margin-bottom: 0; }
.wp-text p { margin: 0 0 10px; }
.wp-text ul, .wp-text ol { margin: 0 0 10px; padding-left: 22px; }
.wp-text a { color: #c79100; text-decoration: underline; }
.wp-text blockquote { border-left: 3px solid #ffba00; margin: 0 0 10px; padding: 4px 14px; color: #555; background: #fafafa; }
.wp-text h2, .wp-text h3, .wp-text h4 { margin: 14px 0 8px; font-weight: 700; }

.wp-photos {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 8px;
}
.wp-photos.single { grid-template-columns: 1fr; }
.wp-photo { aspect-ratio: 4/3; overflow: hidden; border-radius: 10px; background: #eee; display: block; }
.wp-photos.single .wp-photo { aspect-ratio: 16/9; }
.wp-photo img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .35s ease; }
.wp-photo:hover img { transform: scale(1.06); }

/* ---- Comments ---- */
.wp-comments { margin-top: 20px; border-top: 1px solid #f0f0f0; padding-top: 18px; }
.wp-comments-title { font-size: 13px; font-weight: 700; color: #666; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 14px; }
.wp-comments-title i { color: #ffba00; }
.wp-comment { display: flex; gap: 12px; margin-bottom: 14px; }
.wp-avatar {
    flex-shrink: 0; width: 38px; height: 38px; border-radius: 50%;
    background: #ffba00; color: #1a1a1a; font-weight: 700; font-size: 15px;
    display: flex; align-items: center; justify-content: center;
}
.wp-bubble { background: #f6f8fa; border-radius: 10px; padding: 10px 14px; flex: 1; min-width: 0; }
.wp-bubble .who { font-size: 13.5px; font-weight: 600; color: #222; }
.wp-bubble .who span { color: #9a9a9a; font-weight: 400; font-size: 12px; margin-left: 6px; }
.wp-bubble .txt { font-size: 14px; white-space: pre-wrap; color: #444; margin-top: 3px; line-height: 1.55; }

/* admin reply */
.wp-reply { margin-top: 10px; border-left: 3px solid #ffba00; background: #fffaf0; border-radius: 0 8px 8px 0; padding: 8px 12px; }
.wp-reply-head { font-size: 12.5px; font-weight: 700; color: #1a1a1a; }
.wp-reply-head i { color: #1a8a3a; margin-right: 4px; }
.wp-reply-head span { color: #b0a070; font-weight: 400; margin-left: 6px; }
.wp-reply-txt { font-size: 13.5px; white-space: pre-wrap; color: #4a4435; margin-top: 2px; line-height: 1.5; }

/* click-to-show comment form */
.wp-add-comment {
    background: none; border: 1px dashed #c9ad55; color: #8a6d00;
    font-weight: 600; font-size: 13px; padding: 8px 16px; border-radius: 8px; cursor: pointer;
}
.wp-add-comment:hover { background: #fff7e0; }
.wp-form[hidden] { display: none; }

/* ---- Comment form ---- */
.wp-form { margin-top: 16px; background: #fbfbfc; border: 1px solid #eee; border-radius: 12px; padding: 16px; }
.wp-form .ttl { font-size: 13px; font-weight: 700; color: #555; margin-bottom: 10px; }
.wp-form input[type=text], .wp-form textarea {
    width: 100%; border: 1px solid #d8d8d8; border-radius: 8px;
    padding: 10px 13px; font-size: 14px; outline: none; font-family: inherit;
    transition: border-color .15s ease;
}
.wp-form input[type=text] { max-width: 280px; margin-bottom: 8px; }
.wp-form textarea { resize: vertical; min-height: 48px; }
.wp-form input:focus, .wp-form textarea:focus { border-color: #ffba00; box-shadow: 0 0 0 3px rgba(255,186,0,.15); }
.wp-form .hp { position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden; }
.wp-form .actions { display: flex; align-items: center; gap: 14px; margin-top: 10px; }
.wp-form button {
    border: none; background: #ffba00; color: #1a1a1a;
    font-weight: 700; padding: 10px 22px; border-radius: 8px; cursor: pointer;
    transition: background .2s ease;
}
.wp-form button:hover { background: #ffc733; }
.wp-form button:disabled { opacity: .6; cursor: default; }
.wp-form .status { font-size: 13px; }
.wp-form .status.err { color: #d33; }
.wp-form .status.ok { color: #1a8a3a; }

.wp-empty { text-align: center; color: #999; padding: 50px 20px; }

@media (max-width: 575px) {
    .wp-timeline::before { left: 18px; }
    .wp-entry { padding-left: 52px; }
    .wp-marker { left: 6px; }
    .wp-card { padding: 18px; }
}
CSS);

$js = <<<JS
(function () {
    var url = '{$commentUrl}';
    var csrfParam = document.querySelector('meta[name="csrf-param"]');
    var csrfToken = document.querySelector('meta[name="csrf-token"]');

    function initial(n) { n = (n || '').trim(); return n ? n.charAt(0).toUpperCase() : '?'; }

    function makeComment(c) {
        var row = document.createElement('div');
        row.className = 'wp-comment';
        var av = document.createElement('div');
        av.className = 'wp-avatar'; av.textContent = initial(c.author_name);
        var bub = document.createElement('div');
        bub.className = 'wp-bubble';
        var who = document.createElement('div'); who.className = 'who';
        who.textContent = c.author_name + ' ';
        var sp = document.createElement('span'); sp.textContent = c.date; who.appendChild(sp);
        var txt = document.createElement('div'); txt.className = 'txt'; txt.textContent = c.body;
        bub.appendChild(who); bub.appendChild(txt);
        row.appendChild(av); row.appendChild(bub);
        return row;
    }

    document.querySelectorAll('.wp-add-comment').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var form = btn.nextElementSibling;
            if (form && form.classList.contains('wp-form')) {
                form.hidden = false;
                btn.style.display = 'none';
                var nameInput = form.querySelector('input[name="author_name"]');
                if (nameInput) nameInput.focus();
            }
        });
    });

    document.querySelectorAll('.wp-form').forEach(function (form) {
        var statusEl = form.querySelector('.status');
        var btn = form.querySelector('button');
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            statusEl.textContent = ''; statusEl.className = 'status';

            var data = new FormData(form);
            if (csrfParam && csrfToken) {
                data.append(csrfParam.getAttribute('content'), csrfToken.getAttribute('content'));
            }
            btn.disabled = true;

            fetch(url, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: data })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (res.success) {
                        if (res.comment) {
                            form.closest('.wp-comments').querySelector('.wp-list').appendChild(makeComment(res.comment));
                        }
                        form.reset();
                        statusEl.textContent = 'Thanks for your comment!';
                        statusEl.className = 'status ok';
                    } else if (res.errors) {
                        var first = Object.keys(res.errors)[0];
                        statusEl.textContent = res.errors[first];
                        statusEl.className = 'status err';
                    } else {
                        statusEl.textContent = res.message || 'Something went wrong.';
                        statusEl.className = 'status err';
                    }
                })
                .catch(function () {
                    statusEl.textContent = 'Network error. Please try again.';
                    statusEl.className = 'status err';
                })
                .finally(function () { btn.disabled = false; });
        });
    });
})();
JS;
$this->registerJs($js, View::POS_END);
?>

<div class="page-content bg-white wp-page">

    <?= FancyBox::widget([
        'target' => '[data-fancybox]',
        'config' => [
            'loop'             => true,
            'arrows'           => true,
            'infobar'          => true,
            'buttons'          => ['slideShow', 'fullScreen', 'thumbs', 'close'],
            'animationEffect'  => 'zoom',
            'transitionEffect' => 'fade',
        ],
    ]) ?>

    <!-- Hero -->
    <div class="wp-hero" <?= $heroImg ? 'style="background-image:url(' . Html::encode($heroImg) . ')"' : '' ?>>
        <div class="container">
            <div class="wp-hero-box">
                <span class="wp-eyebrow"><i class="fa fa-briefcase"></i> Project</span>
                <h1><?= Html::encode($project->title) ?></h1>
                <?php if ($project->intro): ?>
                    <p class="wp-intro"><?= nl2br(Html::encode($project->intro)) ?></p>
                <?php endif; ?>
                <div class="wp-meta">
                    <span><i class="fa fa-clock-o"></i> Updated <?= date('M j, Y · H:i', $lastUpdate) ?></span>
                    <span><i class="fa fa-list-ul"></i> <?= count($posts) ?> update<?= count($posts) === 1 ? '' : 's' ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="wp-timeline">
        <?php if (empty($posts)): ?>
            <div class="wp-empty">
                <i class="fa fa-clock-o" style="font-size:42px;color:#ffba00;display:block;margin-bottom:14px"></i>
                No updates yet — check back soon!
            </div>
        <?php endif; ?>

        <?php foreach ($posts as $post): ?>
            <?php $images = $post->getImages(); ?>
            <div class="wp-entry" id="post-<?= $post->id ?>">
                <span class="wp-marker"><i class="fa fa-<?= !empty($images) ? 'camera' : 'pencil' ?>"></i></span>
                <div class="wp-date"><?= date('F j, Y · H:i', $post->created_at) ?></div>
                <div class="wp-card">
                    <?php if ($post->body): ?>
                        <div class="wp-text"><?= HtmlPurifier::process($post->body) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($images)): ?>
                        <div class="wp-photos<?= count($images) === 1 ? ' single' : '' ?>">
                            <?php foreach ($images as $imagePath): ?>
                                <?php $u = $post->getImageUrl(basename($imagePath)); ?>
                                <a class="wp-photo" href="<?= Html::encode($u) ?>"
                                   data-fancybox="wp-post-<?= $post->id ?>"
                                   data-caption="<?= Html::encode($project->title) ?>">
                                    <img src="<?= Html::encode($u) ?>" alt="<?= Html::encode($project->title) ?>" loading="lazy">
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Comments -->
                    <div class="wp-comments">
                        <div class="wp-comments-title">
                            <i class="fa fa-comments-o"></i> Comments (<?= count($post->comments) ?>)
                        </div>
                        <div class="wp-list">
                            <?php foreach ($post->comments as $comment): ?>
                                <div class="wp-comment">
                                    <div class="wp-avatar"><?= Html::encode($initial($comment->author_name)) ?></div>
                                    <div class="wp-bubble">
                                        <div class="who">
                                            <?= Html::encode($comment->author_name) ?>
                                            <span><?= date('d.m.Y H:i', $comment->created_at) ?></span>
                                        </div>
                                        <div class="txt"><?= Html::encode($comment->body) ?></div>
                                        <?php if (!empty($comment->admin_reply)): ?>
                                            <div class="wp-reply">
                                                <div class="wp-reply-head">
                                                    <i class="fa fa-check-circle"></i> LevPro Construction
                                                    <?php if ($comment->admin_reply_at): ?>
                                                        <span><?= date('d.m.Y H:i', $comment->admin_reply_at) ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="wp-reply-txt"><?= Html::encode($comment->admin_reply) ?></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($project->comments_enabled): ?>
                            <button type="button" class="wp-add-comment">
                                <i class="fa fa-comment-o"></i> Leave a comment
                            </button>
                            <form class="wp-form" hidden>
                                <div class="ttl">Leave a comment</div>
                                <input type="hidden" name="post_id" value="<?= $post->id ?>">
                                <div class="hp">
                                    <label>Leave this empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                                </div>
                                <input type="text" name="author_name" placeholder="Your name" value="Customer" maxlength="120" required>
                                <textarea name="body" placeholder="Write a comment…" maxlength="2000" rows="2" required></textarea>
                                <div class="actions">
                                    <button type="submit">Post comment</button>
                                    <div class="status"></div>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
