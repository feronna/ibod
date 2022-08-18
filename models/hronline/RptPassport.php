<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\Tblpasport;
use app\models\hronline\Tblprcobiodata;

class RptPassport extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.rpt_passport';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pasport_status','ps_noty_status','isSabahan','tblpassport_id','permit_status','pr_noty_status','tblpermit_id', 'lock'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'isSabahan' => 'Sabahan Status',
            'pasport_status' => 'Passport Status',
            'ps_noty_status' => 'Passport notification Status',
            'tblpassport_id' => 'Tblpassport ID',
            'permit_status' => 'Permit Status',
            'pr_noty_status' => 'Permit notification Status',
            'tblpermit_id' => 'Tblpermit ID',
            'lock' => 'lock',
        ];
    }

    public function getPassport() {
        return $this->hasOne(Tblpasport::className(), ['id' => 'tblpassport_id']);
    }
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
