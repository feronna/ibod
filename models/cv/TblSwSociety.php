<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_sw_society".
 *
 * @property string $fid
 * @property string $uid
 * @property string $year
 * @property string $service
 * @property string $role
 * @property int $level
 */
class TblSwSociety extends \yii\db\ActiveRecord
{ 
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_sw_society';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service', 'year', 'role','level','role_key'], 'required'],
            [['ICNO','uid'], 'safe'], 
            [['ICNO'], 'string', 'max' => 12],
            [['fid'], 'required'],
            [['service'], 'string'],
            [['level','year'], 'integer'],
            [['service', 'role','role_key'], 'string', 'max' => 255],
            [['uid'], 'string', 'max' => 20],
            [['fid'], 'unique'],
            [['kategori_servis','peringkat'], 'integer'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fid' => 'Fid',
            'uid' => 'Uid',
            'year' => 'Year',
            'service' => 'Service',
            'role' => 'Role Details',
            'level' => 'Level',
            'role_key' => 'Role'
        ];
    }
    
    public function getLvl() {
        return $this->hasOne(\app\models\cv\RefSwSociety::className(), ['id' => 'level']);
    }
    public function getPeringkatKomuniti() {
        return $this->hasOne(\app\models\myidp\IdpRefPeringkat::className(), ['id' => 'peringkat']);
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
