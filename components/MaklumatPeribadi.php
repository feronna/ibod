<?php 
namespace app\components;


use Yii;
use yii\base\Component;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\hronline\Flag;
use app\models\hronline\GredJawatan;
use app\models\hronline\Jawatankategori;
use app\models\hronline\Kumpulankhidmat;
use app\models\hronline\ServiceStatus;
use app\models\hronline\StatusLantikan;
use app\models\hronline\Tblapproval;
use app\models\hronline\TblAdminRP;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Tblbsmwatchlist;
use app\models\hronline\Tbllesen;
use app\models\hronline\TblmpMonitorReminder;
use app\models\hronline\TblPapSenaraiStaf;
use app\models\hronline\Tblpasport;
use app\models\hronline\Tblpermitkerja;
use app\models\hronline\Tblpendidikan;
use app\models\hronline\TblPenempatan;
use app\models\hronline\Tblrscoadminpost;
use app\models\hronline\Tblrscoapmtstatus;
use app\models\hronline\Tblrscoaptathy;
use app\models\hronline\Tblrscoconfirmstatus;
use app\models\hronline\Tblrscofileno;
use app\models\hronline\Tblrscoprobtnperiod;
use app\models\hronline\Tblrscopsnathy;
use app\models\hronline\Tblrscopsnstatus;
use app\models\hronline\Tblrscosalmovemth;
use app\models\hronline\Tblrscosaltype;
use app\models\hronline\Tblrscosandangan;
use app\models\hronline\Tblrscoservload;
use app\models\hronline\Tblrscoservstatus;
use app\models\hronline\Tblrscoservtype;
use app\models\hronline\Tblstatusvaksinasi;
use app\models\hronline_gaji\Tblstaffsalary;
use app\models\kehadiran\TblWp;
use app\models\keselamatan\TblStaffKeselamatan;
use app\models\klinikpanel\Tblmaxtuntutan;
use app\models\Notification;
use app\models\utilities\epos\TblAkses;
use yii\web\NotFoundHttpException;
use yii\base\Exception;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;


class MaklumatPeribadi extends Component{
    
    public $icno = ' ';
    public $deptid = ' ';

    public function getFullName($icno){
        $biodata = Tblprcobiodata::findOne(['ICNO'=>$icno]);
        return $biodata->CONm;
    }
    
    public function NatStatusCd($icno){
        $biodata = Tblprcobiodata::findOne(['ICNO'=>$icno]);
        return $biodata->NatStatusCd;
    }

    public function getPP($icno){
        $biodata = Tblprcobiodata::findOne(['ICNO'=>$icno]);
        if($biodata){
            $this->deptid = $biodata->DeptId;
        }else{
            return false;
        }

        $department = Department::findOne(['id'=>$this->deptid]);
        if(is_null($department->sub_of)){
            return $department->pp;
        }

        $department = Department::findOne(['id'=>$department->sub_of]);
        if($department->pp){
            return $department->pp;
        }
        return $department->chief;
    }

    public function getVC(){
        $model = Tblprcobiodata::find()->where(['and',['!=','status',6],['gredJawatan'=>2]])->one();
        if($model){
            return $model->ICNO;
        }
        return null;
    }

    ///tblapproval for all controllers////
    public function Approval($model, $action, $tempObj = null){

        $changes = [];
        $tblapproval = new Tblapproval();
        $attrib = $model->attributes();
        $action = strtolower($action);
        $flag = false;

        switch ($action) {
            case 'update':
                $res = $model->primaryKey();
                $tblapproval->idval = $model->{$res[0]};
                $tblapproval->activity = 1;

                for ($i = 0; $i < count($attrib); $i++) {;

                    if ($tempObj->{$attrib[$i]} != $model->{$attrib[$i]}) {
                        array_push($changes, [$attrib[$i], $tempObj->{$attrib[$i]}, $model->{$attrib[$i]}]);
                    }
                }
                
                if(count($changes) > 0){
                    $flag = true;
                }
                
                break;
            case 'delete':

                $res = $model->primaryKey();
                $tblapproval->idval = $model->{$res[0]};
                $tblapproval->activity = 2;

                for ($i = 0; $i < count($attrib); $i++) {
                    array_push($changes, [$attrib[$i], $model->{$attrib[$i]}]);
                }
                $flag = true;

                break;

            default:
                $tblapproval->activity = 0;

                for ($i = 0; $i < count($attrib); $i++) {
                    array_push($changes, [$attrib[$i], $model->{$attrib[$i]}]);
                }
                $flag = true;

                break;
        }

        $tblapproval->ICNO = $model->ICNO;
        $tblapproval->table = $model->tableName();
        $tblapproval->date_submit = date("Y-m-d H:i:s");
        $tblapproval->dataSQL = serialize($changes);
        $tblapproval->approval_status = 0;
       
        if($flag){
            if($tblapproval->save(false)){
                return ['status'=>'1', 'msg'=>'Saved.'];
            }else{
                return ['status'=>'3', 'msg'=>$tblapproval->errors];
            }
        }
        
        return ['status'=>'2', 'msg'=>'No Changes detected.'];
        
    }

    public function ApprovalKeluarga($model, $action, $objKecacatan, $tempObj = null){

        $changes = [];
        $tblapproval = new Tblapproval();
        $attrib = $model->attributes();
        $action = strtolower($action);
        $flag = false;
        
        if($objKecacatan == null){
            return ['status'=>'4', 'msg'=>'Sila lengkapkan maklumat kecacatan.'];
        }

        echo $objKecacatan->getModels;
        die;

        switch ($action) {
            case 'update':
                $res = $model->primaryKey();
                $tblapproval->idval = $model->{$res[0]};
                $tblapproval->activity = 1;

                for ($i = 0; $i < count($attrib); $i++) {;

                    if ($tempObj->{$attrib[$i]} != $model->{$attrib[$i]}) {
                        array_push($changes, [$attrib[$i], $tempObj->{$attrib[$i]}, $model->{$attrib[$i]}]);
                    }
                }
                
                if(count($changes) > 0){
                    $flag = true;
                }
                
                break;
            case 'delete':

                $res = $model->primaryKey();
                $tblapproval->idval = $model->{$res[0]};
                $tblapproval->activity = 2;

                for ($i = 0; $i < count($attrib); $i++) {
                    array_push($changes, [$attrib[$i], $model->{$attrib[$i]}]);
                }
                $flag = true;

                break;

            default:
                $tblapproval->activity = 0;

                for ($i = 0; $i < count($attrib); $i++) {
                    array_push($changes, [$attrib[$i], $model->{$attrib[$i]}]);
                }
                $flag = true;

                break;
        }

        $tblapproval->ICNO = $model->ICNO;
        $tblapproval->table = $model->tableName();
        $tblapproval->date_submit = date("Y-m-d H:i:s");
        $tblapproval->dataSQL = serialize($changes);
        $tblapproval->approval_status = 0;
       
        if($flag){
            if($tblapproval->save(false) && $objKecacatan->save()){
                return ['status'=>'1', 'msg'=>'Saved.'];
            }else{
                return ['status'=>'3', 'msg'=>$objKecacatan->errors ? $objKecacatan->errors : $objKecacatan->errors];
            }
        }
        
        return ['status'=>'2', 'msg'=>'No Changes detected.'];
        
    }

    
    public function adminRP(){
        $icno = Yii::$app->user->getId();
        $access_type = TblAdminRP::find()->where(['icno'=>$icno])->one()->access_type;
        return $access_type;
    }

    public function isPartnerUMS($id){
        switch ($id) {
            case 'myself':
                $partner = ['01','02'];
                $tblfmy = Tblkeluarga::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['IN','RelCd',$partner])->andWhere(['isUms'=>'1'])->all();
                if (!empty($tblfmy)) {
                    return true;
                }
                return false;
                // var_dump($this_gender);
                // die;
                break;
            
            default:
                return false;
                break;
        }
    }

    ////global check has valid passport////
    // global check has valid passport and working permit

    public function hasValidPasport($icno){  //return true/false, tblpaspot_id, status 1=updated;2=expired;3=notexist
        $paspot = Tblpasport::find()->where(['ICNO'=>$icno])->all();
        $valid_paspot = true;
        $status = 1;
        $this_id = null;
        $cdate = date("Y-m-d");
        switch (count($paspot)) {
            case '0':
                $valid_paspot = false;
                $status = 3;
                break;
            case '1':
                foreach ($paspot as $p) {
                    $this_id = $p->id;
                    if($cdate > $p->PassportExpiryDt){
                        $valid_paspot = false;
                        $status = 2;
                    }
                }
                break;

            default:
                $valid_paspot = false;
                foreach ($paspot as $p) {
                    $latest = $p->PassportExpiryDt;
                    $this_id = $p->id;
                    if ($p->PassportExpiryDt > $cdate) {
                        $status = 1;
                        return [true, $p->id, $status];
                    }else{
                        if($p->PassportExpiryDt >= $latest){
                            $latest = $p->PassportExpiryDt;
                            $this_id = $p->id;
                            $status = 2;
                        }
                    }
                }
                break;
        }
        return [$valid_paspot, $this_id, $status];
    }

    public function hasValidPermit($icno){  //return true/false, tblpermit_id, status 1=updated;2=expired;3=notexist
        $permit = Tblpermitkerja::find()->where(['ICNO'=>$icno])->all();
        $valid_permit = true;
        $status = 1;
        $this_id = null;
        $cdate = date("Y-m-d");
        switch (count($permit)) {
            case '0':
                $valid_permit = false;
                $status = 3;
                break;
            case '1':
                foreach ($permit as $p) {
                    $this_id = $p->id;
                    if($cdate > $p->WrkPermitExpiryDt){
                        $valid_permit = false;
                        $status = 2;
                    }
                }
                break;

            default:
                $valid_permit = false;
                foreach ($permit as $p) {
                    $latest = $p->WrkPermitExpiryDt;
                    $this_id = $p->id;
                    if ($p->WrkPermitExpiryDt > $cdate) {
                        $status = 1;
                        return [true, $p->id, $status];
                    }else{
                        if($p->WrkPermitExpiryDt >= $latest){
                            $latest = $p->WrkPermitExpiryDt;
                            $this_id = $p->id;
                            $status = 2;
                        }
                    }
                }
                break;
        }
        return [$valid_permit, $this_id, $status];
    }

    public function latestPasport($icno){
        if(($pasport = Tblpasport::find()->where(['ICNO'=>$icno])->orderBy(['PassportExpiryDt'=> SORT_DESC])->one()) !== null){
            return $pasport->id;
        }
        return null;
    }

    //-----------------------------lantikan-----------------------------------------------//

    public function RollBackLantikanBaru($icno){
        $biodata = Tblprcobiodata::findOne(['ICNO'=>$icno]);
        if(!empty($biodata)){
            $biodata->delete(false);
        }
        $sandangan = Tblrscosandangan::findOne(['ICNO'=>$icno]);
        if(!empty($sandangan)){
            $sandangan->delete(false);
        }
        $apmtstatus = Tblrscoapmtstatus::findOne(['ICNO'=>$icno]);
        if(!empty($apmtstatus)){
            $apmtstatus->delete(false);
        }
        $servstatus = Tblrscoservstatus::findOne(['ICNO'=>$icno]);
        if(!empty($servstatus)){
            $servstatus->delete(false);
        }

        // $pendidikan = Tblpendidikan::findOne(['ICNO'=>$icno]);
        // if(!empty($pendidikan)){
        //     $pendidikan->delete(false);
        // }

        $penempatan = TblPenempatan::findOne(['ICNO'=>$icno]);
        if(!empty($penempatan)){
            $penempatan->delete(false); //fail
        }
        $aptathy = Tblrscoaptathy::findOne(['ICNO'=>$icno]);
        if(!empty($aptathy)){
            $aptathy->delete(false); // fail
        }
        $servload = Tblrscoservload::findOne(['ICNO'=>$icno]);
        if(!empty($servload)){
            $servload->delete(false); //fail
        }
        $confirmstatus = Tblrscoconfirmstatus::findOne(['ICNO'=>$icno]);
        if(!empty($confirmstatus)){
            $confirmstatus->delete(false); //fail
        }
        $probtnperiod = Tblrscoprobtnperiod::findOne(['ICNO'=>$icno]);
        if(!empty($probtnperiod)){
            $probtnperiod->delete(false); //tidak masuk //fail
        }
        $psnstatus = Tblrscopsnstatus::findOne(['ICNO'=>$icno]);
        if(!empty($psnstatus)){
            $psnstatus->delete(false); //fail
        }
        $psnathy = Tblrscopsnathy::findOne(['ICNO'=>$icno]);
        if(!empty($psnathy)){
            $psnathy->delete(false); //fail
        }
        $saltype = Tblrscosaltype::findOne(['ICNO'=>$icno]);
        if(!empty($saltype)){
            $saltype->delete(false); //
        }
        $servtype = Tblrscoservtype::findOne(['ICNO'=>$icno]);
        if(!empty($servtype)){
            $servtype->delete(false); //
        }
        $salmovmth = Tblrscosalmovemth::findOne(['ICNO'=>$icno]);
        if(!empty($salmovmth)){
            $salmovmth->delete(false); //
        }
        $fileno = Tblrscofileno::findOne(['ICNO'=>$icno]);
        if(!empty($fileno)){
            $fileno->delete(false); //
        }
        $wp = TblWp::findOne(['icno'=>$icno]);
        if(!empty($wp)){
            $wp->delete(false); //no access
        }
        $keselamatan = TblStaffKeselamatan::findOne(['staff_icno'=>$icno]);
        if(!empty($keselamatan)){
            $keselamatan->delete(false);
        }
        $klinik_panel = Tblmaxtuntutan::findOne(['max_icno'=>$icno]);
        if(!empty($klinik_panel)){
            $klinik_panel->delete(false);
        }
        $papss = TblPapSenaraiStaf::findOne(['icno'=>$icno]);
        if(!empty($papss)){
            $papss->delete(false);
        }

        return 0;

    }


    //----------------------------update biodata last_update----------------------------//
    public function BiodataLastUpdate($icno){

        $model = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $model->last_update = date('Y-m-d h:i:s');
        $model->kemaskini_terakhir = date('Y-m-d h:i:s');
        $model->last_updater = Yii::$app->user->getId() ? Yii::$app->user->getId() : yii::$app->controller->id;
        $model->save(false);
        return 0;
        
    }
    //-----------------------tamat-------------------//

    public function isKetuaProgram(){
        if(Tblrscoadminpost::find()->where(['ICNO'=>Yii::$app->user->getId()])->andWhere(['and',['adminpos_id'=>18],['flag'=>1]])->exists()){
            return true;
        }
        return false;
    }
    public function isPentadbirSistem(){
        if(Yii::$app->user->identity->accessLevel == 1){
            return true;
        }
        return false;
    }
    public function isPengurusModul(){
        if(Yii::$app->user->identity->accessLevel == 2){
            return [true,Yii::$app->user->identity->accessSecondLevel];
        }
        return false;
    }
    public function isPenggunaBiasa(){
        if(Yii::$app->user->identity->accessLevel == 5){
            return true;
        }
        return false;
    }
    public function isInSameProgram($icno){ //check if the icno have same program kod with this logged user
        $staf = $this->findModel($icno);
        if(Yii::$app->user->identity->KodProgram == $staf->KodProgram){
            return true;
        }
        return false;
    }
    public function SendNotification($data = null){  //array{$icno,$title,$}
        if ($data == null) {
            $data = [
                'icno' => 'user icno',
                'title' => 'notification title',
                'content' => 'message to delivered',
                'date' => 'date of notification',
            ];
        }
        $noty = new Notification();
        $noty->icno = $data['icno'];
        $noty->title = $data['title'];
        $noty->content = $data['content'];
        $noty->ntf_dt = $data['date'];
        if ($noty->save()) {
            return [true,'No Errors'];
        }
        return [false, $noty->errors];
    }

    //vaksin//

    public function HaveVaccineRecord($icno){
        return Tblstatusvaksinasi::isRegistered($icno);
    }
    public function EligibleBooster(){
        return Tblstatusvaksinasi::isEligibleBooster(Yii::$app->user->getId());
    }

    public function isAllowedClockin($icno){
        return Tblbsmwatchlist::isAllowed($icno);
    }

    //tamat vaksin//

    //data//
    public function Kategori($id = null){
        if(($kategori = Jawatankategori::find()->where(['id'=>$id])->one()) !== null){
            return ucwords(strtolower($kategori->kategori));
        }
        return null;        
    }

    public function Kumpulan($id = null){
        if(($kumpulan = Kumpulankhidmat::find()->where(['id'=>$id])->one()) !== null){
            return $kumpulan->name;
        }
        return null;
    }
    public function StatusLantikan($id = null){
        if(($sl = StatusLantikan::find()->where(['ApmtStatusCd'=>$id])->one()) !== null){
            return ucwords(strtolower(str_replace("Lantikan ","",$sl->ApmtStatusNm)));
        }
        return null;
    }
    public function Jawatan($id = null){
        if(($gj = GredJawatan::find()->where(['id'=>$id])->one()) !== null){
            return $gj->fname;
        }
        return null;
    }
    public function ServiceStatus($id = null){
        if($id == '06'){
            return 'Keseluruhan';
        }
        if(($ss = ServiceStatus::find()->where(['ServStatusCd'=>$id])->one()) !== null){
            return $ss->ServStatusNm;
        }
        return null;
    }

    //tamat data//

    //kelayakan perubatan fpsk//

    public function IsFPSKPP(){
        if(Yii::$app->user->getId() == $this->PP('138')){
            return true;
        }
        return false;
    }

    //tamat kelayakan perubatan fpsk//

    //Epos//
    public function PelulusEpos($DeptId,$_attr = null){
        if(($model = TblAkses::PelulusJabatan($DeptId)) !== null){
            if($_attr == 'emel'){
                return $model->kakitangan->COEmail;
            }
            return $model->icno;
        }
        return null;
    }
    public function AdminEpos($_attr = null){
        if(($model = TblAkses::AdminEpos()) !== null){
            if($_attr == 'emel'){
                return $model->kakitangan->COEmail;
            }
            return $model->icno;
        }
        return null;
    }
    //tamat Epos//


    // protected //
    protected function findModel($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    //public , all use//
    public function Tarikh($date){
        if(empty($date) || $date == null){
            return '-';
        }
 
        $m = date_format(date_create($date), "m");
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
          
        return date_format(date_create($date), "d").' '.$m.' '.date_format(date_create($date), "Y");
    }

    public function validateProof($data){ //upload document

        if($data != 'deleted' && !empty($data)){
            return true;
        }

        return false;
    }

    public function PP($dept_id){ //department id
        $model = Department::find()->where(['id'=>$dept_id])->one();
        if($model){
            if($model->sub_of){
                $model = Department::find()->where(['id'=>$model->sub_of])->one();
            }
            return $model->pp;
        }
        return null;
    }

    public function BioLastUpdate(){
        if(($kemaskini_terakhir = Yii::$app->user->identity->kemaskini_terakhir) !== null){
            return $this->Tarikh($kemaskini_terakhir);
        }
        return null;
    }
    public function HighestEdu(){
        if(Yii::$app->user->identity->pendidikan !== null){
            return Yii::$app->user->identity->pendidikan->HighestEduLevel;
        }
        return null;
    }

    public function TotalFmy($icno = null){
        if($icno == null){
            $icno = Yii::$app->user->getId();
        }
        return Tblkeluarga::jumlahkeluarga($icno);
    }

    public function LatestPassport($icno = null){
        if(($model = Tblpasport::LatestPassport(($icno == null) ? $icno = Yii::$app->user->getId() : $icno)) !== null){
            return $model;
        }
        return null;
    }
    public function LatestLicense($icno = null){
        if(($model = Tbllesen::LatestLicense(($icno == null) ? $icno = Yii::$app->user->getId() : $icno)) !== null){
            return $model;
        }
        return null;
    }
    
    public function SendEmail($params) {
        
        try {
            $res = Yii::$app->mailerEpos->compose()
                    ->setFrom(ArrayHelper::keyExists('from', $params, false) ? $params['from'] : '')
                    ->setSubject(ArrayHelper::keyExists('subject', $params, false) ? $params['subject'] : '')
                    ->setTo(ArrayHelper::keyExists('to', $params, false) ? $params['to'] : '')
                   ->setHtmlBody(ArrayHelper::keyExists('htmlBody', $params, false) ? $params['htmlBody'] : '')
                    ->send();

            // VarDumper::dump( $res, $depth = 10, $highlight = true);die;
            return true;

        } catch (Exception $e) {
            // VarDumper::dump( $e, $depth = 10, $highlight = true);die;
            return false;
        }
    }


}
