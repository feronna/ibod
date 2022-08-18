<?php

namespace app\models\elnpt;

use Yii;
use app\models\elnpt\TblPenetapPenilai;
use app\models\elnpt\Department;
use app\models\elnpt\RefKumpDept;

/**
 * This is the model class for table "hrm.elnpt_tbl_kump_dept".
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
        return 'hrm.elnpt_tbl_kump_dept';
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
    
    public function getPenetapPenilai() {
        $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
        return $this->hasOne(TblPenetapPenilai::className(), ['ref_kump_dept' => 'dept_id'])->andOnCondition(['tahun' => $tahun->lpp_tahun]);
    }
    
    public function getDept() {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }
    
    public function getNamaKumpDept() {
        return $this->hasOne(RefKumpDept::className(), ['id' => 'ref_kump_dept_id']);
    }
}
