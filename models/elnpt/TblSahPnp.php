<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_pengesahan_pnp".
 *
 * @property int $id
 * @property string $lpp_id
 * @property int $PPP_sah
 * @property string $PPP_sah_datetime
 */
class TblSahPnp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_pengesahan_pnp';
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
            [['lpp_id', 'PPP_sah'], 'integer'],
            [['PPP_sah_datetime'], 'safe'],
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
            'PPP_sah' => 'Ppp Sah',
            'PPP_sah_datetime' => 'Ppp Sah Datetime',
        ];
    }
}
