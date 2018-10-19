<?php

namespace borysenko\liqpay;

use Yii;
use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $public_key;
    public $private_key;
    public $version = 3;
    public $debug = false;
    public $sandbox = false;
    public $language = 'ru';
    public $server_url;
    public $result_url;
    public $paymentName;
    public $currency;
    public $pay_way;
    public $orderModel = null;

    public function init()
    {
        if (empty($this->server_url)) {
            $this->server_url = Url::toRoute(['/liqpay/liqpay/callback'], true);
        }

        Yii::$app->set('liqpay', [
            'class' => '\voskobovich\liqpay\LiqPay',
            'public_key' => $this->public_key,
            'private_key' => $this->private_key,
            'version' => $this->version,
            'debug' => $this->debug,
            'sandbox' => $this->sandbox,
            'language' => $this->language,
            'server_url' => $this->server_url,
            'result_url' => $this->result_url,
            'paymentName' => $this->paymentName,
        ]);

        return parent::init();
    }
}
