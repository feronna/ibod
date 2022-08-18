<?php

namespace app\models\klinikpanel;

use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblkeluarga;
use Yii;

/**
 * This is the model class for table "klinikpanel2.tblmaxtuntutan".
 *
 * @property string $max_icno
 * @property string $max_tuntutan
 * @property string $current_balance
 * @property string $topup_max
 * @property string $tuntutan_bukan_panel
 * @property string $jum_tuntutan
 * @property string $last_update
 * @property string $last_updater
 */
class Tblmaxtuntutan extends \yii\db\ActiveRecord
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
        return 'hrm.myhealth_tblmaxtuntutan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['max_icno'], 'required'],
            [['max_tuntutan', 'current_balance', 'topup_max', 'tuntutan_bukan_panel', 'jum_tuntutan'], 'number'],
            [['last_update'], 'safe'],
            [['max_icno'], 'string', 'max' => 12],
            [['last_updater'], 'string', 'max' => 15],
            [['max_icno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'max_icno' => 'Max Icno',
            'max_tuntutan' => 'Max Tuntutan',
            'current_balance' => 'Current Balance',
            'topup_max' => 'Topup Max',
            'tuntutan_bukan_panel' => 'Tuntutan Bukan Panel',
            'jum_tuntutan' => 'Jum Tuntutan',
            'last_update' => 'Last Update',
            'last_updater' => 'Last Updater',
        ];
    }
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'max_icno']);
    }
    
    public function getTuntutan()
    {
        $query = Tblvisit::find()->where(['visit_icno'=> $this->max_icno, 'YEAR(rawatan_date)'=> date('Y')])->sum('jum_tuntutan');
        if (!empty($query)){
            return $query;
        }
        return '0.00';
    }
    
    public function getJumlah() {
        $query = TblMedcare::find()->where(['staff_icno'=>$this->max_icno, 'YEAR(visit_dt)' => date('Y')])->sum('deduct_amt');
        if (!empty($query)){
            return $query;
        }
        return '0.00';
    }
    /**
     * Miji - added 24/08/2020
     * 
     * check klu balance mencukupi utk claim before deduct and after deduct
     * 
     * return boolean.
     */
    public static function checkBalance($icno, $amt)
    {

        $model = self::findOne(['max_icno' => $icno]);

        if ($model) {
            if ($model->current_balance < 100) {
                return false;
            } elseif (($model->current_balance - $amt) < 100) {
                return false;
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * Miji - added 24/08/2020
     * 
     * function ni utk deduct balance sahaja.. validation semua dlm function checkbalance (diatas)
     * 
     * return boolean.
     */
    public static function deductBalance($icno, $amt)
    {
        $model = self::findOne(['max_icno' => $icno]);

        if ($model) {
            $model->current_balance = $model->current_balance - $amt;
            $model->last_update = date("Y-m-d H:i:s");
            $model->last_updater = 'HUMS-MEDCARE';
            $model->save(false);
            return true;
        }

        return false;
    }
    
    public function getTanggungan() {
        $icno = Yii::$app->user->getId();
        $fmember = [01, 02, 03, 04];
        $f = Tblkeluarga::find()->where(['RelCd' => $fmember,'ICNO' => $icno])->orWhere(['RelCd' => [05,15], 'FmyDisabilityStatus' => 1,'ICNO' => $icno])->orWhere('RelCd in (05,15) and ((DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(FmyBirthDt)), "%Y")+0) < 21) and ICNO = "'.$icno.'"')->count();
    
        if($f){
            return $f;
        }
        return false;
    }

    public function getPermohonan() {

        return $this->hasOne(Tblmohon::className(), ['icno' => 'max_icno']);

    }

    public function getPerbelanjaan(){
        
        $query = self::find()->where(['icno'=> $this->icno]);
        $jum = $query->max_tuntutan + $query->topup_max + $query->tuntutan_bukan_panel;
        $medcare = Tblmedcare::find()->where(['icno'=>$this->icno])->sum('deduct_amt');

        return $medcare;

     
    }

    public static function totalPendingMohon($icno)
    {
         $check = Tblmohon::find()->where(['icno' => $icno])->andWhere(['IN', 'status', [0, 1, 2, 5]])->one();
         $check2 = Tblmohon::find()->where(['icno' => $icno])->andWhere(['entry_id'=> 2])->exists();
         if (!$check){
            if(!$check2){
        $count = self::find()
            ->where(['max_icno' => $icno])
            ->andWhere(['<','current_balance','300.00'])
            ->asArray()
            ->count('max_icno');

        return $count;
    } 
    } 
    else {
        return '';
    }

}
}

