Yii2-liqpay
==========
В составе модуля содержится виджет оплаты заказа через liqpay.com.

В виджет передается модель заказа, которая должна имплементировать интерфейс interfaces/Order.

При успешной оплате liqpay вызывает callback, в котором сохраняется статус payment c значением yes в текущем заказе.

Установка
---------------------------------
В сборке Yii2 в файле composer.json нужно заменить в свойстве "minimum-stability" значение "stable" на "dev".
Т.е. у вас должно быть так:
```
"minimum-stability": "dev"
```
- Это связано с тем, что это расширение подтягивает другие расширения, в которых "minimum-stability": "dev"


Выполнить команду

```
composer require borysenko/yii2-liqpay "*"
```

Или добавить в composer.json

```
"borysenko/yii2-liqpay": "*",
```

И выполнить

```
php composer update
```

Подключение и настройка
---------------------------------
В конфигурационный файл приложения добавить модуль liqpay

```php
    'modules' => [
        'liqpay' => [
            'class' => 'borysenko\liqpay\Module',
            'public_key' => 'iNNNNNNNNNNN',
            'private_key' => 'NzpRclCywaSOrm0LTpqDpPPlRDhoOQyIX1ISHjk',
            'currency' => 'UAH',
            'pay_way' => null,
            'version' => 3,
            'sandbox' => false,
            'language' => 'ru',
            'result_url' => '/page/thanks',
            'paymentName' => 'Оплата заказа',
            'orderModel' => 'frontend\models\Order', //Модель заказа. Эта модель должна имплементировать интерфейс borysenko\liqpay\interfaces\Order. В момент списания денег будет вызываться $model->setPaymentStatus('yes').
        ],
        //...
    ],
```

Модель Order
---------------------------------
```php
<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

Class Order extends ActiveRecord implements \borysenko\liqpay\interfaces\Order
{
    public static function tableName()
    {
        return 'orders';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCost()
    {
        return $this->cost;
    }

    function setPaymentStatus($status)
    {
        $this->payment = $status;

        return $this;
    }
}
```

Виджеты
---------------------------------
За вывод формы оплаты отвечает виджет borysenko\liqpay\widgets\PaymentForm.

```php
<?=\borysenko\liqpay\widgets\PaymentForm::widget([
    'autoSend' => true,
    'orderModel' => $model, //Order::findOne($id);
    'description' => 'Оплата заказа'
]);?>
```

* autoSend - нужно ли автоматически отправлять форму заказа
* orderModel - экземпляр модели заказа, имплементирующий interfaces/Order
* description - описание платежа
