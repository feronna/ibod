<?php

namespace app\models\guarantee_letter;
use app\models\hronline\Tblprcobiodata;
use app\models\guarantee_letter\TblHospital;
use Yii;

/**
 * This is the model class for table "hrm.gl_tbl_batal".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $gl_ICNO
 * @property int $gl_hospital_id
 * @property string $ulasan
 * @property string $datetime
 * @property string $created_by
 */
class TblPermohonanBatal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gl_tbl_batal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ulasan'], 'required'],
            [['gl_hospital_id'], 'integer'],
            [['ulasan'], 'string'],
            [['datetime'], 'safe'],
            [['ICNO', 'gl_ICNO', 'created_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'gl_ICNO' => 'Gl Icno',
            'gl_hospital_id' => 'Gl Hospital ID',
            'ulasan' => 'Ulasan',
            'datetime' => 'Datetime',
            'created_by' => 'Created By',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    } 
    
    public function getPengkemaskini() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'created_by']);
    } 

    public function getHospital() {
        return $this->hasOne(TblHospital::className(), ['id' => 'gl_hospital_id']);
    } 
}
