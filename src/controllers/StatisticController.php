<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 AtNiwe
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace app\controllers;


use app\models\Statistic;
use Yii;
use yii\web\Controller;

class StatisticController extends Controller
{
    public function actionIndex()
    {
        $model = new Statistic();
        $data = [];

        if ($model->load(Yii::$app->request->getQueryParams()) && $model->validate()) {
$data = $model->getData();
        }

        return $this->render('index', [
            'model' => $model,
            'data' => $data,
        ]);
    }
} 