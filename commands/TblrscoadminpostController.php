<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\hronline\Tblrscoadminpost;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Html;
use app\models\Notification;
use app\models\hronline\Tblprcobiodata;
use DateTime;
/**
 * command ni akan run pada setiap hari pada jam 1 pagi;
 * kenapa jam 1 pagi, kerana jam 1 pagi keadaan mula tenang.. suasana begitu asyik sekali..
 * every function akan check baki peruntukan day before command ni kena run..
 * Run command ni pakai Windows Task scheduler[daily-isnin hingga ahad].
 */
class TblrscoadminpostController extends Controller {

    /**
     * untuk notifi admin lantikan pentadbiran yang akan tamat tempoh dalam masa tiga(3) bulan
     * 
     * @return EXITCODE
     */
    public function actionNotiLantikan() {
//        $query = Tblrscoadminpost::find()->Where('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 92 DAY)')->all();  

        $query = Tblprcobiodata::find()->where(['accessLevel' => "2"])->andWhere(['accessSecondLevel' => "11"])->all();

//        $todaydate = date('Y-m-d');       
        foreach ($query as $q) {
            $exist = Notification::find()->where(['icno' => $q->ICNO])->andWhere(['LIKE', 'content', 'baki'])->exists();
            if (!$exist) {
                $ntf = new Notification();
                $ntf->icno = $q->ICNO; // kakitangan
                $ntf->title = 'Peringatan Mesra: Lantikan pentadbiran yang akan tamat';
                $ntf->content = "Senarai nama lantikan pentadbiran yang akan tamat tempoh dalam masa tiga (3) bulan." . Html::a("&nbsp;<b>Klik Sini</b>", '../tblrscoadminpost/admin-post-list-akademik2', ['target' => '_blank']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }
        }
        return ExitCode::OK;
    }

    public function actionNotiTamat() {

        $query = \app\models\pengesahan\TblAccessCanselori::find()->where(['access' => "1"])->all();
     
        foreach ($query as $q) {
            $exist = Notification::find()->where(['icno' => $q->icno])->andWhere(['LIKE', 'content', 'baki'])->exists();
            if (!$exist) {
                $ntf = new Notification();
                $ntf->icno = $q->icno; // kakitangan
                $ntf->title = 'Peringatan Mesra: Lantikan pentadbiran yang akan tamat dalam masa 3 Bulan';
                $ntf->content = "Senarai nama lantikan pentadbiran yang akan tamat tempoh dalam masa tiga (3) bulan." . Html::a("&nbsp;<b>Klik Sini</b>", '../tblrscoadminpost/admin-post-list-tamat', ['target' => '_blank']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }
        }
        return ExitCode::OK;
    }

    public function actionPelantikanTamat() {

        $model = Tblrscoadminpost::find()->where(['flag' => '1'])->all();

        foreach ($model as $m) {
            $today = Date('Y-m-d');
            if ($m->end_date < $today) {
                
                $m->flag = '2';
                $m->save(false);
            }
        }

        return ExitCode::OK;
    }

}
