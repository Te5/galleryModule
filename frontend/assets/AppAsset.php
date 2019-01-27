<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/baguetteBox.css',
        'css/masonry.css',

        'css/gallery.css',
    ];
    public $js = [
        'js/baguetteBox.js',
        'js/masonry.pkgd.js',
        'js/infinite-scroll.pkgd.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',

    ];
}
