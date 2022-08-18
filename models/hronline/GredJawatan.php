<?php

namespace app\models\hronline;

use Yii;
use app\models\lppums\RefLppJenis;
use app\models\hronline\Kumpulankhidmat;
use app\models\myidp\RefCpdGroupGredJawatan;
use app\models\myidp\RptStatistikIdp;
use app\models\myidp\RptStatistikIdpV2;
use yii\data\ActiveDataProvider;
use app\models\hronline\LogActivity;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "hronline.gredJawatan".
 *
 * @property int $id
 * @property int $sbpa_id
 * @property string $nama
 * @property string $gred
 * @property string $fname
 * @property string $mymohesCd
 * @property string $short_desc
 * @property int $job_category
 * @property int $job_group kumpkhidmat
 * @property int $cpd_group idp.v_idp_kumpulan
 * @property string $SchmOfServCd
 * @property string $SalGrdId
 * @property int $gred_status
 * @property string $gred_skim
 * @property string $gred_no
 * @property string $idMM
 * @property int $isActive
 * @property int $isKhas
 * @property string $titleMM
 */
class GredJawatan extends \yii\db\ActiveRecord {

    public $_totalCount;

    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hronline.gredjawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['sbpa_id', 'job_category', 'job_group', 'cpd_group', 'gred_status', 'isActive', 'isKhas'], 'integer'],
                [['nama', 'fname', 'short_desc'], 'string', 'max' => 255],
                [['gred', 'mymohesCd'], 'string', 'max' => 10],
                [['SchmOfServCd'], 'string', 'max' => 30],
                [['SalGrdId', 'gred_skim'], 'string', 'max' => 5],
                [['gred_no'], 'string', 'max' => 3],
                [['idMM'], 'string', 'max' => 20],
                [['titleMM'], 'string', 'max' => 2],
                [['fname'],'unique','message'=>'Gred Jawatan sudah wujud.'],
                [['nama', 'fname','gred_no','gred_skim','job_group', 'job_category'],'required', 'message'=>'Ruang ini adalah mandatori.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'sbpa_id' => 'Sbpa ID',
            'nama' => 'Jawatan',
            'gred' => 'Gred',
            'fname' => 'Gred / Position',
            'mymohesCd' => 'Mymohes Cd',
            'short_desc' => 'Short Desc',
            'job_category' => 'Job Category',
            'job_group' => 'Job Group',
            'cpd_group' => 'Cpd Group',
            'SchmOfServCd' => 'Schm Of Serv Cd',
            'SalGrdId' => 'Sal Grd ID',
            'gred_status' => 'Gred Status',
            'gred_skim' => 'Gred Skim',
            'gred_no' => 'Gred No',
            'idMM' => 'Id Mm',
            'isActive' => 'Is Active',
            'isKhas' => 'Is Khas',
            'titleMM' => 'Title Mm',
            'shortCat' => 'Kategori',
        ];
    }

    
    public function getBiodata() {
        return $this->hasMany(Tblprcobiodata::className(), ['gredJawatan' => 'id']);
    }
    public function getBio($p = null) {
        return $this->hasMany(Tblprcobiodata::className(), ['gredJawatan' => 'id'])->andOnCondition(['statLantikan'=>$p]);
    }

    public function getR_jadual_gaji() {
        return $this->hasOne(JadualGaji::className(), ['r_jg_id' => 'id']);
    }
    
    public function getLppJenis() {
        return $this->hasOne(RefLppJenis::className(), ['lpp_jenis_id' => 'job_group']);
    }
    
     public function getSkimPerkhidmatan() {
        return $this->hasOne(Kumpulankhidmat::className(), ['id'=>'job_group']);
    }
    
    public function getGroupidp() {
        return $this->hasOne(RefCpdGroupGredJawatan::className(), ['gred' => 'gred']);
    }

    public function getShortCat() {
        if($this->job_category == 1){
            return 'AKAD'; //untuk akademik
        }

        if($this->job_category == 2){
            return 'PEN'; //untuk pentadbiran
        }

    }
    
    public function getNamaenglish() {
        switch ($this->nama) {
            case "Felo Siswazah":
                return "Graduate Fellow";
            case "Felo":
                return "Fellow";
            case "Felo Kanan":
                return "Senior Fellow";
            case "Felo Utama":
                return "Distinguished Fellow";
            case "Guru Bahasa":
                return "Language Teacher";
            case "Pensyarah":
                return "Lecturer";
            case "Pensyarah Kanan":
                return "Senior Lecturer";
            case "Profesor Madya":
                return "Associate Professor";
            case "Profesor":
                return "Professor";
            case "Pensyarah Perubatan Pelatih":
                return "Trainee Medical Lecturer";
            case "Pensyarah Kanan Perubatan":
                return "Senior Lecturer (Medical)";
            case "Profesor Madya Perubatan":
                return "Associate Professor (Medical)";
            case "Profesor Perubatan":
                return "Professor (Medical)";
            case "Profesor Adjung":
                return "Adjunct Professor";
            case "Profesor Pelawat":
                return "Visiting Professor";
            case "Penilai Luar":
                return "External Assessor";
            default:
                return $this->nama;
        }
    }
    
     public function getTugas() {
        return $this->hasMany(\app\models\ejobs\TugasJawatan::className(), ['jawatan_id' => 'id']);
    }
    
    public function getKelayakan() {
        return $this->hasMany(\app\models\ejobs\Kelayakan::className(), ['jawatan_id' => 'id']);
    }
    
    public function countStaffByScheme($scheme, $jobgroup) {
        
        $count = 0;
        
        if ($jobgroup == 1){ //pelaksana
            
//            $count = Tblprcobiodata::find()
//                    ->joinWith('jawatan') 
//                    ->where(['gred_skim' => $scheme, 'job_group' => '5'])
//                    ->orWhere(['gred_skim' => $scheme, 'job_group' => '6'])
//                    ->andWhere(['Status' => '1', 'isKhas' => '0'])
//                    ->andWhere(['<>', 'statLantikan', '2'])
//                    ->count();
            
            $count = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['gred_skim' => $scheme, 'job_group' => '5'])
                    ->orWhere(['gred_skim' => $scheme, 'job_group' => '6'])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                    ->count();
            
        } elseif ($jobgroup == 2) { //p&p pentadbiran
            
//            $count = Tblprcobiodata::find()
//                    ->joinWith('jawatan')
//                    ->where(['gred_skim' => $scheme, 'job_group' => '4'])
//                    ->andWhere(['Status' => '1', 'isKhas' => '0'])
//                    ->andWhere(['<>', 'statLantikan', '2'])
//                    ->count();
            
            $count = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['gred_skim' => $scheme, 'job_group' => '4', 'staf_status' => '1', 'statusIDP' => '1'])
                    ->orWhere(['gred_skim' => $scheme, 'job_group' => '1', 'staf_status' => '1', 'statusIDP' => '1', 'job_category' => '2'])
                    ->count();
            
        } elseif ($jobgroup == 3) { //
            
//            $count = Tblprcobiodata::find()
//                    ->joinWith('jawatan')
//                    ->where(['gred_skim' => $scheme, 'job_category' => '1', 'tblprcobiodata.Status' => '1', 'isKhas' => '0', 'statLantikan' => '1'])
//                    ->orWhere(['gred_skim' => $scheme, 'job_category' => '1', 'tblprcobiodata.Status' => '1', 'isKhas' => '0', 'statLantikan' => '2'])
//                    ->orWhere(['gred_skim' => $scheme, 'job_category' => '1', 'tblprcobiodata.Status' => '1', 'isKhas' => '0', 'statLantikan' => '3'])
//                    ->count();
            
            $count = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['gred_skim' => $scheme, 'job_category' => '1'])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                    ->count();
            
        } 
        
        return $count;
        
    }
    
    public function getStaffByScheme($scheme, $jobgroup) {
        
        if ($jobgroup == 1){ //pelaksana
            
            $model = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['gred_skim' => $scheme, 'job_group' => '5'])
                    ->orWhere(['gred_skim' => $scheme, 'job_group' => '6'])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1']);
            
        } elseif ($jobgroup == 2) { //p&p pentadbiran
            
            $model = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['gred_skim' => $scheme, 'job_group' => '4', 'staf_status' => '1', 'statusIDP' => '1'])
                    ->orWhere(['gred_skim' => $scheme, 'job_group' => '1', 'staf_status' => '1', 'statusIDP' => '1', 'job_category' => '2']);
            
        } elseif ($jobgroup == 3) { //
            
            $model = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['gred_skim' => $scheme, 'job_category' => '1'])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1']);
            
        } 
        
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
        ]);

        return $dataProvider;
        
    }

    
    public function getLongCat() {
        if($this->job_category == 1){
            return 'Akademik'; //untuk akademik
        }

        if($this->job_category == 2){
            return 'Pentadbiran'; //untuk pentadbiran
        }
    }

    public function TotalServStatus($id,$k = null, $s = null, $p = null){
        if(!$this->biodata){
            return 0;
        }
        $_total = 0;
        if($k!=null){
            $this->find()->andWhere(['job_category'=>$k]);
        }
        if($s!=null){
            $this->find()->andWhere(['job_group'=>$s]);
        }
        
        
        foreach ($this->getBio($p)->all() as $b) {
            if($b->serviceStatus){
                if($b->serviceStatus->ServStatusCd == $id){
                    $_total = $_total + 1;
                }
            }
        }
        return $_total;
    }

    public function NamaJawatan($icno){
        if($this->id == '407' && $icno == '800709125093'){  //Md Sazali Md Salleh @ Ketua Pustakawan
            return $this->nama;
        }
        return $this->nama . " (" . $this->gred . ")";
    }

    //log for Create, update or delete data.
    // public function beforeSave1($insert)
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
            $log = new LogActivity();
            $log->usern = yii::$app->controller->id; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            if (Yii::$app->user->getId()) {
                $log->COUpdateIP = Yii::$app->request->getRemoteIP();
                $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            } else {
                $log->COUpdateIP = yii::$app->controller->id;
                $log->COUpdateComp = yii::$app->controller->id;
            }
            $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : yii::$app->controller->id;
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);

        }

        return true;
    }

    // public function afterSave1($insert, $changedAttributes)
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {

            $changes = [];
            //$tempObj = self::findOne(['id' => $this->id]);
            $attrib = $this->activeAttributes();
            $activity = 0;

            for ($i = 0; $i < count($attrib); $i++) {
                array_push($changes, [$attrib[$i], $this->{$attrib[$i]}]);
            }

            $log = new LogActivity();
            $log->usern = yii::$app->controller->id; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            if (Yii::$app->user->getId()) {
                $log->COUpdateIP = Yii::$app->request->getRemoteIP();
                $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            } else {
                $log->COUpdateIP = yii::$app->controller->id;
                $log->COUpdateComp = yii::$app->controller->id;
            }
            $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : yii::$app->controller->id;
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);
            
        }

        return true;
    }

    // public function beforeDelete1()
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
        $log = new LogActivity();
        $log->usern = yii::$app->controller->id;
        $log->COTableName = $this->tableName();
        $log->COActivity = 2;
        $log->COUpadteDate = date('Y-m-d H:i:s');
        if (Yii::$app->user->getId()) {
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
        } else {
            $log->COUpdateIP = yii::$app->controller->id;
            $log->COUpdateComp = yii::$app->controller->id;
        }
        $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : yii::$app->controller->id;
        $log->COUpdateSQL = serialize($changes);
        $log->idval = $this->id;
        $log->save(false);

        return true;
    }
}
