<?php

namespace andresbreads\coreui\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class SimplebarAsset extends AssetBundle
{
    public $sourcePath = '@vendor/npm-asset/simplebar/dist';
    public $css = [
        "css/simplebar.min.css",
    ];
    public $js = [
        "js/simplebar.min.js",
    ];
    public $depends = [
    ];
}