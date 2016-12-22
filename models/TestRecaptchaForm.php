<?php

namespace app\models;

use yii\base\Model;

class TestRecaptchaForm extends Model
{
    const SCENARIO_TEST  = 'test';

    public $testfield;
    public $testrecaptcha;

    public function rules()
    {
        return [
            [['testfield'], 'required'],
            [['testrecaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_TEST] = ['testfield', 'testrecaptcha'];

        return $scenarios;
    }

    public function formName()
    {
        return $this->getScenario();
    }

    public function test()
    {
        if ($this->validate()) {
            return true;
        }

        return false;
    }
}
