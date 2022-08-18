<?php

namespace app\models\hronline;
use app\models\hronline\RefEpfType;
use app\models\hronline\RefSocsoType;
use app\models\hronline\RefTaxFormulaType;
use Yii;
USE app\models\hronline\RefTaxCategory;
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;
/**
 * This is the model class for table "hronline.tbl_staff_salary".
 *
 * @property string $SS_REF_CODE
 * @property string $SS_STAFF_ID
 * @property string $SS_CMPY_CODE
 * @property string $SS_START_DATE
 * @property string $SS_END_DATE
 * @property string $SS_SALARY_TYPE
 * @property string $SS_BASIC_SALARY
 * @property string $SS_RATE
 * @property string $SS_EPF_STATUS
 * @property string $SS_EPF_TYPE
 * @property string $SS_EPF_METHOD
 * @property string $SS_EPF_EMPYER_PCT
 * @property string $SS_EPF_EMPYEE_PCT
 * @property string $SS_TAX_STATUS
 * @property string $SS_TAX_CATEGORY
 * @property string $SS_ZAKAT_STATUS
 * @property string $SS_ZAKAT_CODE
 * @property string $SS_SOCSO_STATUS
 * @property string $SS_SOCSO_TYPE
 * @property string $SS_ENTER_BY
 * @property string $SS_ENTER_DATE
 * @property string $SS_VERIFY_BY
 * @property string $SS_VERIFY_DATE
 * @property string $SS_UPDATE_BY
 * @property string $SS_UPDATE_DATE
 * @property string $SS_CHANGE_REASON
 * @property string $SS_TAX_FORMULA
 * @property string $SS_NUM_DEPENDENT
 * @property string $SS_SALARY_STATUS
 * @property string $SS_PENSION_STATUS
 * @property string $SS_ACCT_CHARGE
 */
class TblStaffSalary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tbl_staff_salary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SS_REF_CODE'], 'required'],
            [['SS_BASIC_SALARY', 'SS_RATE', 'SS_EPF_EMPYER_PCT', 'SS_EPF_EMPYEE_PCT', 'SS_NUM_DEPENDENT'], 'number'],
            [['SS_REF_CODE', 'SS_EPF_TYPE', 'SS_SOCSO_TYPE'], 'string', 'max' => 50],
            [['SS_STAFF_ID', 'SS_ENTER_BY', 'SS_ENTER_DATE', 'SS_VERIFY_BY', 'SS_VERIFY_DATE', 'SS_UPDATE_BY', 'SS_UPDATE_DATE', 'SS_ACCT_CHARGE'], 'string', 'max' => 30],
            [['SS_CMPY_CODE', 'SS_START_DATE', 'SS_END_DATE', 'SS_SALARY_TYPE', 'SS_EPF_STATUS', 'SS_EPF_METHOD', 'SS_TAX_STATUS', 'SS_TAX_CATEGORY', 'SS_ZAKAT_CODE', 'SS_TAX_FORMULA', 'SS_SALARY_STATUS'], 'string', 'max' => 10],
            [['SS_ZAKAT_STATUS', 'SS_SOCSO_STATUS', 'SS_PENSION_STATUS'], 'string', 'max' => 1],
            [['SS_CHANGE_REASON'], 'string', 'max' => 4000],
            [['SS_REF_CODE'], 'unique'],
            [['SS_START_DATE', 'SS_SALARY_TYPE', 'SS_CHANGE_REASON'], 'required', 'message' => Yii::t('app', 'Wajib Diisi')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SS_REF_CODE' => 'Ss Ref Code',
            'SS_STAFF_ID' => 'Ss Staff ID',
            'SS_CMPY_CODE' => 'Ss Cmpy Code',
            'SS_START_DATE' => 'Ss Start Date',
            'SS_END_DATE' => 'Ss End Date',
            'SS_SALARY_TYPE' => 'Ss Salary Type',
            'SS_BASIC_SALARY' => 'Ss Basic Salary',
            'SS_RATE' => 'Ss Rate',
            'SS_EPF_STATUS' => 'Ss Epf Status',
            'SS_EPF_TYPE' => 'Ss Epf Type',
            'SS_EPF_METHOD' => 'Ss Epf Method',
            'SS_EPF_EMPYER_PCT' => 'Ss Epf Empyer Pct',
            'SS_EPF_EMPYEE_PCT' => 'Ss Epf Empyee Pct',
            'SS_TAX_STATUS' => 'Ss Tax Status',
            'SS_TAX_CATEGORY' => 'Ss Tax Category',
            'SS_ZAKAT_STATUS' => 'Ss Zakat Status',
            'SS_ZAKAT_CODE' => 'Ss Zakat Code',
            'SS_SOCSO_STATUS' => 'Ss Socso Status',
            'SS_SOCSO_TYPE' => 'Ss Socso Type',
            'SS_ENTER_BY' => 'Ss Enter By',
            'SS_ENTER_DATE' => 'Ss Enter Date',
            'SS_VERIFY_BY' => 'Ss Verify By',
            'SS_VERIFY_DATE' => 'Ss Verify Date',
            'SS_UPDATE_BY' => 'Ss Update By',
            'SS_UPDATE_DATE' => 'Ss Update Date',
            'SS_CHANGE_REASON' => 'Ss Change Reason',
            'SS_TAX_FORMULA' => 'Ss Tax Formula',
            'SS_NUM_DEPENDENT' => 'Ss Num Dependent',
            'SS_SALARY_STATUS' => 'Ss Salary Status',
            'SS_PENSION_STATUS' => 'Ss Pension Status',
            'SS_ACCT_CHARGE' => 'Ss Acct Charge',
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
    public function getTarikhMula() {
        return  $this->getTarikh($this->SS_START_DATE);
    }
     public function getTarikhTamat() {
        return  $this->getTarikh($this->SS_END_DATE);
    }
    
    public function getJenisKwsp(){
        return $this->hasOne(RefEpfType::className(), ['ET_CODE' => 'SS_EPF_TYPE']);
    }
    
    public function getJenisPerkeso(){
        return $this->hasOne(RefSocsoType::className(), ['ST_CODE' => 'SS_SOCSO_TYPE']);
    }
    
       public function getFormulaCukai(){
        return $this->hasOne(RefTaxFormulaType::className(), ['TFT_FORMULA_TYPE_CODE' => 'SS_TAX_FORMULA']);
    }
    
      public function getKategoriCukai(){
        return $this->hasOne(RefTaxCategory::className(), ['TC_CATEGORY_CODE' => 'SS_TAX_CATEGORY']);
    }
    
   public function getStatusGaji() {
         if ($this->SS_SALARY_STATUS == 'Y') {
            return '<span class="label label-success">&#10004</span>';
        }
        if ($this->SS_SALARY_STATUS == 'N') {
            return '<span class="label label-danger">&#10006</span>';
        }
      
    } 
    
      public function getKwsp() {
         if ($this->SS_EPF_STATUS == 'Y') {
            return '<span class="label label-success">&#10004</span>';
        }
        if ($this->SS_EPF_STATUS == 'N') {
            return '<span class="label label-danger">&#10006</span>';
        }
      
    }
        
         public function getPerkeso() {
         if ($this->SS_SOCSO_STATUS == 'Y') {
            return '<span class="label label-success">&#10004</span>';
        }
        if ($this->SS_SOCSO_STATUS == 'N') {
            return '<span class="label label-danger">&#10006</span>';
        }
      
    }
    
      public function getCukai() {
         if ($this->SS_TAX_STATUS == 'Y') {
            return '<span class="label label-success">&#10004</span>';
        }
        if ($this->SS_TAX_STATUS == 'N') {
            return '<span class="label label-danger">&#10006</span>';
        }
      
    }
    
      public function getPencen() {
         if ($this->SS_PENSION_STATUS == 'Y') {
            return '<span class="label label-success">&#10004</span>';
        }
        if ($this->SS_PENSION_STATUS == 'N') {
            return '<span class="label label-danger">&#10006</span>';
        }
      
    }
    
     //log for Create, update or delete data.
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['id' => $this->id]);
        $attrib = $this->activeAttributes();

        switch ($insert) {
            case (false):
                $activity = 1;
                for ($i = 0; $i < count($attrib); $i++) {

                    if ($tempObj->{$attrib[$i]} != $this->{$attrib[$i]}) {
                        array_push($changes, [$attrib[$i], $tempObj->{$attrib[$i]}, $this->{$attrib[$i]}]);
                    }
                }

                break;

            default:
                //aftersave will handle it
                break;
        }
        if (count($changes) > 0) {
            //log activity to updatestatus table
            $log = new Updatestatus();
            $log->usern = $tempObj->ICNO;//Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getUserHost() ? Yii::$app->request->getUserHost() : Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId();
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);
            
                //save to tbl_stat
                $stat = Tblstat::find()->where(['ICNO' => $this->ICNO, 'table' => $this->tableName(), 'idval' => $this->id])->one();
                if ($stat == null) {
                    $stat = new Tblstat();
                    $stat->ICNO = $this->ICNO;
                    $stat->table = $this->tableName();
                    $stat->idval = $this->id;
                }
                $stat->status = 1;
                $stat->date_submit = date('Y-m-d H:i:s');
                $stat->save(false);
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            //save to tbl_stat
            $stat = new Tblstat();
            $stat->ICNO = $this->ICNO;
            $stat->table = $this->tableName();
            $stat->idval = $this->id;
            $stat->status = 0;
            $stat->date_submit = date('Y-m-d H:i:s');
            $stat->save(false);

            $changes = [];
            //$tempObj = self::findOne(['id' => $this->id]);
            $attrib = $this->activeAttributes();
            $activity = 0;

            for ($i = 0; $i < count($attrib); $i++) {
                array_push($changes, [$attrib[$i], $this->{$attrib[$i]}]);
            }

            $log = new Updatestatus();
            $log->usern = $this->ICNO; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId();
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);
        }

        return true;
    }

    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }

        $changes = [];

        //get list of attributes
        $attrib = $this->activeAttributes();

        for ($i = 0; $i < count($attrib); $i++) {
            array_push($changes, array($attrib[$i], $this->{$attrib[$i]}));
        }
        //log activity to updatestatus table
        $log = new Updatestatus();
        $log->usern = $this->ICNO;
        $log->COTableName = $this->tableName();
        $log->COActivity = 2;
        $log->COUpadteDate = date('Y-m-d H:i:s');
        $log->COUpdateIP = Yii::$app->request->getRemoteIP();
        $log->COUpdateComp = Yii::$app->request->getRemoteIP();
        $log->COUpdateCompUser = Yii::$app->user->getId();
        $log->COUpdateSQL = serialize($changes);
        $log->save(false);
        $stat = Tblstat::find()->where(['ICNO' => $this->ICNO, 'table' => $this->tableName(), 'idval' => $this->id])->one();
        if ($stat == null)
            return true;

        $stat->delete();

        return true;
    }
}
