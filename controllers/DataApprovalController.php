<?php

namespace app\controllers;

use app\models\hronline\Tblapproval;
use yii\helpers\VarDumper;

class DataApprovalController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView(){
        $model = Tblapproval::find()->orderBy(['id'=>SORT_DESC])->one();
        $data = (object)$model->table::find()->where(['id'=>$model->idval])->one();

        VarDumper::dump( $data, $depth = 10, $highlight = true);
        die;
    }

}
