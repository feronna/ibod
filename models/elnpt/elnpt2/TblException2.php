<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_tbl_exception".
 *
 * @property string $lpp_id
 * @property int $tbl_kump_dept_id
 * @property int $ref_gred_id
 */
class TblException2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_tbl_exception';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id'], 'required'],
            [['lpp_id', 'tbl_kump_dept_id', 'ref_gred_id'], 'integer'],
            [['lpp_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lpp_id' => 'Lpp ID',
            'tbl_kump_dept_id' => 'Tbl Kump Dept ID',
            'ref_gred_id' => 'Ref Gred ID',
        ];
    }
}
