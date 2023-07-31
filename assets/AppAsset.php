<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'web/css/site.css',
        'web/css/nucleo-icons.css',
        'web/css/black-dashboard.css?v=1.0.0',
        // 'css/black-dashboard.css',
        'web/css/black-dashboard.css.map',
        'web/css/black-dashboard.min.css',
        'https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800',
        'https://use.fontawesome.com/releases/v5.0.6/css/all.css',
    ];
    public $js = [
        'js/checkbox.js',
        'js/main.js',
        // 'js/core/jquery.min.js',
        'js/core/popper.min.js',
        'js/core/bootstrap.min.js',
        'js/plugins/perfect-scrollbar.jquery.min.js',
        'js/plugins/chartjs.min.js',
        'js/plugins/bootstrap-notify.js',
        'js/black-dashboard.min.js?v=1.0.0',
        'js/black-dashboard.js',
        // 'js/black-dashboard.js.map',
        // 'js/black-dashboard.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
