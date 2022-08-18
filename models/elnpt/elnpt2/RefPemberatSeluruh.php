<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_ref_pemberat_keseluruhan".
 *
 * @property int $id
 * @property int $tbl_kump_dept_id
 * @property int $ref_gred_id
 * @property int $bahagian
 * @property double $pemberat
 * @property int $year
 */
class RefPemberatSeluruh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_ref_pemberat_keseluruhan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tbl_kump_dept_id', 'ref_gred_id', 'bahagian', 'year'], 'integer'],
            [['pemberat'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tbl_kump_dept_id' => 'Tbl Kump Dept ID',
            'ref_gred_id' => 'Ref Gred ID',
            'bahagian' => 'Bahagian',
            'pemberat' => 'Pemberat',
            'year' => 'Year',
        ];
    }
}
