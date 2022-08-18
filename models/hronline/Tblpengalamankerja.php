<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\SektorPekerjaan;
use app\models\hronline\JenisBadanMajikan;
//audit trail
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;

/**
 * This is the model class for table "hronline.tblprprevemp".
 *
 * @property string $ICNO
 * @property string $OrgNm
 * @property string $OccSectorCd
 * @property string $CorpBodyTypeCd
 * @property string $PrevEmpRemarks
 * @property string $PrevEmpStartDt
 * @property string $PrevEmpEndDt
 * @property int $id
 */
class Tblpengalamankerja extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tblprprevemp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO','OccSectorCd', 'CorpBodyTypeCd', 'OrgNm', 'PrevEmpRemarks','Position','OccCategoryCd','PositionStatusCd','WithServices'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['PrevEmpStartDt', 'PrevEmpEndDt'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['OrgNm'], 'string', 'max' => 80],
            [['Position'],'string','max'=>50],
            [['WithServices'],'integer','max'=>true],
            [['OccSectorCd', 'CorpBodyTypeCd'], 'string', 'max' => 2],
            [['PrevEmpRemarks'], 'string', 'max' => 300],
            [[ 'OrgNm', 'PrevEmpStartDt','ICNO'], 'unique', 'targetAttribute' => ['OrgNm', 'PrevEmpStartDt','ICNO']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'OrgNm' => 'Org Nm',
            'OccSectorCd' => 'Occ Sector Cd',
            'CorpBodyTypeCd' => 'Corp Body Type Cd',
            'PrevEmpRemarks' => 'Prev Emp Remarks',
            'PrevEmpStartDt' => 'Prev Emp Start Dt',
            'PrevEmpEndDt' => 'Prev Emp End Dt',
            'id' => 'ID',
        ];
    }
    
    public function getSektorPekerjaan() {
        return $this->hasOne(SektorPekerjaan::className(), ['OccSectorCd'=>'OccSectorCd']);
    }
    
    public function getJenisBadanMajikan() {
        return $this->hasOne(JenisBadanMajikan::className(), ['CorpBodyTypeCd'=>'CorpBodyTypeCd']);
    }
    
    public function getSekpekerjaan() {
        if($this->sektorPekerjaan){
            return $this->sektorPekerjaan->OccSector;
        }
        return '-';
    }
    
    public function getJenmajikan() {
        if($this->jenisBadanMajikan){
            return $this->jenisBadanMajikan->CorpBodyType;
        }
        return '-';
    }
    
    public function getJawatan() {
        if($this->Position){
            return $this->Position;
        }
        return '-';
    }

    public function getBawServis(){
        if (is_null($this->WithServices)) {
            return '-';
        }
        if ($this->WithServices) {
            return 'Ya';
        }elseif($this->WithServices == 0){
            return 'Tidak';
        }
        
    }
    
    public function getKatPekerjaan() {
        if($this->OccCategoryCd){
            $model = KategoriPekerjaan::find()->where(['OccCatCd'=>$this->OccCategoryCd])->one();
            return $model->OccCat;
        }
        return '-';
    }

    public function getStaJawatan() {
        if($this->PositionStatusCd){
            $model = StatusJawatan::find()->where(['StatusCd'=>$this->PositionStatusCd])->one();
            return $model->PosStatus;
        }
        return '-';
    }
    
    public function getPrevEmpStartDt() {
        return Yii::$app->MP->Tarikh($this->PrevEmpStartDt);
    }
    
    public function getPrevEmpEndDt() {
        return Yii::$app->MP->Tarikh($this->PrevEmpEndDt);
    }
    
    public function getTarikhDilantik() {
        return  Yii::$app->MP->Tarikh($this->PrevEmpStartDt);
    }
    
    //log for Create, update or delete data.
    public function beforeSave($insert)
    {   
        if(!parent::beforeSave($insert)){
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['id'=>$this->id]);
        $attrib = $this->activeAttributes();

        switch ($insert) {
            case (false):
                $activity = 1;
                for($i=0;$i<count($attrib);$i++){

                    if($tempObj->{$attrib[$i]}!=$this->{$attrib[$i]}){
                        array_push($changes,[$attrib[$i],$tempObj->{$attrib[$i]},$this->{$attrib[$i]}]);   
                    }
           
                }
                break;
            
            default:
                //aftersave will handle it
                break;
        }
        if(count($changes)>0)
        {   
            //log activity to updatestatus table
            $log = new Updatestatus();
            $log->usern = $tempObj->ICNO;//Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId();
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);

                //save to tbl_stat
                $stat = Tblstat::find()->where(['ICNO'=>$this->ICNO,'table'=>$this->tableName(),'idval'=>$this->id])->one();
                if($stat==null)
                {
                    $stat = new Tblstat();
                    $stat->ICNO = $this->ICNO;
                    $stat->table = $this->tableName();
                    $stat->idval = $this->id;
                }
                $stat->status = 1;
                $stat->date_submit = date('Y-m-d H:i:s');
                $stat->save(false);

                Yii::$app->MP->BiodataLastUpdate($this->ICNO);
        }

        return true;
        
    }
    
    public function afterSave($insert, $changedAttributes)
    {
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

            Yii::$app->MP->BiodataLastUpdate($this->ICNO);
        }
        return true;
    }

    public function beforeDelete()
    {   
        if (!parent::beforeDelete()) {
            return false;
        }

        $changes = []; 
     
        //get list of attributes
        $attrib = $this->activeAttributes();
        
        for($i=0;$i<count($attrib);$i++)
        {
            array_push($changes,array($attrib[$i],$this->{$attrib[$i]}));
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
        $stat = Tblstat::find()->where(['ICNO'=>$this->ICNO, 'table'=>$this->tableName(),'idval'=>$this->id])->one();
        if($stat == null)
            return true;
            
        $stat->delete();
        
        return true;
    }

    public function afterDelete(){
        
        //--biodata last update--//
        Yii::$app->MP->BiodataLastUpdate($this->ICNO);

        parent::afterDelete();
    }
}
