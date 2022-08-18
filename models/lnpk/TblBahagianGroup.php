<?php

namespace app\models\lnpk;

use Yii;

/**
 * This is the model class for table "hrm.lnpk_tbl_bahagian_group".
 *
 * @property int $id
 * @property int $id_ref_bahagian
 * @property int $id_ref_lnpk
 */
class TblBahagianGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lnpk_tbl_bahagian_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ref_bahagian', 'id_ref_lnpk'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ref_bahagian' => 'Id Ref Bahagian',
            'id_ref_lnpk' => 'Id Ref Lnpk',
        ];
    }
}
