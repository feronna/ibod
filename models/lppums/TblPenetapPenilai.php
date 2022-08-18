<?php

namespace app\models\lppums;

use Yii;

use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\hronline\GredJawatan;

/**
 * This is the model class for table "hrm.lppums_tbl_penetap_penilai".
 *
 * @property int $id
 * @property string $tahun
 * @property int $dept_id
 * @property string $penetap_icno
 * @property int $penetap_jfpiu
 * @property int $penetap_gred
 */
class TblPenetapPenilai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_tbl_penetap_penilai';
    }
    
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun'], 'safe'],
            [['dept_id', 'penetap_jfpiu', 'penetap_gred'], 'integer'],
            [['penetap_icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun' => 'Tahun',
            'dept_id' => 'Dept ID',
            'penetap_icno' => 'Penetap Icno',
            'penetap_jfpiu' => 'Penetap Jfpiu',
            'penetap_gred' => 'Penetap Gred',
        ];
    }
    
    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }
    
    public function getPenetap() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'penetap_icno']);
    }
    
    public function getPenetapDept() {
        return $this->hasOne(Department::className(), ['id' => 'penetap_jfpiu']);
    }
    
    public function getPenetapGred() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'penetap_gred']);
    }
}
