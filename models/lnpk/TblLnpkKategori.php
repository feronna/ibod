<?php

namespace app\models\lnpk;

use Yii;

/**
 * This is the model class for table "hrm.lnpk_tbl_lnpk_group".
 *
 * @property int $id
 * @property int $id_ref_lnpk
 * @property int $id_job_group
 */
class TblLnpkKategori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lnpk_tbl_lnpk_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ref_lnpk'], 'required'],
            [['id_ref_lnpk', 'id_job_group'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ref_lnpk' => 'Id Ref Lnpk',
            'id_job_group' => 'Id Job Group',
        ];
    }
}
