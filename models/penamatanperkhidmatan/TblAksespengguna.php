<?php

namespace app\models\penamatanperkhidmatan;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
/**
 * This is the model class for table "penamatanperkhidmatan.tbl_admin".
 *
 * @property int $id
 * @property int $dept_id
 * @property string $icno
 */
class TblAksespengguna extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tamat_tbl_aksespengguna';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dept_id'], 'integer'],
            [['icno'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dept_id' => 'Dept ID',
            'icno' => 'Icno',
        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }
}
