<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "new_hrm.lppums_tbl_request_log".
 *
 * @property string $lpp_id
 * @property string $PYD
 * @property string $tahun
 * @property string $request_type
 */
class TblRequestLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_request_log';
    }
    
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id'], 'required'],
            [['lpp_id'], 'integer'],
            [['tahun'], 'safe'],
            [['PYD'], 'string', 'max' => 12],
            [['request_type'], 'string', 'max' => 10],
            [['lpp_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lpp_id' => 'Lpp ID',
            'PYD' => 'Pyd',
            'tahun' => 'Tahun',
            'request_type' => 'Request Type',
        ];
    }
}
