<?php

namespace app\models\hronline;

use Yii;
use yii\helpers\Html;
use app\models\hronline\log_vaksinasi;
use DateTime;
use DateInterval;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "hronline.tblstatusvaksinasi".
 *
 * @property int $id
 * @property string $icno
 * @property int $status_vaksin
 * @property int $terima_dos1
 * @property int $terima_dos2
 * @property int $sebab_belum_terima
 * @property string $catatan
 * @property string $sijil_digital
 */
class Tblstatusvaksinasi extends \yii\db\ActiveRecord
{
    public $file;
    public $lampiran_;
    
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    
    public static function tableName()
    {
        return 'hronline.tblstatusvaksinasi';
    }

    
    public function rules()
    {
        return [
            // [['status_vaksin','terima_dos1', 'terima_dos2'] ,'required', 'message'=>'Ruangan ini adalah mandatori'],
            [['status_vaksin','terima_dos1', 'terima_dos2'] ,'required', 'message'=>'Ruangan ini adalah mandatori', 'on'=>'sudah_terima'],
            [['status_vaksin','sebab_belum_terima','catatan'] ,'required', 'message'=>'Ruangan ini adalah mandatori', 'on'=>'reject'],
            [['status_vaksin','terima_dos1','terima_dos2'] ,'required', 'message'=>'Ruangan ini adalah mandatori', 'on'=>'accept'],
            [['status_vaksin','sebab_belum_terima'] ,'required', 'message'=>'Ruangan ini adalah mandatori', 'on'=>'belum_terima'],
            [['status_vaksin', 'terima_dos1', 'terima_dos2', 'sebab_belum_terima'], 'integer'],
            [['catatan'], 'string'],
            [['icno'], 'string', 'max' => 15],
            [['sijil_digital','lampiran'], 'string', 'max' => 255],
            [['file','lampiran'], 'file','extensions'=>['pdf','jpg','png','jpeg'] , 'maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'],
            [['file','lampiran'], 'safe'],
            [['terima_penggalak'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'status_vaksin' => 'Status Vaksin',
            'terima_dos1' => 'Terima Dos1',
            'terima_dos2' => 'Terima Dos2',
            'terima_penggalak' => 'Terima Penggalak',
            'sebab_belum_terima' => 'Sebab Belum Terima',
            'catatan' => 'Cacatan',
            'sijil_digital' => 'Sijil Digital',
        ];
    }

    public function getBiodata()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getDos()
    {
        return $this->hasMany(Tblpenerimavaksin::className(), ['icno' => 'icno'])->andWhere(['or',['bil_dos'=>2],['bil_dos'=>1]]);
    }
    public function getDos1()
    {
        return $this->hasOne(Tblpenerimavaksin::className(), ['icno' => 'icno'])->andWhere(['bil_dos'=>1]);
    }
    public function getDos2()
    {
        return $this->hasOne(Tblpenerimavaksin::className(), ['icno' => 'icno'])->andWhere(['bil_dos'=>2]);
    }
    public function getDisplayLink() {
        if(!empty($this->sijil_digital) && $this->sijil_digital != 'deleted'){
        return html::a(Yii::$app->FileManager->NameFile($this->sijil_digital), Yii::$app->FileManager->DisplayFile($this->sijil_digital), ['target'=>'_blank']);
        }
        return 'Sila muatnaik Sijil Digital vaksinasi anda.';
    }
    public function getDisplayLinkLampiran() {
        if(!empty($this->lampiran)){
        return html::a(Yii::$app->FileManager->NameFile($this->lampiran), Yii::$app->FileManager->DisplayFile($this->lampiran), ['target'=>'_blank']);
        }
        return '<span class="label label-warning" style="font-size:11px">Sila kemukakan dokumen/surat sokongan daripada doktor berkaitan pengambilan vaksin Covid-19.</span>';
    }
    

    public static function isRegistered($icno){
        if(Tblstatusvaksinasi::find()->where(['icno'=>$icno])->exists()){
            return 1;
        }
        return 0;
    }

    public static function isFullVaccinated($icno){
        if(($model = self::findStatusVaksin($icno, 'required')) !== null){
            if($model->status_vaksin == 1){
                if($model->terima_dos1 == 1 && $model->dos1){
                    //one dos only for sanSino//
                    if($model->dos1->jenis_vaksin == 7){
                        return true;
                    }
                    //
                    else if($model->terima_dos2 && $model->dos2){
                        return true;
                    }
                    return false;    
                }
                return false;
            }
            return false;
            
        }
    }

    public static function isEligibleBooster($icno){
        $eligible = false;
        if(!self::isFullVaccinated($icno)){
            return '0';
        }
        $vaksin = Tblstatusvaksinasi::find()->where(['icno'=>$icno])->one();
        if($vaksin->dos2){
            $date = $vaksin->dos2->tarikh_vaksin;
            $date = strtotime($date);
            $date = date('Y-m-d', $date);
            $date = new DateTime($date);
            switch ($vaksin->dos2->jenis_vaksin) {
                case '3':
                    $date->add(new DateInterval('P3M'));
                    $date = $date->format('Y-m-d');
                    if($date < date('Y-m-d')){
                        $eligible = true;
                    }
                    break;
                case '4':
                    $date->add(new DateInterval('P6M'));
                    $date = $date->format('Y-m-d');
                    if($date < date('Y-m-d')){
                        $eligible = true;
                    }
                    break;
                default:
                    $eligible = false;
                    break;
            }
        }

        return $eligible;

    }

    private static function findStatusVaksin($icno,$modelnotempty = null){
        if(($model = Tblstatusvaksinasi::find()->where(['icno'=>$icno])->one()) !== null){
            return $model;
        }

        if($modelnotempty == 'required'){
            return $model;
        }

        throw new NotFoundHttpException('Staf tidak wujud dalam data vaksinasi.');
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
            $log = new log_vaksinasi();
            $log->usern = $tempObj->icno;
            $log->TableName = $this->tableName();
            $log->Activity = $activity;
            $log->UpdateDate = date('Y-m-d H:i:s');
            $log->UpdateIP = Yii::$app->request->getRemoteIP();
            $log->UpdateComp = Yii::$app->request->getRemoteIP();
            $log->UpdateCompUser = Yii::$app->user->getId(); //login account
            $log->UpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);
        }

        return true;
        
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {

            $changes = [];
            $attrib = $this->activeAttributes();
            $activity = 0;
            for ($i = 0; $i < count($attrib); $i++) {
                array_push($changes, [$attrib[$i], $this->{$attrib[$i]}]);
            }

            $log = new log_vaksinasi();
            $log->usern = $this->icno;
            $log->TableName = $this->tableName();
            $log->Activity = $activity;
            $log->UpdateDate = date('Y-m-d H:i:s');
            $log->UpdateIP = Yii::$app->request->getRemoteIP();
            $log->UpdateComp = Yii::$app->request->getRemoteIP();
            $log->UpdateCompUser = Yii::$app->user->getId();
            $log->UpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);
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
        $log = new log_vaksinasi();
        $log->usern = $this->icno;
        $log->TableName = $this->tableName();
        $log->Activity = 2;
        $log->UpdateDate = date('Y-m-d H:i:s');
        $log->UpdateIP = Yii::$app->request->getRemoteIP();        
        $log->UpdateComp = Yii::$app->request->getRemoteIP();
        $log->UpdateCompUser = Yii::$app->user->getId();
        $log->UpdateSQL = serialize($changes);
        $log->save(false);
        
        return true;
    }

    public function afterDelete(){
        parent::afterDelete();
    }
}
