<?php

namespace app\controllers;

use Yii;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\models\e_mou\TblMemorandumSearch;
use app\models\e_mou\TblMemorandum;
use app\models\e_mou\TblMemorandumField;
use app\models\e_mou\TblMemorandumReviewHistory;
use app\models\e_mou\TblMemorandumVerifyHistory;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class EMouController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['memorandum-dimeterai', 'memorandum-tunggu-dimeterai', 'memorandum-tidak-lulus', 'view-memorandum', 'memorandum-tunggu-lulus', 'memorandum-telah-sah', 'memorandum-tunggu-sah', 'memorandum-akan-tamat', 'memorandum-tamat-tempoh', 'senarai-memorandum', 'senarai-memorandum-aktif', 'senarai-memorandum-tidak-aktif'],
                'rules' => [
                    [
                        'actions' => ['memorandum-dimeterai', 'memorandum-tunggu-dimeterai', 'memorandum-tidak-lulus', 'view-memorandum', 'memorandum-tunggu-lulus', 'memorandum-tunggu-lulus', 'memorandum-telah-sah', 'memorandum-tunggu-sah', 'memorandum-akan-tamat', 'memorandum-tamat-tempoh', 'senarai-memorandum', 'senarai-memorandum-aktif', 'senarai-memorandum-tidak-aktif'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return  Yii::$app->user->identity->ICNO == '930807125121' ?  true : false;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionMemorandumDimeterai()
    {
        \yii\helpers\Url::remember();
        $searchModel =  new TblMemorandumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('id_seal = 2');
        // $dataProvider->query->orderBy(['memorandum_id' => SORT_DESC]);

        return $this->render('senarai_dimeterai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'titleEmou' => 'Memorandum Telah Dimeterai'
        ]);
    }

    public function actionMemorandumTungguDimeterai()
    {
        \yii\helpers\Url::remember();
        $searchModel =  new TblMemorandumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('id_seal = 1');
        // $dataProvider->query->orderBy(['memorandum_id' => SORT_DESC]);

        return $this->render('senarai_dimeterai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'titleEmou' => 'Memorandum Menunggu Dimeterai'
        ]);
    }

    public function actionMemorandumTidakLulus()
    {
        \yii\helpers\Url::remember();
        $searchModel =  new TblMemorandumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('id_status = 3');
        // $dataProvider->query->orderBy(['memorandum_id' => SORT_DESC]);

        return $this->render('senarai_dimeterai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'titleEmou' => 'Memorandum Tidak Diluluskan'
        ]);
    }

    public function actionMemorandumTungguLulus()
    {
        \yii\helpers\Url::remember();
        $searchModel =  new TblMemorandumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('id_status = 1');
        // $dataProvider->query->orderBy(['memorandum_id' => SORT_DESC]);

        return $this->render('senarai_dimeterai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'titleEmou' => 'Memorandum Menunggu Diluluskan'
        ]);
    }

    public function actionMemorandumBelumHantar()
    {
        \yii\helpers\Url::remember();
        $searchModel =  new TblMemorandumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('id_status = 0');
        // $dataProvider->query->orderBy(['memorandum_id' => SORT_DESC]);

        return $this->render('senarai_dimeterai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'titleEmou' => 'Memorandum Belum Dihantar'
        ]);
    }

    public function actionMemorandumTelahSah()
    {
        \yii\helpers\Url::remember();
        $searchModel =  new TblMemorandumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('id_status = 4');
        // $dataProvider->query->orderBy(['memorandum_id' => SORT_DESC]);

        return $this->render('senarai_dimeterai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'titleEmou' => 'Memorandum Telah Disahkan'
        ]);
    }

    public function actionMemorandumTamatTempoh()
    {
        \yii\helpers\Url::remember();
        $searchModel =  new TblMemorandumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('id_status = 5');
        $dataProvider->query->andWhere('id_verify_update = 2');
        // $dataProvider->query->orderBy(['memorandum_id' => SORT_DESC]);

        return $this->render('senarai_dimeterai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'titleEmou' => 'Memorandum Tamat Tempoh'
        ]);
    }

    public function actionMemorandumAkanTamat()
    {
        \yii\helpers\Url::remember();
        $searchModel =  new TblMemorandumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('id_status = 4');
        $dataProvider->query->andWhere(['!=', 'id_verify_update', 0]);
        $dataProvider->query->andWhere(['<=', 'YEAR(expiration_date)',  date('Y')]);
        // $dataProvider->query->orderBy(['memorandum_id' => SORT_DESC]);

        return $this->render('senarai_dimeterai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'titleEmou' => 'Memorandum Akan Tamat'
        ]);
    }

    public function actionMemorandumTungguSah()
    {
        \yii\helpers\Url::remember();
        $searchModel =  new TblMemorandumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('id_status = 4');
        $dataProvider->query->andWhere(['OR', ['id_verify_update' => 1], ['id_verify_update' => 3]]);
        // $dataProvider->query->andWhere(['<=', 'YEAR(expiration_date)',  date('Y')]);
        // $dataProvider->query->orderBy(['memorandum_id' => SORT_DESC]);

        return $this->render('senarai_dimeterai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'titleEmou' => 'Memorandum Menunggu Pengesahan'
        ]);
    }

    public function actionSenaraiMemorandum()
    {
        \yii\helpers\Url::remember();
        $bar = TblMemorandum::find()->joinWith('department d', false, 'RIGHT JOIN')->select(['COUNT(*) as data, d.fullname as name'])->where(['OR', ['id_status' => 4], ['id_status' => 5]])
            ->groupBy(['d.fullname'])->orderBy(['d.fullname' => SORT_ASC])->asArray()->all();

        $pie = TblMemorandum::find()->joinWith('country c', false, 'RIGHT JOIN')->select(['COUNT(*) as y, c.Country as name'])->where(['OR', ['id_status' => 4], ['id_status' => 5]])
            ->groupBy(['c.Country'])->orderBy(['c.Country' => SORT_ASC])->asArray()->all();

        $pie2 = TblMemorandum::find()->joinWith('emouType e', false, 'RIGHT JOIN')->select(['COUNT(*) as y, e.memorandum_type_desc as name'])->where(['OR', ['id_status' => 4], ['id_status' => 5]])
            ->groupBy(['e.memorandum_type_desc'])->orderBy(['e.memorandum_type_desc' => SORT_ASC])->asArray()->all();

        \yii\helpers\Url::remember();
        $searchModel =  new TblMemorandumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['OR', ['id_status' => 4], ['id_status' => 5]]);

        // $laporan = TblMemorandum::find()->where(['OR', ['id_status' => 4], ['id_status' => 5]]);

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $laporan,
        //     'sort' => ['attributes' => ['id_status']],
        // ]);


        // return \yii\helpers\VarDumper::dump($pie2, 10, true);    

        // $dataProvider->query->andWhere(['<=', 'YEAR(expiration_date)',  date('Y')]);
        // $dataProvider->query->orderBy(['memorandum_id' => SORT_DESC]);

        // \yii\helpers\VarDumper::dump($bar, 10, true);

        return $this->render('senarai_memo', [
            'bar' => $bar,
            'pie' => $pie,
            'pie2' => $pie2,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'titleEmou' => 'Senarai Memorandum'
        ]);
    }

    public function actionSenaraiMemorandumAktif()
    {
        \yii\helpers\Url::remember();
        $bar = TblMemorandum::find()->joinWith('department d', false, 'RIGHT JOIN')->select(['COUNT(*) as data, d.fullname as name'])->where(['id_status' => 4])
            ->groupBy(['d.fullname'])->orderBy(['d.fullname' => SORT_ASC])->asArray()->all();

        $pie = TblMemorandum::find()->joinWith('country c', false, 'RIGHT JOIN')->select(['COUNT(*) as y, c.Country as name'])->where(['id_status' => 4])
            ->groupBy(['c.Country'])->orderBy(['c.Country' => SORT_ASC])->asArray()->all();

        $pie2 = TblMemorandum::find()->joinWith('emouType e', false, 'RIGHT JOIN')->select(['COUNT(*) as y, e.memorandum_type_desc as name'])->where(['id_status' => 4])
            ->groupBy(['e.memorandum_type_desc'])->orderBy(['e.memorandum_type_desc' => SORT_ASC])->asArray()->all();

        \yii\helpers\Url::remember();
        $searchModel =  new TblMemorandumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['id_status' => 4]);

        // $laporan = TblMemorandum::find()->where(['OR', ['id_status' => 4], ['id_status' => 5]]);

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $laporan,
        //     'sort' => ['attributes' => ['id_status']],
        // ]);


        // return \yii\helpers\VarDumper::dump($pie2, 10, true);    

        // $dataProvider->query->andWhere(['<=', 'YEAR(expiration_date)',  date('Y')]);
        // $dataProvider->query->orderBy(['memorandum_id' => SORT_DESC]);

        // \yii\helpers\VarDumper::dump($bar, 10, true);

        return $this->render('senarai_memo', [
            'bar' => $bar,
            'pie' => $pie,
            'pie2' => $pie2,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'titleEmou' => 'Senarai Memorandum Aktif'
        ]);
    }

    public function actionSenaraiMemorandumTidakAktif()
    {
        \yii\helpers\Url::remember();
        $bar = TblMemorandum::find()->joinWith('department d', false, 'RIGHT JOIN')->select(['COUNT(*) as data, d.fullname as name'])->where(['id_status' => 5])
            ->groupBy(['d.fullname'])->orderBy(['d.fullname' => SORT_ASC])->asArray()->all();

        $pie = TblMemorandum::find()->joinWith('country c', false, 'RIGHT JOIN')->select(['COUNT(*) as y, c.Country as name'])->where(['id_status' => 5])
            ->groupBy(['c.Country'])->orderBy(['c.Country' => SORT_ASC])->asArray()->all();

        $pie2 = TblMemorandum::find()->joinWith('emouType e', false, 'RIGHT JOIN')->select(['COUNT(*) as y, e.memorandum_type_desc as name'])->where(['id_status' => 5])
            ->groupBy(['e.memorandum_type_desc'])->orderBy(['e.memorandum_type_desc' => SORT_ASC])->asArray()->all();

        \yii\helpers\Url::remember();
        $searchModel =  new TblMemorandumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['id_status' => 5]);

        // $laporan = TblMemorandum::find()->where(['OR', ['id_status' => 4], ['id_status' => 5]]);

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $laporan,
        //     'sort' => ['attributes' => ['id_status']],
        // ]);


        // return \yii\helpers\VarDumper::dump($pie2, 10, true);    

        // $dataProvider->query->andWhere(['<=', 'YEAR(expiration_date)',  date('Y')]);
        // $dataProvider->query->orderBy(['memorandum_id' => SORT_DESC]);

        // \yii\helpers\VarDumper::dump($bar, 10, true);

        return $this->render('senarai_memo', [
            'bar' => $bar,
            'pie' => $pie,
            'pie2' => $pie2,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'titleEmou' => 'Senarai Memorandum Tidak Aktif'
        ]);
    }

    public function actionViewMemorandum($id)
    {
        $memo = TblMemorandum::find()->where(['memorandum_id' => $id])->one();
        // $jppjk = TblMemorandumVerifyHistory::find()->where(['id_memorandum' => $id])->one();
        // $bpi = TblMemorandumReviewHistory::find()->where(['id_memorandum' => $id])->one();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $memo->emouField,
            'sort' => ['attributes' => ['id_status']],
        ]);

        return $this->renderAjax('view_memo', ['memo' => $memo, 'dataProvider' => $dataProvider]);
    }

    public function actionEditMemorandumSah($id)
    {
        $memo = TblMemorandum::find()->where(['memorandum_id' => $id])->one();
        // $jppjk = TblMemorandumVerifyHistory::find()->where(['id_memorandum' => $id])->one();
        // $bpi = TblMemorandumReviewHistory::find()->where(['id_memorandum' => $id])->one();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $memo->emouField,
            'sort' => ['attributes' => ['id_status']],
        ]);


        return $this->renderAjax('view_memo', ['memo' => $memo, 'dataProvider' => $dataProvider]);
    }

    public function actionUpdateField($field_id, $id_memorandum)
    {
        $model = TblMemorandumField::find()->where(['field_id' => $field_id, 'id_memorandum' => $id_memorandum])->one();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save(false)) {
                if (Yii::$app->request->isAjax) {
                    // JSON response is expected in case of successful save
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['success' => true];
                }
                return $this->redirect(['view-memorandum', 'id' => $id_memorandum]);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_formField', [
                'model' => $model,
            ]);
        } else {
            return $this->render('_formField', [
                'model' => $model,
            ]);
        }
    }
}
