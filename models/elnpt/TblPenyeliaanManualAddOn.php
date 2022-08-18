<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_penyeliaan_manual".
 *
 * @property int $id
 * @property string $lpp_id
 * @property string $tahap_penyeliaan
 * @property int $utama_telah
 * @property int $utama_belum
 * @property int $sama_telah
 * @property int $sama_belum
 */
class TblPenyeliaanManualAddOn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_penyeliaan_manual';
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
            [['tahap_penyeliaan'], 'required'],
            [['lpp_id', 'utama_telah', 'utama_belum', 'sama_telah', 'sama_belum'], 'integer', 'min' => 0],
            [['tahap_penyeliaan'], 'safe'],
            [['utama_telah', 'utama_belum', 'sama_telah', 'sama_belum'], 'default', 'value' => 0],
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
            'tahap_penyeliaan' => 'Tahap Penyeliaan',
            'utama_telah' => 'Bilangan Pelajar',
            'utama_belum' => 'Bilangan Pelajar',
            'sama_telah' => 'Bilangan Pelajar',
            'sama_belum' => 'Bilangan Pelajar',
        ];
    }
}
