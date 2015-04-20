<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 AtNiwe
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace app\controllers;


use app\components\CartTrait;
use app\models\catalog\Product;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class CartController
 * @package app\controllers
 *
 */
class CartController extends Controller
{
    use CartTrait;
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            return $this->getAjaxData();
        }
        $dataProvider = new ArrayDataProvider();
        $data = $this->cart->getPositions();
        $dataProvider->setModels($data);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * @return array
     */
    protected function getAjaxData()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'count' => $this->cart->count,
            'cost' => Yii::$app->formatter->asDecimal($this->cart->cost),
        ];
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAdd($id, $amount = 1)
    {
        /** @var Product $model */
        $model = Product::findOne($id);
        if ($model) {
            if ($amount < 1) {
                $amount = 1;
            }
            $this->cart->put($model, $amount);
            if (Yii::$app->request->isAjax) {
                return $this->getAjaxData();
            }
            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException();
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSub($id)
    {
        /** @var Product $model */
        $model = $this->cart->getPositionById($id);
        if ($model) {
            $quantity = $model->getQuantity();
            if ($quantity > 1) {
                $this->cart->update($model, $quantity - 1);
            }
            if (Yii::$app->request->isAjax) {
                return $this->getAjaxData();
            }
            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException();
    }
    /**
     * Remove item from cart
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        /** @var Product $model */
        $model = $this->cart->getPositionById($id);
        if ($model) {
            $this->cart->remove($model);
            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException();
    }

    /**
     * Clear cart
     */
    public function actionClear()
    {
        $this->cart->removeAll();
        $this->redirect(['/site/index']);
    }
} 