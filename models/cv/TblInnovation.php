<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cv.cv_tbl_innovation".
 *
 * @property int $id
 * @property string $uid
 * @property string $year
 * @property int $dept_id
 * @property string $unit
 * @property string $innovation
 * @property string $ICNO
 */
class TblInnovation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_innovation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'dept_id', 'unit', 'innovation'], 'required'],
            [['year'], 'safe'],
            [['dept_id'], 'integer'], 
            [['unit'], 'string', 'max' => 100],
            [['innovation'], 'string', 'max' => 255],
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'year' => 'Tahun',
            'dept_id' => 'JSPIU',
            'unit' => 'Unit/Seksyen/Bahagian',
            'innovation' => 'Inovasi',
            'ICNO' => 'Icno',
        ];
    }
    
    public function getDepartment() {
        return $this->hasOne(\app\models\hronline\Department::className(), ['id' => 'dept_id']);
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
