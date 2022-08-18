<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\klinikpanel\Tblmaxtuntutan;
use app\models\Notification;
use app\models\klinikpanel\TblTopupHis;
use app\models\hronline\Tblprcobiodata;
use Yii;
use DateTime;
use DateInterval;

/**
 * command ni akan run pada setiap hari pada jam 1 pagi;
 * kenapa jam 1 pagi, kerana jam 1 pagi keadaan mula tenang.. suasana begitu asyik sekali..
 * every function akan check baki peruntukan day before command ni kena run..
 * Run command ni pakai Windows Task scheduler[daily-isnin hingga ahad].
 */
class KlinikpanelController extends Controller
{

    /**
     * untuk check baki kakitangan kurang 300
     * 
     * @return EXITCODE
     */
    public function actionBalanceNoti()

    {
        $query = Tblmaxtuntutan::find()->where(['<', 'current_balance', 300])->all();

        foreach ($query as $q) {
            $exist = Notification::find()->where(['icno' => $q->max_icno])->andWhere(['LIKE', 'title', 'Baki Peruntukan Klinik Panel (MyHealth UMS)'])->andWhere(['YEAR(ntf_dt)' => date('Y')])->count();
            $topup = TblTopupHis::find()->where(['icno' => $q->max_icno])->all();
            echo $exist;

            if ($exist <= count($topup)) {


                $ntf = new Notification();
                $ntf->icno = $q->max_icno; // kakitangan
                $ntf->title = 'Baki Peruntukan Klinik Panel (MyHealth UMS)';
                $ntf->content = "Baki peruntukan anda kurang daripada RM300.00. Sila mohon penambahan peruntukan untuk terus menggunakan kemudahan ini.";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                echo $q->max_icno;
            }
        }
        return ExitCode::OK;
    }

    public function actionNotifikasiBirthday()
    {

        $set_from = ['unitsaraanbsm@ums.edu.my' => 'HRONLINE v4.0 - Sistem Klinik Panel (MyHealth) '];
        $subject = 'PERINGATAN MESRA: PEMERIKSAAN KESIHATAN 40 TAHUN KE ATAS';
        $content = 'Testing';

        $biodata = Tblprcobiodata::find()
            ->where(['<>', 'Status', '6'])
            ->all();

        foreach ($biodata as $model) {

            $date = new DateTime($model->COBirthDt);
            $date->add(new DateInterval('P40Y'));

            if ($date->format('Y-m-d') == date('Y-m-d')) {
                //---- Email Notification ----//
                $email = $model['COEmail'];
                $name = $model['CONm'];

                if ($email) {
                    $set_to = [$email => $name];
                    Yii::$app->mailerBirthday->compose('birthday', ['content' => $content, 'biodata' => $biodata])
                        ->setFrom($set_from)
                        ->setTo($set_to)
                        ->setSubject($subject)
                        ->setCc(['babbra.george@ums.edu.my', 'norjaidah@ums.edu.my'])

                        ->send();
                }

                echo $model->ICNO . ' SEKARANG';
            } else {

                 echo $model->ICNO . 'TIADA';
            }
        }

        return ExitCode::OK;
    }
}
