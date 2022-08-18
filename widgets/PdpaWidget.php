<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\system_core\TblPdpa;
use Yii;
use yii\helpers\Url;

class PdpaWidget extends Widget {

//    public $model;
//    public $icno;

    public function init() {
        parent::init();

//        $this->icno = Yii::$app->user->getId();
    }

    public function run() {

        $icno = Yii::$app->user->getId();
        $model = TblPdpa::find()->where(['icno' => $icno])->one();
        $date = date("d/m/Y H:i A");
        
        $bio = \app\models\hronline\Tblprcobiodata::findOne(['ICNO'=>$icno]);
        
        if ($post = Yii::$app->request->post()) {

            if ($post['agree'] == 1) {

                $model = new TblPdpa();
                $model->icno = $icno;
                $model->accept_dt = date('Y-m-d H:i:s');
                if ($model->save(false)) {

                    if (Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Anda telah bersetuju!'])) {
                        Yii::$app->response->redirect(Url::to(['site/login']));
                    }
                }
            } else if ($post['agree'] == 0) {
                Yii::$app->response->redirect(Url::to(['site/logout']));
            }
        }


        return $this->render('pdpa/index', ['model' => $model, 'bio'=>$bio, 'date'=>$date]);
    }

}

?>