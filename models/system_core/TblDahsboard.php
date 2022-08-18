<?php

namespace app\models\system_core;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "system_core.tbl_dashboard".
 *
 * @property string $icno
 * @property string $cuti
 * @property string $percentagecuti
 * @property string $idp
 * @property string $percentageidp
 * @property string $klinikpanel
 * @property string $percentageklinik
 * @property string $bulankgt
 * @property string $percentagekgt
 * @property string $bakikgt
 * @property string $lantikan
 * @property string $bakilantikan
 * @property string $percentagelantikan
 * @property string $warnakad
 */
class TblDahsboard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.tbl_dashboard';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 14],
            [['cuti', 'percentagecuti', 'idp', 'percentageidp', 'klinikpanel', 'percentageklinik', 'bulankgt', 'percentagekgt', 'bakikgt', 'lantikan', 'bakilantikan', 'percentagelantikan', 'warnakad'], 'string', 'max' => 50],
            [['tarikh_kemaskini'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
            'cuti' => 'Cuti',
            'percentagecuti' => 'Percentagecuti',
            'idp' => 'Idp',
            'percentageidp' => 'Percentageidp',
            'klinikpanel' => 'Klinikpanel',
            'percentageklinik' => 'Percentageklinik',
            'bulankgt' => 'Bulankgt',
            'percentagekgt' => 'Percentagekgt',
            'bakikgt' => 'Bakikgt',
            'lantikan' => 'Lantikan',
            'bakilantikan' => 'Bakilantikan',
            'percentagelantikan' => 'Percentagelantikan',
            'warnakad' => 'Warnakad',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
