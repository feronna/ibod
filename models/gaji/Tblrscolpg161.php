<?php

namespace app\models\gaji;

use Yii;

/**
 * This is the model class for table "gaji.tblrscolpg".
 *
 * @property string $t_lpg_id PK, auto incr
 * @property string $t_lpg_ICNO
 * @property string $t_lpg_cd Jenis LPG
 * @property string $t_lpg_date_start
 * @property string $t_lpg_date_end
 * @property int $t_lpg_peringkat P1, P2 or P3?
 * @property int $t_lpg_tingkat T1-T?
 * @property string $t_lpg_amount
 * @property string $t_lpg_remark
 * @property int $t_lpg_jawatan_id SBPA_id for jawatan
 * @property int $t_lpg_dept_id
 * @property string $t_lpg_marital_cd
 * @property string $t_lpg_app_by Approved by
 * @property string $t_lpg_app_status approve, disprove
 * @property string $t_lpg_app_by_datetime Approved datetime
 * @property string $t_lpg_ver_by Verified by (initial val is IP)
 * @property string $t_lpg_ver_status approve, disprove
 * @property string $t_lpg_ver_by_datetime Verified datetime
 * @property int $t_lpg_id_sort lpg_id merujuk TELAH BAYAR
 * @property string $created_by
 * @property string $created_datetime
 * @property string $updated_by
 * @property string $updated_datetime
 */
class Tblrscolpg161 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gaji.tblrscolpg';
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
            [['t_lpg_cd', 't_lpg_peringkat', 't_lpg_tingkat', 't_lpg_jawatan_id', 't_lpg_dept_id', 't_lpg_id_sort'], 'integer'],
            [['t_lpg_date_start', 't_lpg_date_end', 't_lpg_app_by_datetime', 't_lpg_ver_by_datetime', 'created_datetime', 'updated_datetime'], 'safe'],
            [['t_lpg_amount'], 'number'],
            [['t_lpg_remark'], 'string'],
            [['t_lpg_ICNO', 't_lpg_app_by', 'created_by', 'updated_by'], 'string', 'max' => 12],
            [['t_lpg_marital_cd'], 'string', 'max' => 1],
            [['t_lpg_app_status', 't_lpg_ver_status'], 'string', 'max' => 8],
            [['t_lpg_ver_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            't_lpg_id' => 'T Lpg ID',
            't_lpg_ICNO' => 'T Lpg Icno',
            't_lpg_cd' => 'T Lpg Cd',
            't_lpg_date_start' => 'T Lpg Date Start',
            't_lpg_date_end' => 'T Lpg Date End',
            't_lpg_peringkat' => 'T Lpg Peringkat',
            't_lpg_tingkat' => 'T Lpg Tingkat',
            't_lpg_amount' => 'T Lpg Amount',
            't_lpg_remark' => 'T Lpg Remark',
            't_lpg_jawatan_id' => 'T Lpg Jawatan ID',
            't_lpg_dept_id' => 'T Lpg Dept ID',
            't_lpg_marital_cd' => 'T Lpg Marital Cd',
            't_lpg_app_by' => 'T Lpg App By',
            't_lpg_app_status' => 'T Lpg App Status',
            't_lpg_app_by_datetime' => 'T Lpg App By Datetime',
            't_lpg_ver_by' => 'T Lpg Ver By',
            't_lpg_ver_status' => 'T Lpg Ver Status',
            't_lpg_ver_by_datetime' => 'T Lpg Ver By Datetime',
            't_lpg_id_sort' => 'T Lpg Id Sort',
            'created_by' => 'Created By',
            'created_datetime' => 'Created Datetime',
            'updated_by' => 'Updated By',
            'updated_datetime' => 'Updated Datetime',
        ];
    }
}