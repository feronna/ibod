<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\Anugerah;
use app\models\hronline\KategoriAnugerah;
use app\models\hronline\Gelaran;
use app\models\hronline\DianugerahkanOleh;
use app\models\hronline\Negeri;
use app\models\hronline\Negara;
//audit trail
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;


/**
 * This is the model class for table "hronline.tblprawd".
 *
 * @property int $awdId 
 * @property string $ICNO
 * @property string $AwdCd
 * @property string $TitleCd
 * @property string $CfdByCd
 * @property string $AwdCatCd
 * @property string $StateCd
 * @property string $AwdCfdDt
 * @property string $AwdAbbr
 * @property string $AwdReason
 * @property string $AwdStatus
 * @property string $CountryCd
 */
class Tblanugerah extends \yii\db\ActiveRecord
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
        return 'hronline.tblprawd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'AwdCfdDt', 'AwdCd', 'TitleCd', 'CountryCd', 'AwdCatCd', 'StateCd', 'AwdStatus', 'AwdReason', 'CfdByCd'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['AwdCfdDt'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['AwdCd'], 'string', 'max' => 7],
            [['TitleCd', 'CfdByCd'], 'string', 'max' => 4],
            [['AwdCatCd', 'StateCd', 'AwdStatus'], 'string', 'max' => 2],
            [['AwdAbbr'], 'string', 'max' => 10],
            [['AwdReason'], 'string', 'max' => 300],
            [['CountryCd'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'awdId' => 'Awd ID',
            'ICNO' => 'Icno',
            'AwdCd' => 'Awd Cd',
            'TitleCd' => 'Title Cd',
            'CfdByCd' => 'Cfd By Cd',
            'AwdCatCd' => 'Awd Cat Cd',
            'StateCd' => 'State Cd',
            'AwdCfdDt' => 'Awd Cfd Dt',
            'AwdAbbr' => 'Awd Abbr',
            'AwdReason' => 'Awd Reason',
            'AwdStatus' => 'Awd Status',
            'CountryCd' => 'Country Cd',
        ];
    }
    
        public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
    
    public function getNamaAnugerah() {
        return $this->hasOne(Anugerah::className(), ['AwdCd' => 'AwdCd']);
    }
    
    public function getNamanugerah() {
        if($this->namaAnugerah){
            return $this->namaAnugerah->Awd;
        }
        return '-';
    }
    
    public function getKategoriAnugerah() {
        return $this->hasOne(KategoriAnugerah::className(), ['AwdCatCd' => 'AwdCatCd']);
    }
    public function getKatanugerah() {
        if($this->kategoriAnugerah){
            return $this->kategoriAnugerah->AwdCat;
        }
        return '-';
    }
    
    public function getDianugerahkanOleh() {
        return $this->hasOne(DianugerahkanOleh::className(), ['CfdByCd' => 'CfdByCd']);
    }
    public function getDiaoleh() {
        if($this->dianugerahkanOleh){
            return $this->dianugerahkanOleh->CfdBy;
        }
        return '-';
    }
    
    public function getGelaran() {     
        return $this->hasOne(Gelaran::className(), ['TitleCd' => 'TitleCd']);   
    }
    public function getGel() {
        if($this->gelaran){
            return $this->gelaran->Title;
        }
        return '-';
    }
    
    public function getNegara() {
        return $this->hasOne(Negara::className(), ['CountryCd' => 'CountryCd']);
    }
    public function getNega() {
        if($this->negara){
            return $this->negara->Country;
        }
        return '-';
    }
    public function getNegeri() {
        return $this->hasOne(Negeri::className(), ['StateCd' => 'StateCd']);
    }
    public function getNege() {
        if($this->negeri){
            return $this->negeri->State;
        }
        return '-';
    }
    public function getAwdCfdDt() {
        return Yii::$app->MP->Tarikh($this->AwdCfdDt);
    }
    public function getStatus() {
        if($this->AwdStatus){
            return 'Aktif';
        }
        return 'Tidak Aktif';
    }
    
    //log for Create, update or delete data.
    public function beforeSave($insert)
    {   
        if(!parent::beforeSave($insert)){
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['awdId'=>$this->awdId]);
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
            $log->idval = $this->awdId;
            $log->save(false);

                //save to tbl_stat
                $stat = Tblstat::find()->where(['ICNO'=>$this->ICNO,'table'=>$this->tableName(),'idval'=>$this->awdId])->one();
                if($stat==null)
                {
                    $stat = new Tblstat();
                    $stat->ICNO = $this->ICNO;
                    $stat->table = $this->tableName();
                    $stat->idval = $this->awdId;
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
            $stat->idval = $this->awdId;
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
            $log->idval = $this->awdId;
            $log->save(false);

            //--biodata last update--//
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
        $stat = Tblstat::find()->where(['ICNO'=>$this->ICNO, 'table'=>$this->tableName(),'idval'=>$this->awdId])->one();
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
