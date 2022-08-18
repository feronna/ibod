<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_ref_pnp_waktu".
 *
 * @property int $id
 * @property int $ref_jenis_pnp
 * @property int $bil_pelajar
 * @property double $waktu_perdana
 * @property double $waktu_malam
 * @property double $hujung_minggu
 */
class RefPnpWaktu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_ref_pnp_waktu';
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
            [['ref_jenis_pnp', 'bil_pelajar'], 'integer'],
            [['waktu_perdana', 'waktu_malam', 'hujung_minggu'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_jenis_pnp' => 'Ref Jenis Pnp',
            'bil_pelajar' => 'Bil Pelajar',
            'waktu_perdana' => 'Waktu Perdana',
            'waktu_malam' => 'Waktu Malam',
            'hujung_minggu' => 'Hujung Minggu',
        ];
    }
}
