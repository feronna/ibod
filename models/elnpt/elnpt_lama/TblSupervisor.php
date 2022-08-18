<?php

namespace app\models\elnpt\elnpt_lama;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_supervisor".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $tahun
 * @property int $ppp_id
 * @property int $jenis_ppp
 * @property int $ppk_id
 * @property int $jenis_ppk
 * @property int $status
 * @property string $catatan
 * @property int $is_aktif
 */
class TblSupervisor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_supervisor';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'tahun', 'ppp_id', 'jenis_ppp', 'ppk_id', 'jenis_ppk', 'status', 'is_aktif'], 'integer'],
            [['catatan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'tahun' => 'Tahun',
            'ppp_id' => 'Ppp ID',
            'jenis_ppp' => 'Jenis Ppp',
            'ppk_id' => 'Ppk ID',
            'jenis_ppk' => 'Jenis Ppk',
            'status' => 'Status',
            'catatan' => 'Catatan',
            'is_aktif' => 'Is Aktif',
        ];
    }
}
