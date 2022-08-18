<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "idp.rpt_statistik_idp".
 *
 * @property int $tahun
 * @property string $icno
 * @property int $idp_mata_min
 * @property int $idp_cf
 * @property int $idp_kom_teras
 * @property int $idp_mata_teras
 * @property int $idp_kom_elektif
 * @property int $idp_mata_elektif
 * @property int $idp_kom_sumbangan
 * @property int $idp_mata_sumbangan
 * @property int $jum_mata_semasa
 * @property int $jum_mata_dikira
 * @property int $baki
 * @property int $status 0=Tiada Mata IDP,1=Belum Capai Mata Minima,2=Capai Mata Minima
 * @property string $tarikh_kemaskini
 * @property int $id
 * @property int $matamin_teras_uni
 * @property int $idp_teras_uni
 * @property int $cf_teras_skim
 * @property int $matamin_teras_skim
 * @property int $idp_teras_skim
 */
class TblStatistikIdp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'idp.rpt_statistik_idp';
    }
    
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
            [['tahun', 'icno'], 'required'],
            [['tahun', 'idp_mata_min', 'idp_cf', 'idp_kom_teras', 'idp_mata_teras', 'idp_kom_elektif', 'idp_mata_elektif', 'idp_kom_sumbangan', 'idp_mata_sumbangan', 'jum_mata_semasa', 'jum_mata_dikira', 'baki', 'status', 'matamin_teras_uni', 'idp_teras_uni', 'cf_teras_skim', 'matamin_teras_skim', 'idp_teras_skim'], 'integer'],
            [['tarikh_kemaskini'], 'safe'],
            [['icno'], 'string', 'max' => 12],
            [['tahun', 'icno'], 'unique', 'targetAttribute' => ['tahun', 'icno']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'icno' => 'Icno',
            'idp_mata_min' => 'Idp Mata Min',
            'idp_cf' => 'Idp Cf',
            'idp_kom_teras' => 'Idp Kom Teras',
            'idp_mata_teras' => 'Idp Mata Teras',
            'idp_kom_elektif' => 'Idp Kom Elektif',
            'idp_mata_elektif' => 'Idp Mata Elektif',
            'idp_kom_sumbangan' => 'Idp Kom Sumbangan',
            'idp_mata_sumbangan' => 'Idp Mata Sumbangan',
            'jum_mata_semasa' => 'Jum Mata Semasa',
            'jum_mata_dikira' => 'Jum Mata Dikira',
            'baki' => 'Baki',
            'status' => 'Status',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
            'id' => 'ID',
            'matamin_teras_uni' => 'Matamin Teras Uni',
            'idp_teras_uni' => 'Idp Teras Uni',
            'cf_teras_skim' => 'Cf Teras Skim',
            'matamin_teras_skim' => 'Matamin Teras Skim',
            'idp_teras_skim' => 'Idp Teras Skim',
        ];
    }
}
