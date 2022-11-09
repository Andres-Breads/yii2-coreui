<?php

namespace andresbreads\coreui\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class CoreUiAsset extends AssetBundle
{
    public $sourcePath = '@vendor/coreui/coreui/dist';
    public $css = [
        "css/coreui.min.css",
    ];
    public $js = [
        "js/coreui.bundle.min.js",
    ];
    public $depends = [
        BaseAsset::class,
        SimplebarAsset::class,
        StyleAsset::class,
    ];
}