<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "myidp.useraccess".
 *
 * @property string $userID
 * @property string $usertype
 */

class UserAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_tbl_useraccess';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userID'], 'required'],
            [['userID'], 'string', 'max' => 12],
            [['usertype'], 'string', 'max' => 25],
            [['userID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userID' => 'User ID',
            'usertype' => 'Usertype',
        ];
    }
    
    public function getBiodata(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'userID']);
    }

    public function getPegawai(){

        $modelAccess = UserAccess::find()->where(['usertype' => 'pegawaiLatihan'])->one();
        
        if ($modelAccess){

            return $modelAccess->userID;
        
        } else {

            $modelAccess = UrusetiaLatihan::find()->where(['ul_type' => 'ketuaUrusetia'])->one();

            if ($modelAccess){

                return $modelAccess->userID;
            }

        }
    }

    public function getKetuaSektor(){

        $modelAccess = UserAccess::find()->where(['usertype' => 'ketuaSektor'])->one();
        
        if ($modelAccess){

            return $modelAccess->userID;
        
        } 
    }
}
