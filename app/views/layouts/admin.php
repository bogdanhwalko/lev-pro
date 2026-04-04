<?php
/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\BootstrapPluginAsset;

// Publish Bootstrap 5 from vendor via Yii asset manager
BootstrapAsset::register($this);
BootstrapPluginAsset::register($this);

// Font Awesome 4 — fonts path matches local file structure
$this->registerCssFile('/plugins/fontawesome/css/font-awesome.min.css');

$this->registerCsrfMetaTags();
$actionId = Yii::$app->controller->action->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title ?? 'Admin') ?> — Admin</title>
    <?php $this->head() ?>
    <style>
        :root { --sidebar-w: 240px; --sidebar-bg: #1e2a3a; --topbar-h: 56px; }
        * { box-sizing: border-box; }
        body { background: #f4f6f9; margin: 0; font-family: system-ui, -apple-system, sans-serif; }

        /* ── Sidebar ─────────────────────────────── */
        .admin-sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            color: #c8d0db;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 200;
            transform: translateX(0);
            transition: transform .25s ease;
            overflow-y: auto;
        }
        .admin-sidebar .brand {
            padding: 0 20px;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            gap: 10px;
            height: var(--topbar-h);
            flex-shrink: 0;
        }
        .admin-sidebar .nav-link {
            color: #c8d0db;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .9rem;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: background .15s, color .15s;
            white-space: nowrap;
        }
        .admin-sidebar .nav-link:hover { background: rgba(255,255,255,.06); color: #fff; }
        .admin-sidebar .nav-link.active { background: rgba(255,255,255,.1); color: #fff; border-left-color: #4e8ef7; }
        .admin-sidebar .nav-link .fa { width: 16px; text-align: center; flex-shrink: 0; }
        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,.1);
            padding: 8px 0;
        }
        .sidebar-footer .nav-link { font-size: .85rem; }

        /* ── Overlay ─────────────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 199;
        }
        .sidebar-overlay.show { display: block; }

        /* ── Main area ───────────────────────────── */
        .admin-wrap { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .admin-topbar {
            background: #fff;
            border-bottom: 1px solid #e3e8ef;
            height: var(--topbar-h);
            display: flex; align-items: center;
            padding: 0 20px;
            position: sticky; top: 0; z-index: 100;
            gap: 12px;
        }
        .topbar-toggle {
            display: none; background: none; border: none;
            padding: 8px; cursor: pointer; color: #555;
            border-radius: 6px; line-height: 1;
        }
        .topbar-toggle:hover { background: #f0f0f0; }
        .topbar-title { flex: 1; font-weight: 600; color: #444; font-size: .95rem; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
        .topbar-user { font-size: .8rem; color: #888; white-space: nowrap; display: flex; align-items: center; gap: 6px; }
        .admin-content { padding: 20px; flex: 1; }

        /* ── Cards ───────────────────────────────── */
        .card { border: none !important; box-shadow: 0 1px 6px rgba(0,0,0,.07); border-radius: 10px; }
        .card-header { background: #fff !important; border-bottom: 1px solid #f0f0f0 !important; border-radius: 10px 10px 0 0 !important; font-size: .9rem; padding: 12px 16px; }

        /* ── Photo grid ──────────────────────────── */
        .photo-card { position: relative; }
        .photo-thumb { width: 120px; height: 90px; object-fit: cover; border-radius: 8px; display: block; }
        .del-btn {
            position: absolute; top: 4px; right: 4px;
            width: 28px; height: 28px;
            background: rgba(220,53,69,.9); border: none; border-radius: 50%;
            color: #fff; font-size: .65rem;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; opacity: 0; transition: opacity .15s;
        }
        .photo-card:hover .del-btn,
        .photo-card:focus-within .del-btn { opacity: 1; }

        /* ── Mobile ──────────────────────────────── */
        @media (max-width: 991px) {
            .admin-sidebar { transform: translateX(calc(-1 * var(--sidebar-w))); }
            .admin-sidebar.open { transform: translateX(0); }
            .admin-wrap { margin-left: 0; }
            .topbar-toggle { display: flex; align-items: center; }
            .admin-content { padding: 14px; }
            .del-btn { opacity: 1; }
            .photo-thumb { width: 100px; height: 75px; }
        }
        @media (max-width: 575px) {
            .admin-content { padding: 10px; }
            .topbar-title { font-size: .85rem; }
        }

        /* ── Project layout ──────────────────────── */
        .project-table-wrap { display: block; }
        .project-card-mobile { display: none; }
        @media (max-width: 767px) {
            .project-table-wrap { display: none; }
            .project-card-mobile { display: block; }
        }

        /* ── Touch-friendly buttons ──────────────── */
        @media (max-width: 991px) {
            .btn { min-height: 40px; }
            .btn-sm { min-height: 36px; }
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<nav class="admin-sidebar" id="adminSidebar">
    <div class="brand">
        <i class="fa fa-th"></i>
        <span>LevPro Admin</span>
    </div>

    <ul class="nav flex-column mt-1" style="padding:8px 0">
        <li>
            <a class="nav-link <?= $actionId === 'index' ? 'active' : '' ?>"
               href="<?= Url::to(['/admin/index']) ?>">
                <i class="fa fa-folder-open"></i> Проекти
            </a>
        </li>
        <li>
            <a class="nav-link <?= $actionId === 'create' ? 'active' : '' ?>"
               href="<?= Url::to(['/admin/create']) ?>">
                <i class="fa fa-plus-circle"></i> Новий проект
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a class="nav-link" href="<?= Url::to(['/']) ?>" style="color:#f0ad4e">
            <i class="fa fa-globe"></i> На сайт
        </a>
        <?= Html::beginForm(['/site/logout'], 'post', ['style' => 'margin:0']) ?>
        <?= Html::submitButton(
            '<i class="fa fa-sign-out"></i> Вийти',
            ['class' => 'nav-link btn btn-link w-100 text-start text-danger', 'style' => 'text-decoration:none', 'encode' => false]
        ) ?>
        <?= Html::endForm() ?>
    </div>
</nav>

<div class="admin-wrap">
    <div class="admin-topbar">
        <button class="topbar-toggle" onclick="toggleSidebar()" aria-label="Меню">
            <i class="fa fa-bars fa-lg"></i>
        </button>
        <span class="topbar-title"><?= Html::encode($this->title ?? '') ?></span>
        <span class="topbar-user">
            <i class="fa fa-user-circle-o"></i>
            <?= Html::encode(Yii::$app->user->identity->username ?? '') ?>
        </span>
    </div>

    <div class="admin-content">
        <?php foreach (['success', 'error', 'warning'] as $type): ?>
            <?php if (Yii::$app->session->hasFlash($type)): ?>
                <div class="alert alert-<?= $type === 'error' ? 'danger' : $type ?> alert-dismissible fade show" role="alert">
                    <?= Html::encode(Yii::$app->session->getFlash($type)) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <?= $content ?>
    </div>
</div>

<script>
function toggleSidebar() {
    const s = document.getElementById('adminSidebar');
    const o = document.getElementById('sidebarOverlay');
    const open = s.classList.toggle('open');
    o.classList.toggle('show', open);
    document.body.style.overflow = open ? 'hidden' : '';
}
function closeSidebar() {
    document.getElementById('adminSidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
