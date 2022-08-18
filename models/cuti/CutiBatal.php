<?php

namespace app\models\cuti;

use Yii;

/**
 * This is the model class for table "e_cuti.cuti_rekod_batal".
 *
 * @property string $cuti_rekod_batal_id
 * @property string $cuti_rekod_id
 * @property string $cuti_icno
 * @property string $cuti_mula
 * @property string $cuti_tamat
 * @property string $cuti_catatan
 * @property int $cuti_tempoh
 * @property int $cuti_jenis_id 		
 * @property int $cuti_lampir_dok bool value must be true/1 if pemohon lampir dok
 * @property string $cuti_session_id
 * @property string $cuti_session_ip
 * @property string $cuti_ganti_oleh
 * @property string $cuti_dok_peraku_oleh ICNO penyelia cuti yg peraku dokumen
 * @property string $cuti_peraku_oleh
 * @property string $cuti_lulus_oleh
 * @property string $cuti_status_dok_peraku NULL, L, TL
 * @property string $cuti_ganti_status
 * @property string $cuti_status_peraku NULL, L, TL
 * @property string $cuti_status_lulus NULL, L, TL, P, B
 * @property string $cuti_mohon_pada
 * @property string $cuti_dok_peraku_pada
 * @property string $cuti_ganti_status_pada
 * @property string $cuti_peraku_pada
 * @property string $cuti_lulus_pada
 * @property string $cuti_admin_oleh peg/admin di pendaftar yg overwrite status
 * @property string $cuti_status_admin status yg overwrite by admin
 * @property string $cuti_catatanx Dummy column sahaja
 * @property string $cuti_catatan_peraku
 * @property string $cuti_catatan_lulus
 */
class CutiBatal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    // public static function getDb()
    // {
    //     return Yii::$app->get('db2'); // second database
    // }

    public static function tableName()
    {
        return 'hrm.cuti_cancelled_leave'; 

        // return 'e_cuti.cuti_rekod_batal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuti_rekod_id', 'cuti_icno'], 'required'],
            [['cuti_rekod_id', 'cuti_tempoh', 'cuti_jenis_id', 'cuti_lampir_dok'], 'integer'],
            [['cuti_mula', 'cuti_tamat', 'cuti_mohon_pada', 'cuti_dok_peraku_pada', 'cuti_ganti_status_pada', 'cuti_peraku_pada', 'cuti_lulus_pada'], 'safe'],
            [['cuti_icno', 'cuti_session_id', 'cuti_ganti_oleh', 'cuti_dok_peraku_oleh', 'cuti_peraku_oleh', 'cuti_lulus_oleh', 'cuti_admin_oleh'], 'string', 'max' => 12],
            [['cuti_catatan_peraku', 'cuti_catatan_lulus'], 'string', 'max' => 200],
            [['cuti_session_ip'], 'string', 'max' => 30],
            [['full_date'], 'string', 'max' => 50],
            [['cuti_batal_oleh'], 'string', 'max' => 12],
            [['file_hashcode'], 'string', 'max' => 100],
            [['cuti_status_dok_peraku', 'cuti_ganti_status', 'cuti_status_peraku', 'cuti_status_lulus', 'cuti_status_admin'], 'string', 'max' => 2],
            [['cuti_catatanx'], 'string', 'max' => 1],
            [['status'], 'string', 'max' => 8],
            [['cuti_catatan', ], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cuti_rekod_batal_id' => 'Cuti Rekod Batal ID',
            'cuti_rekod_id' => 'Cuti Rekod ID',
            'cuti_icno' => 'Cuti Icno',
            'cuti_mula' => 'Cuti Mula',
            'cuti_tamat' => 'Cuti Tamat',
            'cuti_catatan' => 'Cuti Catatan',
            'cuti_tempoh' => 'Cuti Tempoh',
            'cuti_jenis_id' => 'Cuti Jenis ID',
            'cuti_lampir_dok' => 'Cuti Lampir Dok',
            'cuti_session_id' => 'Cuti Session ID',
            'cuti_session_ip' => 'Cuti Session Ip',
            'cuti_ganti_oleh' => 'Cuti Ganti Oleh',
            'cuti_dok_peraku_oleh' => 'Cuti Dok Peraku Oleh',
            'cuti_peraku_oleh' => 'Cuti Peraku Oleh',
            'cuti_lulus_oleh' => 'Cuti Lulus Oleh',
            'cuti_status_dok_peraku' => 'Cuti Status Dok Peraku',
            'cuti_ganti_status' => 'Cuti Ganti Status',
            'cuti_status_peraku' => 'Cuti Status Peraku',
            'cuti_status_lulus' => 'Cuti Status Lulus',
            'cuti_mohon_pada' => 'Cuti Mohon Pada',
            'cuti_dok_peraku_pada' => 'Cuti Dok Peraku Pada',
            'cuti_ganti_status_pada' => 'Cuti Ganti Status Pada',
            'cuti_peraku_pada' => 'Cuti Peraku Pada',
            'cuti_lulus_pada' => 'Cuti Lulus Pada',
            'cuti_admin_oleh' => 'Cuti Admin Oleh',
            'cuti_status_admin' => 'Cuti Status Admin',
            'cuti_catatanx' => 'Cuti Catatanx',
            'cuti_catatan_peraku' => 'Cuti Catatan Peraku',
            'cuti_catatan_lulus' => 'Cuti Catatan Lulus',
        ];
    }
}
