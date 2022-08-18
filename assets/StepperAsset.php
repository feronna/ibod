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
class StepperAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/stepper-custom.min.css',
        'css/stepper-nprogress.css',
//        'css/stepper-font-awesome.min.css',
//        'css/stepper-bootstrap.min.css'
    ];
    public $js = [
        'js/custom_stepper.min.js',
        'js/fastclick_stepper.js',
        'js/nprogress_stepper.js',
        'js/jquery_stepper.smartWizard.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
        'yiister\gentelella\assets\Asset',
    ];
}
