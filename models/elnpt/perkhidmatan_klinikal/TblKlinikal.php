<?php

namespace app\models\elnpt\perkhidmatan_klinikal;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_klinikal".
 *
 * @property int $id
 * @property string $lpp_id
 * @property int $cbt Clinical bedside teaching
 * @property int $apc Annual Practicing Certificate
 * @property string $apc_datetime
 */
class TblKlinikal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_klinikal';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db2');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'apc',], 'integer'],
            [['apc_datetime'], 'safe'],
            [['clinic_consult', 'cbt'], 'number', 'min' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'cbt' => 'Clinical Bedside Teaching',
            'apc' => 'Apc',
            'apc_datetime' => 'Apc Datetime',
            'clinic_consult' => 'Clinical Consultation (Clinic/Ward Round/Procedure)',
        ];
    }
}
