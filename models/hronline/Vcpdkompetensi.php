<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.v_cpd_kompetensi".
 *
 * @property int $vcks_kod_kompetensi
 * @property string $vcks_nama_kompetensi
 * @property string $vcks_enama_kompetensi
 * @property int $isActive 1=Aktif,0=Tidak Aktif
 * untuk dapatkan idp
 */
class Vcpdkompetensi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.v_cpd_kompetensi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vcks_kod_kompetensi'], 'required'],
            [['vcks_kod_kompetensi', 'isActive'], 'integer'],
            [['vcks_nama_kompetensi', 'vcks_enama_kompetensi'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vcks_kod_kompetensi' => 'Vcks Kod Kompetensi',
            'vcks_nama_kompetensi' => 'Vcks Nama Kompetensi',
            'vcks_enama_kompetensi' => 'Vcks Enama Kompetensi',
            'isActive' => 'Is Active',
        ];
    }
}
