<?php

namespace app\models;

use yii\db\ActiveRecord;

class TestInterkassa extends ActiveRecord
{
    const STATUS_FAILED = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_PENDING = 2;

    public static function tableName()
    {
        return 'test_interkassa';
    }

    public function rules()
    {
        return [
            [['status', 'amount'], 'required'],
        ];
    }
}
