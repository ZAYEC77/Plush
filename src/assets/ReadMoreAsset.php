<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 AtNiwe
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace app\assets;


use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\AssetBundle;
use Yii;

class ReadMoreAsset extends AssetBundle
{
    public $sourcePath = '@bower/readmore';

    public $js = [
        'readmore.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function registerAssetFiles($view)
    {
        $options = Json::encode([
            'moreLink' => Html::a(Yii::t('app', 'Read more'), '#'),
            'lessLink' => Html::a(Yii::t('app', 'Hide'), '#'),
        ]);
        $view->registerJs('jQuery(".read-more").readmore(' . $options . ')');
        return parent::registerAssetFiles($view);
    }

} 