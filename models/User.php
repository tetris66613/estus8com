<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const USERNAME_MAX_LEN = 16;

    const STATUS_UNCONFIRMED = 0;
    const STATUS_CONFIRMED = 1;

    const ROLE_BANED = 0;
    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    public static function tableName()
    {
        return 'users';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated',
                ],
                'value' => function() { return 'now()'; },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'status' => self::STATUS_CONFIRMED,
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return self::findIdentity(
            self::find()
                ->select('id')
                ->where(['email' => $email])
                ->scalar()
        );
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function compose($model)
    {
        try {
            $this->setEmail($model->email);
            $this->setPasswordHash($model->password);
            $this->setStatus($model->status);
            $this->setRole($model->role);
            $this->setAuthKey();
            $this->setUsername();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function setPasswordHash($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function setUsername()
    {
        $this->username = substr(preg_replace('/@.+$/', '', $this->email), 0, self::USERNAME_MAX_LEN);
    }

    public function setAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function register($model)
    {
        $user = new User();
        if ($user->compose($model)) {
            if ($user->save()) {
                return true;
            }
        }

        return false;
    }
}
