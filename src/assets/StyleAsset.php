<?php

namespace andresbreads\coreui\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class StyleAsset extends AssetBundle
{
    public $sourcePath = '@andresbreads/coreui/assets';
    public $css = [
        "css/style.min.css",
    ];
    public $js = [
    ];
    public $depends = [
        BaseAsset::class,
    ];
}