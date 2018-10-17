<?php
namespace borysenko\liqpay\interfaces;

interface Order
{
    public function getId();

    public function getCost();

    public function setPaymentStatus($status);
}
