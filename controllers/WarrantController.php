<?php

namespace app\controllers;

use Yii;
use app\models\warrant\TblJawatan;
use app\models\WarrantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * WarrantController implements the CRUD actions for TblJawatan model.
 */
class WarrantController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TblJawatan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WarrantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblJawatan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TblJawatan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new TblJawatan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblJawatan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblJawatan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblJawatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblJawatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblJawatan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionWarrantList($cat = null){
        
        $icno = Yii::$app->user->getId();
// var_dump($cat);die;
        if($cat){
            $model = TblJawatan::find()->where(['kategori'=>$cat,'isActive'=>1])->all();

        }else{
            $model = TblJawatan::find()->where(['isActive'=>1])->all();

        }
        return $this->render('warrant-list', [
          'model' =>$model,
          'bil'=>1,
          'cat'=>$cat
        ]);
    }
    public function actionUpdateWarrant($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if($model->save()){

            }
            return $this->redirect(['warrant-list']);
        }

        return $this->render('update-warrant', [
            'model' => $model,
        ]);
    }
    
    public function actionStatistic(){

        $model = TblJawatan::find()->select('kategori')->distinct()->where(['IN','kategori',['1','2']])->all();         
        //  TblOt::find()->select('icno')->distinct()->where(['month' => $bulan, 'pos_kawalan_id' => $pos])->all();

        $akademik = (new \yii\db\Query())->from('warrant.tbl_jawatan')->where(['kategori' => 1]);
        $pentadbiran = (new \yii\db\Query())->from('warrant.tbl_jawatan')->where(['kategori' => 2]);
        $sum1 = $akademik->sum('jumlah_waran');
        $sum2 = $pentadbiran->sum('jumlah_waran');
        $total = $sum1 + $sum2;
    
        // $model = TblJawatan::find()->where(['isActive'=>1])->all();

        return $this->render('statistic', [
            'model' => $model,
            'sum1'=>$sum1,
            'sum2'=>$sum2,
            'bil' => 1,
            'total'=>$total,
        ]);
    }

}
