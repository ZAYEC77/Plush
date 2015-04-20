<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 AtNiwe
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace app\assets;


use yii\web\AssetBundle;

class JqueryZoomAsset extends AssetBundle
{
    public $sourcePath = '@webroot/js/plugins/elevatezoom';
    public $js = [
        'jquery.elevatezoom.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
} 