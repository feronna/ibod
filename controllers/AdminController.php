<?php

namespace app\controllers;

use Yii;
use app\models\system_core\TblAnnouncements;
use app\models\system_core\TblAnnouncementsSearch;
use Http\Discovery\Exception\NotFoundException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class AdminController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'remove-staff' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAnnouncementList()
    {

        $searchModel = new TblAnnouncementsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('announcement\announcement-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new TblAnnouncements model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $icno = Yii::$app->user->getId();

        $model = new TblAnnouncements();

        if ($model->load(Yii::$app->request->post())) {

            $model->create_by = $icno;
            $model->create_dt = date('Y-m-d H:i:s');
            // $model->file = UploadedFile::getInstance($model, 'file');
            // if ($model->file) {
            //     $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '01', 'Hrv4 Announcement');

            //     if ($datas->status == true) {
            //         $model->file_name_hashcode = $datas->file_name_hashcode;
            //     }
            // }

            if ($model->save(false)) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat telah disimpan']);
                return $this->redirect(['announcement-list']);
            }
        }

        return $this->render('announcement\create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblAnnouncements model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $icno = Yii::$app->user->getId();

        if ($model->load($post = Yii::$app->request->post())) {

            $model->full_dt = $post['TblAnnouncements']['full_dt'];
            $model->update_by = $icno;
            $model->update_dt = date('Y-m-d H:i:s');

            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '01', 'Hrv4 Announcement');

                if ($datas->status == true) {
                    $model->file_name_hashcode = $datas->file_name_hashcode;
                }
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat telah dikemaskini']);
                return $this->redirect(['announcement-list']);
            }
        }

        return $this->render('announcement/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblAnnouncements model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {

            if ($model->file_name_hashcode) {
                Yii::$app->FileManager->DeleteFile($model->file_name_hashcode);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengumuman telah dibuang!']);
            return $this->redirect(['announcement-list']);
        }
    }

    /**
     * Finds the TblAnnouncements model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblAnnouncements the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblAnnouncements::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundException('The requested page does not exist.');
    }
}
