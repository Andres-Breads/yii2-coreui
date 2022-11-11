<?php

/** @var \yii\web\View $this */
/** @var string $content */

use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use andresbreads\coreui\widgets\Menu;
use andresbreads\coreui\widgets\Dropdown;
use andresbreads\coreui\assets\CoreUiAsset;

CoreUiAsset::register($this);

$this->params['mainMenu'] = $this->params['mainMenu'] ?? [
    [
        'label' => 'Starter Pages',
        'icon' => 'tachometer-alt',
        'badge' => '<span class="badge bg-info ms-auto">2</span>',
        'items' => [
            ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
            ['label' => 'Inactive Page', 'iconStyle' => 'far'],
        ]
    ],
    ['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="badge bg-danger ms-auto">New</span>'],
    ['label' => 'Yii2 PROVIDED', 'header' => true],
    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
    ['label' => 'MULTI LEVEL EXAMPLE', 'header' => true],
    ['label' => 'Level1'],
    [
        'label' => 'Level1',
        'items' => [
            ['label' => 'Level2', 'iconStyle' => 'far'],
            [
                'label' => 'Level2',
                'iconStyle' => 'far',
                'items' => [
                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
                ]
            ],
            ['label' => 'Level2', 'iconStyle' => 'far']
        ]
    ],
    ['label' => 'Level1'],
    ['label' => 'LABELS', 'header' => true],
    ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
    ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
    ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
];

$this->params['topLeftMenu'] = $this->params['topLeftMenu'] ?? [
    ['label' => '<i class="fas fa-home"></i>', 'encode' => false, 'url' => Yii::$app->homeUrl],
];

$this->params['topRightMenu'] = $this->params['topRightMenu'] ?? [
    ['label' => '<i class="fas fa-bell"></i>', 'encode' => false, 'url' => Yii::$app->homeUrl],
    ['label' => '<i class="fas fa-list"></i>', 'encode' => false, 'url' => Yii::$app->homeUrl],
    ['label' => '<i class="fas fa-envelope-open"></i>', 'encode' => false, 'url' => Yii::$app->homeUrl],
];

list(,$url) = Yii::$app->assetManager->publish('@andresbreads/coreui/assets');
$this->params['userThumbnail'] = $this->params['userThumbnail'] ?? $url.'/img/avatars/8.jpg';

$this->params['userMenu'] = $this->params['userMenu'] ?? [
    ['label' => Yii::t('app', 'Account')],
    [
        'label' => '<i class="fas fa-bell me-2"></i>' . Yii::t('app', 'Updates') . '<span class="badge badge-sm bg-info ms-2">42</span>',
        'url' => Yii::$app->homeUrl,
        'encode' => false
    ],
    [
        'label' => '<i class="fas fa-envelope-open me-2"></i>' . Yii::t('app', 'Messages') . '<span class="badge badge-sm bg-success ms-2">42</span>',
        'url' => Yii::$app->homeUrl,
        'encode' => false
    ],
    [
        'label' => '<i class="fas fa-tasks me-2"></i></i>' . Yii::t('app', 'Tasks') . '<span class="badge badge-sm bg-danger ms-2">42</span>',
        'url' => Yii::$app->homeUrl,
        'encode' => false
    ],
    [
        'label' => '<i class="far fa-comment me-2"></i>' . Yii::t('app', 'Comments') . '<span class="badge badge-sm bg-warning ms-2">42</span>',
        'url' => Yii::$app->homeUrl,
        'encode' => false
    ],
    ['label' => Yii::t('app', 'Settings')],
    [
        'label' => '<i class="far fa-user me-2"></i>' . Yii::t('app', 'Profile'),
        'url' => Yii::$app->homeUrl,
        'encode' => false
    ],
    [
        'label' => '<i class="fas fa-cog me-2"></i>' . Yii::t('app', 'Settings'),
        'url' => Yii::$app->homeUrl,
        'encode' => false
    ],
    [
        'label' => '<i class="far fa-credit-card me-2"></i>' . Yii::t('app', 'Payments') . '<span class="badge badge-sm bg-secondary ms-2">42</span>',
        'url' => Yii::$app->homeUrl,
        'encode' => false
    ],
    [
        'label' => '<i class="far fa-file me-2"></i>' . Yii::t('app', 'Projects') . '<span class="badge badge-sm bg-primary ms-2">42</span>',
        'url' => Yii::$app->homeUrl,
        'encode' => false
    ],
    '-',
    'logout',
];

$this->params['leftFooter'] = $this->params['leftFooter'] ?? "&copy; " . Html::encode(Yii::$app->name) . " " . date('Y');
$this->params['rightFooter'] = $this->params['rightFooter'] ?? Yii::powered();
?>

<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <a href="<?= Yii::$app->homeUrl ?>" class="sidebar-brand d-none d-md-flex">
        <img src="/images/logo.png" class="sidebar-brand-full rounded-circle" height="113" alt="<?= Yii::$app->name ?>">
        <img src="/images/logo.png" class="sidebar-brand-narrow rounded-circle" height="64" alt="<?= Yii::$app->name ?>">
    </a>
    <?= Menu::widget([
        'items' => $this->params['mainMenu'],
    ]) ?>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <header class="header header-sticky mb-4">
        <div class="container-fluid">
            <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                <i class="fas fa-bars"></i>
            </button>
            <a class="header-brand d-md-none" href="<?= Yii::$app->homeUrl ?>">
                <img src="/images/logo.png" width="46" alt="<?= Yii::$app->name ?>">
            </a>
            <?= Nav::widget([
                'options' => ['class' => 'header-nav d-none d-md-flex'],
                'items' => $this->params['topLeftMenu'],
            ]) ?>

            <?= Nav::widget([
                'options' => ['class' => 'header-nav ms-auto'],
                'items' => $this->params['topRightMenu'],
            ]) ?>

            <ul class="header-nav ms-3">
                <li class="nav-item dropdown">
                    <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-md">
                            <img class="avatar-img" src="<?= $this->params['userThumbnail'] ?>" alt="<?= Yii::$app->user->identity->username ?>">
                        </div>
                    </a>
                    <?= Dropdown::widget([
                        'items' => $this->params['userMenu'],
                    ]) ?>
                </li>
            </ul>
        </div>
        <?php if (isset($this->params['breadcrumbs'])): ?>
            <div class="header-divider"></div>
            <div class="container-fluid">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => ['class' => 'my-0 ms-2']
                ]) ?>
            </div>
        <?php endif ?>
    </header>

    <main role="main" class="body flex-grow-1 px-3">
        <div class="container-lg">
            <?= $content ?>
        </div>
    </main>

    <footer class="footer">
        <div><?= $this->params['leftFooter'] ?></div>
        <div class="ms-auto"><?= $this->params['rightFooter'] ?></div>
    </footer>
</div>