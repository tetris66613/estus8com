<?php
namespace app\models;

use Yii;
use app\models\TestInterkassa;
use yii\base\Model;
use app\models\User;

class InterkassaRefillForm extends Model
{
    public $amount;

    public function rules()
    {
        return [
            [['amount'], 'required'],
            [['amount'], 'number', 'min' => 0],
        ];
    }

    public function refill()
    {
        $user = Yii::$app->user->identity;
        if ($this->validate()) {
            $transaction = new TestInterkassa();
            $transaction->user_id = $user->id;
            $transaction->amount = $this->amount;
            $transaction->status = TestInterkassa::STATUS_PENDING;

            if ($transaction->save()) {
                $url = $this->formUrl($transaction);
                return $url;
            }
        }
        return false;
    }

    private function formUrl(&$transaction)
    {
        $params = Yii::$app->params;
        $url = 'https://sci.interkassa.com/';

        $ik_co_id = isset($params['ik_co_id']) ? $params['ik_co_id'] : '';
        $secretKey = isset($params['ik_secretKey']) ? $params['ik_secretKey'] : '';
        $ik_pm_no = $transaction->id;
        $ik_am = $transaction->amount;
        $ik_desc = 'test';

        $ik = ['ik_co_id', 'ik_pm_no', 'ik_am', 'ik_desc'];
        sort($ik, SORT_STRING);
        //file_put_contents('/var/www/test.txt', print_r($ik, true)); exit;
        $ik[] = $secretKey;
        $ik_sign = base64_encode(md5(implode(':', $ik), true));

        $url .= '?ik_co_id=' . $ik_co_id;
        $url .= '&ik_pm_no=' . $ik_pm_no;
        $url .= '&ik_am=' . $ik_am;
        $url .= '&ik_desc=' . $ik_desc;
        $url .= '&ik_sign=' . $ik_sign;

        return $url;
    }

    public static function validateResultResponse()
    {
        $params = Yii::$app->params;
        $userid = Yii::$app->user->identity->id;
        $ik_co_id = Yii::$app->request->get('ik_co_id');
        $ik_pm_no = Yii::$app->request->get('ik_pm_no');
        $shop = isset($params['ik_co_id']) ? $params['ik_co_id'] : null;
        if ($shop && $ik_co_id && $ik_pm_no && $shop == $ik_co_id) {
            $transaction = Transaction::find()->where(['user_id' => $userid, 'id' => $ik_pm_no])->one();
            if ($transaction) {
                return true;
            }
        }

        return false;
    }

    public function attributeLabels()
    {
        return [
            'amount' => 'Amount, $',
        ];
    }
}
