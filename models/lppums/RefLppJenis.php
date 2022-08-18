<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "new_hrm.lppums_ref_lpp_jenis".
 *
 * @property int $lpp_jenis_id
 * @property string $lpp_jenis
 */
class RefLppJenis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_lpp_jenis';
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
            [['lpp_jenis_id'], 'required'],
            [['lpp_jenis_id'], 'integer'],
            [['lpp_jenis'], 'string', 'max' => 70],
            [['lpp_jenis_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lpp_jenis_id' => 'Lpp Jenis ID',
            'lpp_jenis' => 'Lpp Jenis',
        ];
    }
}
