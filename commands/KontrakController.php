<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
//use app\models\hronline\Tblprcobiodata;
use app\models\Notification;
use app\models\kontrak\TblBukapermohonan;
use yii\helpers\Html;
use app\models\kontrak\Kontrak;
use app\models\hronline\Tblrscoapmtstatus_1;
use app\models\hronline\Tblstat;
use app\models\hronline\Tblprcobiodata;
use app\models\elnpt\TblMain;

/**
 * command ni akan run pada setiap hari pada jam 2 pagi;
 * kenapa jam 2 pagi, kerana jam 2 pagi keadaan mula tenang.. suasana begitu asyik sekali..
 * every function akan detect kehadiran day before command ni kena run..
 * Run command ni pakai Windows Task scheduler setiap hari.
 */
class KontrakController extends Controller {

    /**
     * Untuk detect siapa yang akan tamat kontrak selepas 120 hari;
     * 
     * @return EXITCODE;
     * 
     */
    
    protected function notifikasi($icno, $content){
        //--------Model Notification-----------//
                $ntf = new Notification(); //noti untuk kp
                $ntf->icno = $icno;
                $ntf->title = 'PELANTIKAN SEMULA KONTRAK';
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save(false);
                //--------Model Notification-----------//
    }
    
    public function actionUpdatedate() {
        $kontrak = Kontrak::find()->where(['status_bsm' => 6, 'job_category' => 2])->all();
        
        foreach ($kontrak as $k){
            $model = Kontrak::find()->where(['id' => $k->id])->one();
            $model->startDateLantik = $k->kakitangan->startDateLantik;
            $model->endDateLantik = $k->kakitangan->endDateLantik;
            $model->save();
        }
        
                    //--------Model Notification-----------//
        return ExitCode::OK;
    }
    
    public function actionAutoupdate()
    {
        $today = date('Y-m-d');
        $model = Kontrak::find()->where(['date_autoupdate' => $today])->all();
        
        foreach ($model as $m){
            
           if($m->startDateLantik == $m->kakitangan->startDateLantik){
        $lantikan = new Tblrscoapmtstatus_1();
        
        $permohonan = TblBukapermohonan::find()->where(['id' => $m->sesi_id])->one();
        $start_dt = $permohonan->new_start_date;
        
        if(str_contains($m->tempoh_l_bsm, 'Tahun')){
            $end_dt = date('Y-m-d',strtotime($start_dt . '+'.(float)$m->tempoh_l_bsm.' years -1 days'));
        }
        elseif(str_contains($m->tempoh_l_bsm, 'Bulan')){
            $end_dt = date('Y-m-d',strtotime($start_dt . "+".(float)$model->tempoh_l_bsm." months -1 days"));
        }
        
        $lantikan->ICNO = $m->icno;
        $lantikan->ApmtStatusCd= $m->kakitangan->statLantikan;
        $lantikan->ApmtStatusStDt = $start_dt;
        $lantikan->ApmtStatusEndDt = $end_dt;
        $lantikan->save(false);
        
        Tblprcobiodata::updateAll(['startDateLantik' => $start_dt, 'endDateLantik' => $end_dt], 'ICNO ='. $m->icno);
        
        }}
        
        if(date('m-d') == '09-30'){
            $current_data = TblBukapermohonan::find()->where(['id' => 3])->one();
            
            $data = TblBukapermohonan::find()->where(['id' => 4])->one();
            $data->start_tamatkontrak = (date('Y')+1).'-03-31';
            $data->end_tamatkontrak = (date('Y')+1).'-06-29';
            $data->start_bolehmohon = date('Y').'-12-31';
            $data->end_bolehmohon = (date('Y')+1).'-03-30';
            $data->tahun = date('Y')+1;
            $data->new_start_date = (date('Y')+1).'-04-01';
            $data->save(false);
        }
        elseif(date('m-d') == '12-31'){
            $current_data = TblBukapermohonan::find()->where(['id' => 4])->one();
            
            $data = TblBukapermohonan::find()->where(['id' => 5])->one();
            $data->start_tamatkontrak = (date('Y')+1).'-06-30';
            $data->end_tamatkontrak = (date('Y')+1).'-09-29';
            $data->start_bolehmohon = (date('Y')+1).'-03-31';
            $data->end_bolehmohon = (date('Y')+1).'-06-29';
            $data->tahun = date('Y')+1;
            $data->new_start_date = (date('Y')+1).'-07-01';
            $data->save(false);
        }
        elseif(date('m-d') == '03-31'){
            $current_data = TblBukapermohonan::find()->where(['id' => 5])->one();
            
            $data = TblBukapermohonan::find()->where(['id' => 6])->one();
            $data->start_tamatkontrak = date('Y').'-09-30';
            $data->end_tamatkontrak = date('Y').'-12-30';
            $data->start_bolehmohon = date('Y').'-06-30';
            $data->end_bolehmohon = date('Y').'-09-29';
            $data->tahun = date('Y');
            $data->new_start_date = date('Y').'-10-01';
            $data->save(false);
        }
        elseif(date('m-d') == '06-30'){
            $current_data = TblBukapermohonan::find()->where(['id' => 6])->one();
            
            $data = TblBukapermohonan::find()->where(['id' => 3])->one();
            $data->start_tamatkontrak = date('Y').'-12-31';
            $data->end_tamatkontrak = (date('Y')+1).'-03-30';
            $data->start_bolehmohon = date('Y').'-09-30';
            $data->end_bolehmohon = date('Y').'-12-30';
            $data->tahun = date('Y')+1;
            $data->new_start_date = (date('Y')+1).'-01-02';
            $data->save(false);
        }
        if(!empty($current_data)){
        $biodata = Tblprcobiodata::find()->joinWith('jawatan')->where(['statLantikan'=>3, 'job_category' => 2])->all();
            
            foreach ($biodata as $b){
            $tarikhtamat = date_format(date_create($b->endDateLantik),'Y-m-d');
            if($tarikhtamat >= $current_data->start_tamatkontrak && $tarikhtamat <= $current_data->end_tamatkontrak){
                
              $this->notifikasi($b->ICNO, "Adalah Dimaklumkan bahawa kontrak perkhidmatan tuan/puan akan tamat pada $b->tarikhtamatlantik; Tuan/puan adalah dipelawa untuk mengemukakan permohonan pelantikan semula kontrak <b>DALAM KADAR SEGERA</b>; "
                                . "Kegagalan tuan/puan berbuat demikian akan dianggap tidak berminat untuk melanjutkan perkhidmatan di UMS.");
            }
        }}
        
        
        return ExitCode::OK;
    }
    
    public function actionGenerate()
    {
        $query = \app\models\hronline\Tblprcobiodata::find()->where(['icno' => '630609035729']);
        
           
        $exporter = new \yii2tech\spreadsheet\Spreadsheet([
            //            'dataProvider' => new ActiveDataProvider([
            //                'query' => TblMain::find(),
            //                
            //            ]),
            'query' => $query,
            'batchSize' => 200,
            'columns' => [
                [
                    'label' => 'Nama',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => 'CONm',
                    'format' => 'html',
                ],
                [
                    'label' => 'No IC/Passport',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => 'ICNO',
                    'format' => 'html',
                ],
                [
                    'label' => 'UMSPER',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => 'COOldID',
                    'format' => 'html',
                ],
                [
                    'label' => 'GRED',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => 'kakitangan.jawatan.gred',
                    'format' => 'html',
                ],
                [
                    'label' => 'JAWATAN',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => 'kakitangan.jawatan.nama',
                    'format' => 'html',
                ],
                [
                    'label' => 'JFPIU',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => 'kakitangan.department.shortname',
                    'format' => 'html',
                ],
                [
                    'label' => 'lnpt 2018',
                    'value' => function ($data){
                    $id = \app\models\elnpt\elnpt_lama\TblUser::find()->where(['user_id' => $data->ICNO])->one()->staff_id;
                    return \app\models\elnpt\elnpt_lama\TblMarkahLama::find()->where(['staff_id' => $id, 'tahun' => '2018'])->one()->purata;
            
                    },
                ],
                [
                    'label' => 'lnpt 2019',
                    'value' => function ($data){
                        $markah = TblMain::find()->where(['PYD' => $data->ICNO, 'tahun'=>'2019'])->one()->sumMarkah;
                        $markah=='0'? '':$markah;
                        return $markah;
                    },
                ],
                [
                    'label' => 'lnpt 2020',
                    'value' => function ($data){
                        $markah = TblMain::find()->where(['PYD' => $data->ICNO, 'tahun'=>'2020'])->one()->sumMarkah;
                        $markah=='0'? '':$markah;
                        return $markah;
                    },
                ]
                            ,
                [
                    'label' => 'jumlah kredit mengajar',
                    'value' => 'jumlahKreditMengajar'
                ],
                            [
                    'label' => 'jumlah pelajar',
                    'value' => 'jumlahPelajar'
                ]
                      ],

        ]);

        $exporter->save('web/files/laporan_perunLngan.xls');


        //        echo 'asd';
        return ExitCode::OK;
    }

}
