<?php

namespace app\models;

use yii\base\Model;

class TestRecaptchaForm extends Model
{
    public $testfield;
    public $testrecaptcha;

    public function rules()
    {
        return [
            [['testfield'], 'required'],
            [['testrecaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()],
        ];
    }

    public function test()
    {
        if ($this->validate()) {
            return true;
        }

        return false;
    }
}
