<?php

namespace app\models\elnpt\elnpt2;

use app\models\hronline\Department;
use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_tbl_kump_dept".
 *
 * @property int $id
 * @property int $ref_kump_dept_id
 * @property int $dept_id
 */
class TblKumpDept extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_tbl_kump_dept';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref_kump_dept_id', 'dept_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_kump_dept_id' => 'Ref Kump Dept ID',
            'dept_id' => 'Dept ID',
        ];
    }

    public function getRefKump()
    {
        return $this->hasOne(RefKumpDept::className(), ['id' => 'ref_kump_dept_id']);
    }

    public function getDept()
    {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }
}
