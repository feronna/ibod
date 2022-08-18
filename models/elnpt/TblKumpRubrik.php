<?php

namespace app\models\elnpt;

use Yii;
//use app\models\elnpt\TblKumpRubrik;
use app\models\elnpt\TblKumpDept;
use app\models\elnpt\TblKumpGred;
use app\models\elnpt\RefKumpRubrik;

/**
 * This is the model class for table "hrm.elnpt_tbl_kump_rubrik".
 *
 * @property int $id
 * @property int $kump_rubrik_id
 * @property int $kump_dept_id
 * @property int $kump_gred_id
 */
class TblKumpRubrik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_kump_rubrik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kump_rubrik_id', 'kump_dept_id', 'kump_gred_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kump_rubrik_id' => 'Kump Rubrik ID',
            'kump_dept_id' => 'Kump Dept ID',
            'kump_gred_id' => 'Kump Gred ID',
        ];
    }
    
    public function getKumpKategori() {
        $kump_rubrik = TblKumpRubrik::find()
                ->leftJoin('hrm.elnpt_tbl_kump_dept', 'hrm.elnpt_tbl_kump_rubrik.kump_dept_id = hrm.elnpt_tbl_kump_dept.ref_kump_dept_id')
                ->leftJoin('hrm.elnpt_tbl_kump_gred', 'hrm.elnpt_tbl_kump_rubrik.kump_gred_id = hrm.elnpt_tbl_kump_gred.ref_kump_gred_id')
                ->where(['hrm.elnpt_tbl_kump_dept.dept_id' => Yii::$app->user->identity->DeptId, 'hrm.elnpt_tbl_kump_gred.gred_id' => Yii::$app->user->identity->gredJawatan])
                ->all();
        return $kump_rubrik->kump_rubrik_id;
    }
    
    public function getNamaKumpRubrik() {
        return $this->hasOne(RefKumpRubrik::className(), ['id' => 'kump_rubrik_id']);
    }
}
