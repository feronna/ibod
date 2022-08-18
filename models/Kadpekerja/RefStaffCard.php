<?php

namespace app\models\Kadpekerja;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "keselamatan.utils_ref_temp_payment".
 *
 * @property int $id
 * @property string $ref_icno
 * @property string $ref_umsper
 * @property string $payment
 * @property string $no_resit
 * @property string $mohon_dt
 * @property string $total
 * @property string $catatan
 * @property string $updated_by
 * @property string $updater_dt
 * @property int $free
 */
class RefStaffCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.utils_ref_staff_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mohon_dt', 'updater_dt'], 'safe'],
            [['total'], 'number'],
            [['catatan'], 'string'],
            [['free', 'parent_id'], 'integer'],
            [['ref_icno', 'updated_by'], 'string', 'max' => 12],
            [['ref_umsper'], 'string', 'max' => 20],
            [['payment', 'no_resit'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_icno' => 'Ref Icno',
            'ref_umsper' => 'Ref Umsper',
            'payment' => 'Payment',
            'no_resit' => 'No Resit',
            'mohon_dt' => 'Mohon Dt',
            'total' => 'Total',
            'catatan' => 'Catatan',
            'updated_by' => 'Updated By',
            'updater_dt' => 'Updater Dt',
            'free' => 'Free', 
        ];
    }
    public function getTarikh($bulan){
        
        $m = date_format(date_create($bulan), "m");
        if($m == 01){
            $m = "Januari";}
        elseif ($m == 02){
          $m = "Februari";}
        elseif ($m == 03){
          $m = "Mac";}
        elseif ($m == 04){
          $m = "April";}
        elseif ($m == 05){
          $m = "Mei";}
        elseif ($m == 06){
          $m = "Jun";}
        elseif ($m == 07){
          $m = "Julai";}
        elseif ($m == '08'){
          $m = "Ogos";}
        elseif ($m == '09'){
          $m = "September";}
        elseif ($m == '10'){
          $m = "Oktober";}
        elseif ($m == '11'){
          $m = "November";}
        elseif ($m == '12'){
          $m = "Disember";}
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y");
    }
     public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'updated_by']);
    }
     public function getUpdaterDt() {
        if ($this->updater_dt != '') {
            return $this->getTarikh($this->updater_dt);
        }
    } 
}
