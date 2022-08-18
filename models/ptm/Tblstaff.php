<?php

namespace app\models\ptm;

use Yii;

/**
 * This is the model class for table "hrd.ptm_tblstaff".
 *
 * @property int $id
 * @property string $icno
 * @property int $dept_id
 * @property string $lantik_dt
 * @property int $flag 1-sudah PTM, 0-Belum PTM
 */
class Tblstaff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.ptm_tbl_staff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dept_id', 'flag','status_terima','status_hadir','siri_id'], 'integer'],
            [['lantik_dt','status_terima_remarks','status_hadir_remarks','marks','status_dt'], 'safe'],
            [['icno'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'dept_id' => 'Dept ID',
            'lantik_dt' => 'Lantik Dt',
            'flag' => 'Flag',
        ];
    }
}
