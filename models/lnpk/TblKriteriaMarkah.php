<?php

namespace app\models\lnpk;

use Yii;

/**
 * This is the model class for table "hrm.lnpk_tbl_kriteria_markah".
 *
 * @property int $id
 * @property string $lnpk_id
 * @property int $id_ref_kriteria
 * @property int $kriteria_markah
 * @property string $kemaskini_dt
 */
class TblKriteriaMarkah extends \yii\db\ActiveRecord
{
    public $kriteria_desc;
    public $kriteria_label;
    public $kriteria_id;
    public $array_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lnpk_tbl_kriteria_markah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lnpk_id', 'id_ref_kriteria'], 'required'],
            [['lnpk_id', 'id_ref_kriteria'], 'integer'],
            [['kriteria_markah_ppp', 'kriteria_markah_ppk'], 'integer', 'min' => 0, 'max' => 10],
            [[
                'kemaskini_dt_ppp', 'kemaskini_dt_ppk',
                // , 'kriteria_desc', 'kriteria_label'
            ], 'safe'],
            [['kriteria_markah_ppp', 'kriteria_markah_ppk'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lnpk_id' => 'Lnpk ID',
            'id_ref_kriteria' => 'Id Ref Kriteria',
            'kriteria_markah' => 'Mark',
            'kemaskini_dt' => 'Kemaskini Dt',
            'kriteria_markah_ppp' => 'Mark',
            'kriteria_markah_ppk' => 'Mark',
        ];
    }

    public function getKriteria()
    {
        return $this->hasOne(TblKriteriaKategori::className(), ['id_ref_kriteria' => 'id_ref_kriteria']);
    }

    public function getBorang()
    {
        return $this->hasOne(TblMain::className(), ['lnpk_id' => 'lnpk_id']);
    }
}
