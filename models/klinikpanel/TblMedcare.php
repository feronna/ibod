<?php

namespace app\models\klinikpanel;

use Yii;
use app\models\hronline\Tblprcobiodata;
/**
 * This is the model class for table "klinikpanel2.tbl_medcare".
 *
 * @property int $id
 * @property string $receipt_no
 * @property string $staff_icno
 * @property string $patient_icno
 * @property string $visit_dt
 * @property string $deduct_amt
 * @property string $diagnosis
 * @property string $entry_dt
 */
class TblMedcare extends \yii\db\ActiveRecord
{

    // add the function below:
    public static function getDb()
    {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myhealth_tbl_medcare';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receipt_no', 'staff_icno', 'patient_icno', 'visit_dt', 'deduct_amt', 'entry_dt'], 'required'],
            [['visit_dt', 'entry_dt'], 'safe'],
            [['deduct_amt'], 'number'],
            [['receipt_no'], 'string', 'max' => 25],
            [['staff_icno', 'patient_icno'], 'string', 'max' => 13],
            [['diagnosis'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'receipt_no' => 'Receipt No',
            'staff_icno' => 'Staff Icno',
            'patient_icno' => 'Patient Icno',
            'visit_dt' => 'Visit Dt',
            'deduct_amt' => 'Deduct Amt',
            'diagnosis' => 'Diagnosis',
            'entry_dt' => 'Entry Dt',
        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblmaxtuntutan::className(), ['max_icno' => 'staff_icno']);
    }
    
    public function getKeluarga() {
        return $this->hasMany(\app\models\hronline\Tblkeluarga::className(), ['ICNO' => 'staff_icno']);
    }

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staff_icno'])->andOnCondition(['!=','Status','6']);
    }
    
    public function getPesakit() {
        return $this->hasOne(\app\models\hronline\Tblkeluarga::className(), ['FamilyId' => 'patient_icno']);
    }

}
