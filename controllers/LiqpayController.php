<?php

namespace borysenko\liqpay\controllers;

use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class LiqpayController extends Controller
{
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'callback' => [
                'class' => 'voskobovich\liqpay\actions\CallbackAction',
                'callable' => function ($model) {
                    $orderModel = $this->module->orderModel;
                    $orderModel = $orderModel::findOne($model->order_id);

                    if (!$orderModel) {
                        throw new NotFoundHttpException('The requested order does not exist.');
                    }

                    $orderModel->setPaymentStatus('yes');
                    $orderModel->save(false);

                    return 'YES';
                },
            ]
        ];
    }
}
