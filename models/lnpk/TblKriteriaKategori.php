<?php

namespace app\models\lnpk;

use Yii;

/**
 * This is the model class for table "hrm.lnpk_tbl_kriteria_kategori".
 *
 * @property int $id
 * @property int $id_ref_kriteria
 * @property int $id_ref_lnpk
 */
class TblKriteriaKategori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lnpk_tbl_kriteria_kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ref_kriteria', 'id_ref_lnpk'], 'required'],
            [['id_ref_kriteria', 'id_ref_lnpk'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ref_kriteria' => 'Id Ref Kriteria',
            'id_ref_lnpk' => 'Id Ref Lnpk',
        ];
    }

    public function getKriteriaDesc()
    {
        return $this->hasOne(RefKriteria::class, ['kriteria_id' => 'id_ref_kriteria']);
    }
}
