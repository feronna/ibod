<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\hronline\Tblpasport;
use app\models\hronline\Tblpermitkerja;
use app\models\hronline\Tblprcobiodata;
use app\models\Notification;
use app\models\hronline\TblmpMonitorReminder;
use app\models\hronline\Tblpendidikan;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\RptPassport;
use app\models\hronline\Tblbsmwatchlist;
use app\models\hronline\Tblstatusvaksinasi;
use Symfony\Component\CssSelector\Node\FunctionNode;

class MaklumatPeribadiController extends Controller {


    public function actionUpdateRptPP(){  //scheduler update RptPassport
        $r = [];
        $b = [];
        $biodata = Tblprcobiodata::find()->select(['ICNO','isSabahan','NatStatusCd'])->where(['!=','status','06'])->asArray()->all();
        $rpt = RptPassport::find()->select(['ICNO'])->all();
       
        foreach ($rpt as $rpt) {
            array_push($r, $rpt->ICNO);
        }

        for($i = 0; $i < count($biodata); $i++){
            array_push($b,$biodata[$i]['ICNO']);
        }
        
        for($i = 0; $i < count($biodata); $i++){
            if (!in_array($biodata[$i]['ICNO'], $r)) { //new staf
                $model = new RptPassport();
                $model->ICNO = $biodata[$i]['ICNO'];
                $model->isSabahan = $biodata[$i]['isSabahan'];
            } else { //existing staf
                $model = RptPassport::find()->where(['ICNO' => $biodata[$i]['ICNO']])->one();
                $model->isSabahan = $biodata[$i]['isSabahan'];
            }
            
            $paspot = Yii::$app->MP->hasValidPasport($biodata[$i]['ICNO']);
            $model->pasport_status = $paspot[2];
            $model->tblpassport_id = $paspot[1];
            if(!$model->lock){
                if ($biodata[$i]['isSabahan'] == 0 && $biodata[$i]['NatStatusCd'] != '3' && $paspot[0] == false) {
                    $model->ps_noty_status = 1;
                    
                } else {
                    $model->ps_noty_status = 0;
                }
            }
          
            $permit = Yii::$app->MP->hasValidPermit($biodata[$i]['ICNO']);
            $model->permit_status = $permit[2];
            $model->tblpermit_id = $permit[1];
            if(!$model->lock){
                if ($biodata[$i]['isSabahan'] == 0 && $biodata[$i]['NatStatusCd'] != '3' && $permit[0] == false) {
                    $model->pr_noty_status = 1;
                } else {
                    $model->pr_noty_status = 0;
                }
            }
            
            $model->save(false);
            
        }

        return ExitCode::OK;
    }

    //passport//

    public function actionExpiredpassport() { //scheduler send noty for expired || not exist passport
        
        $cdate = date("Y-m-d");
        $rpt = RptPassport::find()->all();
        // $rpt = RptPassport::find()->where(['ICNO'=>'920131115046'])->all();

        foreach ($rpt as $rpt) {

            // var_dump($rpt->ps_noty_status);
            // die;

            switch ($rpt->pasport_status) {
                case '2':
                    $paspot_status = 'has expired';
                    $paspot_notes = 'Do not update the expired passport.';
                    break;
                case '3':
                    $paspot_status = 'not exist';
                    $paspot_notes = ' ';
                    break;
                
                default:
                    $paspot_status = '-';
                    $paspot_notes = '-';
                    break;
            }

            if ($rpt->isSabahan == '0' && $rpt->pasport_status != '1' && $rpt->biodata->NatStatusCd != '3' && $rpt->ps_noty_status == '1') {

                if($rpt->biodata->NatStatusCd == '1' && $rpt->biodata->campus_id == '2'){ //check whether staff is campus labuan or not

                }else{
                    $ntf = new Notification();
                    $ntf->icno = $rpt->ICNO;
                    $ntf->title = "Maklumat Peribadi (Passport)";
                    $ntf->content = "Reminder " . $rpt->ICNO . ": We would like to inform you that your 'Passport' " . $paspot_status . ". Please provide your new 'Passport' information by following these steps:
                    <p><b>After login into HROnline V4.0</b> </p>
                    <p>                                      </p>
                    <p>1. On the left menu, click <b>'Maklumat Peribadi'</b>.</p>
                    <p>2. On the main page, click <b>'Paspot & Permit Kerja'</b>.</p>
                    <p>3. On the top page, click tab <b>'Passport'</b>.</p>
                    <p>4. Clik button <b>'New Passport'</b>. " . $paspot_notes . " </p>
                    <p>5. Fill all the field required, including the upload file.</p>
                    <p>6. To save, clik button <b>Save</b>.</p>";
                    $ntf->ntf_dt = $cdate;
                    $ntf->save();
                }

                

            } 
        }         

        return ExitCode::OK;
    }

    public function actionWillExpiredPassport(){
        $rpt = RptPassport::find()->where(['pasport_status'=> 1])->all();
        $count = 0;
        $cvalid = 0;
        $cdate = date("Y-m-d");
        foreach ($rpt as $rpt) {

            $ntf = new Notification();
            $expired = self::willExpired($rpt->ICNO);
            if ($expired[0]) {
                $ntf->icno = $rpt->ICNO;
                $ntf->title = "Maklumat Peribadi (Paspot)";
                $ntf->content = "Peringatan mesra kepada " . $rpt->ICNO . ": Paspot anda akan tamat kurang daripada sembilan puluh (90) hari lagi.";
                $ntf->ntf_dt = $cdate;
                $ntf->save();
            }
            
        }        

        return ExitCode::OK;
    }

    private function willExpired($icno){  // passport will be expired

        $paspot = Tblpasport::find()->where(['ICNO'=>$icno])->all();
        $pdate = null;
        $notydate = null;
        $cdate = date("Y-m-d");
        $will_expired = false;
        switch (count($paspot)) {
            case '0':
                $pdate = null;
                break;
            case '1':
                foreach ($paspot as $p) {
                    $pdate = $p->PassportExpiryDt;
                }
                break;
            
            default:
                $date = null;
                $i = 0;
                foreach ($paspot as $p) {
                    $date = $p->PassportExpiryDt;

                    if($i == 0 || $pdate < $date){
                        $pdate = $date;
                    }
                    
                    $i++;
                }
                break;
        }
        if (!is_null($pdate)) {
            $notydate = date("Y-m-d", strtotime("-90 days", strtotime($pdate)));
            if (($cdate == $notydate || $notydate < $cdate) && $pdate > $cdate) {
                $will_expired = true;
            }
        }
        return [$will_expired, $notydate];

    }

    public Function actionRunPasportIsactive(){
        $model = Tblprcobiodata::find()->where(['!=','status','6'])->all();
        
        foreach ($model as $model) {
            $latestPaspot_id = Yii::$app->MP->latestPasport($model->ICNO);
            if(!empty($latestPaspot_id)){
                $pasport = Tblpasport::find()->where(['ICNO'=>$model->ICNO])->andWhere(['id'=>$latestPaspot_id])->one();
                if($pasport->PassportExpiryDt > date('Y-m-d')){
                    $pasport->isActive = 1;
                }else{
                    $pasport->isActive = 0;
                }
                $pasport->save(false);
               
            }            
        }
        return ExitCode::OK;
    }

    //permit 

    public function actionExpiredpermitkerja(){  //scheduler send noty for expired || not exist permit kerja
        
        $cdate = date("Y-m-d");
        $rpt = RptPassport::find()->all();

        foreach ($rpt as $rpt) {

            switch ($rpt->permit_status) {
                case '2':
                    $permit_status = 'has expired';
                    $permit_notes = 'Do not update the expired permit kerja.';
                    break;
                case '3':
                    $permit_status = 'not exist';
                    $permit_notes = ' ';
                    break;
                
                default:
                    $permit_status = '-';
                    $permit_notes = '-';
                    break;
            }
            if ($rpt->isSabahan == '0' && $rpt->permit_status != '1' && $rpt->biodata->NatStatusCd != '3' && $rpt->pr_noty_status == '1') {
                
                if($rpt->biodata->NatStatusCd == '1' && $rpt->biodata->campus_id == '2'){ //check whether staff is campus labuan or not

                }else{
                    $ntf = new Notification();
                    $ntf->icno = $rpt->ICNO;
                    $ntf->title = "Maklumat Peribadi (Permit Kerja)";
                    $ntf->content = "Reminder " . $rpt->ICNO . ": We would like to inform you that your 'Permit kerja' " . $permit_status . ". Please provide your new 'Permit kerja' information by following these steps:
                    <p><b>After login into HROnline V4.0</b> </p>
                    <p>                                      </p>
                    <p>1. On the left menu, click <b>'Maklumat Peribadi'</b>.</p>
                    <p>2. On the main page, click <b>'Paspot & Permit Kerja'</b>.</p>
                    <p>3. On the top page, click tab <b>'Permit kerja'</b>.</p>
                    <p>4. Clik button <b>'New Permit kerja'</b>. " . $permit_notes . " </p>
                    <p>5. Fill all the field required, including the upload file.</p>
                    <p>6. To save, clik button <b>Save</b>.</p>";
                    $ntf->ntf_dt = $cdate;
                    $ntf->save();
                }

            } 
        }         

        return ExitCode::OK;
    }

    public function actionWillExpiredPermit(){
        $model = Tblprcobiodata::find()->where(['!=', 'Status', '06'])->all();
        $count = 0;
        $count1 = 0;
        
        $cvalid = 0;
        $cdate = date("Y-m-d");
        foreach ($model as $staff) {
            $check = false;
            if ($staff->NatStatusCd == 1) {
                $kod_negeri = self::Negeri($staff->ICNO);
                switch ($kod_negeri) {
                    case '12': //staff asal sabah
                        $check = false; // no need to check
                        break;

                    case '15':  //staff asal labuan
                        if($staff->campus_id != '2'){ //selain kampus labuan
                            $check = true;
                        }
                        break;
                    
                    default:
                        $check = true;
                        break;
                }

            }else{
                $check = true;
            }
            if ($check) {
                $cvalid++;
                $ntf = new Notification();
                $expired = self::willExpiredPermitkerja($staff->ICNO);
                if ($expired[0]) {
                    $count++;
                    //echo $staff->ICNO . '|' . $expired[1] . '</br>';
                    $ntf->icno = $staff->ICNO;
                    $ntf->title = "Maklumat Peribadi (Permit Kerja)";
                    $ntf->content = "Peringatan mesra kepada ".$staff->ICNO.": Permit Kerja anda akan tamat kurang daripada sembilan puluh (90) hari lagi.";
                    $ntf->ntf_dt = $cdate;
                    $ntf->save();
                } 
                // else {
                //     $count1++;
                //     //ada valid passport
                // }
            }
            
        }
        echo "Total will expired = ".$count;

        return ExitCode::OK;
    }

    private function willExpiredPermitkerja($icno){  // permitkerja will be expired

        $permit = Tblpermitkerja::find()->where(['ICNO'=>$icno])->all();
        $pdate = null;
        $cdate = date("Y-m-d");
        $will_expired = false;
        $notydate =null;
        switch (count($permit)) {
            case '0':
                $pdate = null;
                break;
            case '1':
                foreach ($permit as $p) {
                    $pdate = $p->WrkPermitExpiryDt;
                }
                break;
            
            default:
                $date = null;
                $i = 0;
                foreach ($permit as $p) {
                    $date = $p->WrkPermitExpiryDt;

                    if($i == 0 || $pdate < $date){
                        $pdate = $date;
                    }
                    
                    $i++;
                }
                break;
        }
        if (!is_null($pdate)) {
            $notydate = date("Y-m-d", strtotime("-90 days", strtotime($pdate)));
            if ( ($cdate == $notydate || $notydate < $cdate) && $pdate > $cdate) {
                $will_expired = true;
            }
        }
        return [$will_expired, $notydate];

    }

    private function hasValidPermitkerja($icno){
        $permitkerja = Tblpermitkerja::find()->where(['ICNO'=>$icno])->all();
        $valid_permit = true;
        $msg = "<p>Reminder ".$icno.": We would like to inform you that your 'Work Permit' has expired. Please provide your new 'Work Permit' information by following these steps:</p>
        <p><b>After login into HROnline V4.0</b> </p>
        <p>                                      </p>
        <p>1. On the left menu, click <b>'Maklumat Peribadi'</b>.</p>
        <p>2. On the main page, click <b>'Paspot & Permit Kerja'</b>.</p>
        <p>3. On the top page, click tab <b>'Work Permit'</b>.</p>
        <p>4. Clik button <b>'New Work Permit'</b>.</p>
        <p>5. Fill all the field required, including the upload file.</p>
        <p>6. To save, clik button <b>Save</b>.</p>";

        $cdate = date("Y-m-d");
        switch (count($permitkerja)) {
            case '0':
                $valid_permit = false;
                $msg = "<p>Reminder " . $icno . ": Reminder " . $icno . ": System has detect that you do not have any 'Work Permit' information in 'Maklumat Peribadi'. Please provide your new 'Work Permit' information by following these steps:</p>
                <p><b>After login into HROnline V4.0</b> </p>
                <p>                                      </p>
                <p>1. On the left menu, click <b>'Maklumat Peribadi'</b>.</p>
                <p>2. On the main page, click <b>'Paspot & Permit Kerja'</b>.</p>
                <p>3. On the top page, click tab <b>'Work Permit'</b>.</p>
                <p>4. Clik button <b>'New Work Permit'</b>.</p>
                <p>5. Fill all the field required, including the upload file.</p>
                <p>6. To save, clik button <b>Save</b>.</p>";
                break;
            case '1':
                foreach ($permitkerja as $pk) {
                    if($cdate > $pk->WrkPermitExpiryDt){
                        $valid_permit = false;
                    }
                }
                break;

            default:
                $has_valid_permit = false;

                foreach ($permitkerja as $p) {
                    if ($p->WrkPermitExpiryDt > $cdate) {
                        $has_valid_permit = true;
                        //return [true, $msg = null];
                    break;
                    }
                }
                $valid_permit = false;
                break;
        }

        return [$valid_permit,$msg];
    }
    
    public function Negeri($icno){ //check if sabahan or not. true = sabahan; false = non-sabahan
        $kod_ic_sabah = ["12","47","48","49"];
        $kod_ic_labuan = ["15", "58"];
        $model_kod = '0';
        $kod_negeri = null;
        $split = str_split($icno);
        $model_kod = $split[6].$split[7];
        if(in_array($model_kod, $kod_ic_sabah)){
            $kod_negeri = '12';
        }elseif (in_array($model_kod, $kod_ic_labuan)){
            $kod_negeri = '15';
        }else{
            $kod_negeri = '0';
        }
        return $kod_negeri;
    }

    public function actionGenerateH($key=null){
        // if($key == null || $key != '940402125181'){
        //     Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Pls enter KEY!']);
        //     return $this->redirect(['generate-h']);
        // }

        $model = Tblprcobiodata::find()->all();
        foreach ($model as $staff) {
            if ($staff->NatStatusCd == 1 && strlen($staff->ICNO) == '12') {
                $kod_negeri = self::Negeri($staff->ICNO);
                switch ($kod_negeri) {
                    case '12': //staff asal sabah
                        $staff->isSabahan = '1';
                        break;

                    case '15': 
                        $staff->isSabahan = '0';
                        break;
                    
                    default:
                    $staff->isSabahan = '0';
                        break;
                }

            }             
            elseif ($staff->NatStatusCd == 1 && strlen($staff->ICNO) == '8' && substr($staff->ICNO, 0, 1) == 'H') { 
                $staff->isSabahan = '1';
            }
            elseif ($staff->NatStatusCd == 1 && strlen($staff->ICNO) != '12') { 
                $staff->isSabahan = '0';
            }
            elseif ($staff->NatStatusCd == '3') { //penduduk tetap
                $staff->isSabahan = '0';
            }
            else{
                $staff->isSabahan = '0';
            }

            $staff->save(false);

        } 
        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Berjaya generate!']);
        return $this->redirect(['view-u-u-p']);

    }

    //rpt_passport//

    public function actionGeneratetblrptpassport(){
        Yii::$app->db2->createCommand()->truncateTable(RptPassport::tableName())->execute();
        $model = Tblprcobiodata::find()->where(['!=','Status','06'])->all();
        foreach ($model as $m) {
            $rpt_passport = new RptPassport();
            $rpt_passport->ICNO = $m->ICNO;
            $rpt_passport->isSabahan = $m->isSabahan;
            $rpt_passport->save(false);
        }

        return ExitCode::OK;
    }

    public function actionGeneratenotystatus(){
        $model = RptPassport::find()->all();
        foreach ($model as $m) {
            if($m->isSabahan == 0 && ($m->pasport_status == 2 || $m->pasport_status == 3)){
                $m->noty_status = 1;
                $m->save(false);
            }
            else{
                $m->noty_status = 0;
                $m->save(false);
            }
        }

        return ExitCode::OK;
    }

    public function actionGenerateissabahan(){
        $model = RptPassport::find()->all();
        foreach ($model as $m) {
            $bio = Tblprcobiodata::find()->where(['ICNO'=>$m->ICNO])->one();
            if($bio){
                $m->isSabahan = $bio->isSabahan;
                $m->save(false);
            }else{
                echo $m->ICNO . 'not exist';
            }
            
        }

        return ExitCode::OK;
    }

    public function actionGeneratepasportstatus(){
        $model = RptPassport::find()->all();
        foreach ($model as $m) {
            $res = Yii::$app->MP->hasValidPasport($m->ICNO);
            // $res = self::hasValidPasport($m->ICNO);
            if ($res[0]) {
                $m->pasport_status = $res[2];
                $m->tblpassport_id = $res[1];
            } else {
                $m->pasport_status = $res[2];
                $m->tblpassport_id = $res[1];
            }
            $m->save(false);
            
        }

        return ExitCode::OK;
    }

    //tamat rpt_passport//

    ///pendidikan///

    public function actionUpdateBiodataPendidikan(){
        $biodata = Tblprcobiodata::find()->where(['!=','status','06'])->all();
        $affected = 0;
        
        foreach ($biodata as $bio) {
            //$tahap_pendidikan_biodata = $bio->pendidikan->newEduRank ?? '98';
            $tblpendidikan = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO'=>$bio->ICNO])->asArray()->all();
            $tblpendidikan = self::bubbleSort($tblpendidikan);
            if(!empty($tblpendidikan)){
                $bio->HighestEduLevelCd = $tblpendidikan[0]['HighestEduLevelCd'];
                $bio->ConfermentDt = $tblpendidikan[0]['ConfermentDt'];
                $bio->save(false);
                $affected++;
            }           
        }

        echo $affected;
    }

    private function bubbleSort($array){
        if (!empty($array)) {
            for ($i = 0; $i < count($array); $i++) {

                for ($j = 0; $j < count($array); $j++) {
                    if ($array[$i]['pendidikanTertinggi']['HighestEduLevelRank'] > $array[$j]['pendidikanTertinggi']['HighestEduLevelRank'] &&  $i < $j) {

                        $temp = $array[$i];
                        $array[$i] = $array[$j];
                        $array[$j] = $temp;
                    } else if ($array[$i]['pendidikanTertinggi']['HighestEduLevelRank'] == $array[$j]['pendidikanTertinggi']['HighestEduLevelRank'] &&  $i < $j) {

                        // $array[$i]['title'] = $array[$i]['title'] .' '. $array[$j]['title'];
                        // array_splice($array,$j,1);
                        // $j--;

                    } else {
                    }
                }
            }
        }
        return $array;
    }

    public function actionLastUpdate($icno, $changedAttributes){
        
        if(!empty($changedAttributes)){
            $model = Tblprcobiodata::find()->where(['ICNO'=>$icno])->one();
            $model->last_update = date('Y-m-d h:i:s');
            $model->last_updater = Yii::$app->user->getId();
            $model->save(false);
        }
    }

    //tamat pendidikan//

    //vaksinasi//

    public function actionNotyVaksinasi(){
        $staf = Tblprcobiodata::find()->where(['!=','Status',6])->all();
        foreach ($staf as $staf) {
            if(Tblstatusvaksinasi::isRegistered($staf->ICNO) == 0){
                $noty = new Notification();
                $noty->icno = $staf->ICNO;
                $noty->title = 'Maklumat Peribadi: Program Vaksinasi';
                $noty->content = "Sila kemaskini maklumat vaksinasi anda. Cara-cara seperti berikut:
                    <p><b>Log masuk ke HROnline V4.0</b> </p>
                    <p>                                      </p>
                    <p>1. Paling atas-kanan pada skrin, tekan <b>'ikon gambar'</b> anda.</p>
                    <p>2. Tekan Pilihan <b>'My Profile'</b>.</p>
                    <p>3. Pada tengah skrin, tekan pilihan <b>'Program Vaksinasi'</b> pada menu utama.</p>
                    <p>4. Tekan butang <b>'Kemaskini'</b>.</p>
                    <p>5. Lengkapkan semua maklumat yang diperlukan.</p>
                    <p>6. Untuk menyimpan maklumat, tekan butang <b>Simpan</b>.</p>";
                $noty->ntf_dt = date('Y-m-d H:i:s');
                $noty->save(false);

            }
        }
        return ExitCode::OK;
    }

    public function actionNotyBoosterConsent(){
        $st = Tblstatusvaksinasi::find()->where(['status_vaksin'=>1])->andWhere(['and',['terima_dos1'=>1],['terima_dos2'=>1]])->all();
        foreach ($st as $st){
            $status = Yii::$app->MP->SendNotification([
                'icno' => $st->icno,
                'title' => 'Maklumat Peribadi (Program Vaksinasi [Booster])',
                'content' => "Sila kemaskini Program Vaksinasi (Booster) anda. Cara-cara seperti berikut:
                <p><b>Log masuk ke HROnline V4.0</b> </p>
                <p>                                  </p>
                <p>1. Paling atas-kanan pada skrin, tekan <b>'ikon gambar'</b> anda.</p>
                <p>2. Tekan Pilihan <b>'My Profile'</b>.</p>
                <p>3. Pada tengah skrin, tekan pilihan <b>'Program Vaksinasi'</b> pada menu utama.</p>
                <p>4. Tekan butang <b>'Dos Penggalak (Booster)'</b> pada bahagian atas paparan.</p>
                <p>5. Lengkapkan semua maklumat yang diperlukan.</p>
                <p>6. Untuk menyimpan maklumat, tekan butang <b>Simpan</b> pada bahagian paling bawah paparan.</p>",
                'date' => date('Y-m-d'),
            ]);
        }
        return ExitCode::OK;
    }

    public function actionSyncVaksinasi(){ //from tbl to watchlist
        $watchlist = Tblbsmwatchlist::find()->all();
        foreach ($watchlist as $wl) {
            $flagdos1 = false;
            $flagdos2 = false;
            if (($sv = Tblstatusvaksinasi::find()->where(['icno' => $wl->icno])->one()) !== null) {
                if (($sv->status_vaksin == 1 && $sv->terima_dos1 == 1 && $sv->terima_dos2 == 1) && ($sv->dos)) {
                    foreach($sv->dos as $dos){
                        if($dos->bil_dos == 1){
                            $flagdos1 = true;
                        }else if($dos->bil_dos == 2){
                            $flagdos2 = true;
                        }else{

                        }
                    }
                    if($flagdos1 && $flagdos2){
                        $wl->isAllowed = 1;
                        $wl->dateAD = date('Y-m-d h:i:s');
                        $wl->isDone = 1;
                        $wl->dateDone = date('Y-m-d h:i:s');
                        $wl->save(false);
                    }
                }
            }
        }

        return ExitCode::OK;
    }

    public function actionSyncLantikanToVaksin(){
        
        $staff = Tblprcobiodata::find()->where(['!=','Status','6'])->all();

        foreach($staff as $st){
            $add_flag = false;
            
            if (!$st->watchList) {
                if ($st->statusVaksinasi) {
                    if ($st->statusVaksinasi->status_vaksin != 1 || $st->statusVaksinasi->terima_dos1 != 1 || $st->statusVaksinasi->terima_dos2 != 1) {
                        $add_flag = true;
                    } else if ((!$st->statusVaksinasi->dos1) || (!$st->statusVaksinasi->dos2)) {
                        //mohon lengkapkan maklumat vaksin//
                        //$add_flag = true;
                    }
                } else {
                    $add_flag = true;
                }
            }
            
            if($add_flag){
                $wl = new Tblbsmwatchlist();
                $wl->icno = $st->ICNO;
                $wl->name = $st->CONm;
                $wl->category = 3;
                $wl->isAllowed = 0;
                $wl->isDone = 0;
                $wl->dateAD = null;
                $wl->dateDone = null;
                $wl->isNew = 2;
                $wl->save(false);
            }
        }

        return ExitCode::OK;

    }

    //tamat vaksinasi//

    //biodata//

    public function actionNotyBiodata(){
        $model = Tblprcobiodata::find()->where(['!=','Status','6'])->all();

        foreach ($model as $model) {
            if(empty($model->NegaraAsalCd) || empty($model->NegeriAsalCd)){
                $status = Yii::$app->MP->SendNotification([
                    'icno' => $model->ICNO,
                    'title' => 'Maklumat Peribadi (Biodata)',
                    'content' => "Sila kemaskini maklumat peribadi (Biodata) anda. Cara-cara seperti berikut:
                    <p><b>Log masuk ke HROnline V4.0</b> </p>
                    <p>                                  </p>
                    <p>1. Paling atas-kanan pada skrin, tekan <b>'ikon gambar'</b> anda.</p>
                    <p>2. Tekan Pilihan <b>'My Profile'</b>.</p>
                    <p>3. Pada tengah skrin, tekan pilihan <b>'Biodata'</b> pada menu utama.</p>
                    <p>4. Tekan butang <b>'Kemaskini'</b> pada bahagian atas paparan.</p>
                    <p>5. Lengkapkan semua maklumat yang diperlukan.</p>
                    <p>6. Untuk menyimpan maklumat, tekan butang <b>Simpan</b> pada bahagian paling bawah paparan.</p>",
                    'date' => date('Y-m-d'),
                ]);
            }
        }

        return ExitCode::OK;
    }

    //tamat biodata//

}
