<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 AtNiwe
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace app\models;


use app\models\orders\Order;
use Yii;
use yii\base\Model;

class Statistic extends Model
{
    public $dateFrom;
    public $dateTo;

    public function rules()
    {
        return [
            [['dateFrom', 'dateTo'], 'compareDates'],
            [['dateFrom', 'dateTo'], 'required'],
        ];
    }

    public function init()
    {
        //$this->dateFrom @TODO
        parent::init();
    }


    public function attributeLabels()
    {
        return [
            'dateFrom' => Yii::t('app', 'Date from'),
            'dateTo' => Yii::t('app', 'Date to'),
        ];
    }


    public function compareDates()
    {
        if (!$this->hasErrors()) {
            if (strtotime($this->dateFrom) >= strtotime($this->dateTo)) {
                $this->addError('start', Yii::t('app', 'Start time must be less than end time'));
            }
        }
    }


    public function getData()
    {
        $from = strtotime($this->dateFrom);
        $to = strtotime($this->dateTo);
        $sql = <<<SQL
                select p.title as `product`, SUM(oi.amount*oi.price) as `cost`, SUM(oi.amount) as `amount`
                  from order_item as oi
                  inner join `order` as o on o.id = oi.orderId
                  inner join `product` as p on p.id = oi.productId
                    where (o.createdAt between :from and :to) AND o.status = :status
                    group by oi.productId;
SQL;
        $cmd = Yii::$app->db->createCommand($sql, [
            ':from' => $from,
            ':to' => $to,
            ':status' => Order::STATUS_DONE,
        ]);
/*
        echo "<pre>";
        print_r($cmd->getRawSql());
        echo "</pre>";
die;*/
        $result = $cmd->queryAll();

        return $result;
    }
}