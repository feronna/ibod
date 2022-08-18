<?php

namespace app\controllers;

use Yii;
use app\models\kualiti\Kualiti;
use app\models\kualiti\KualitiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblprcobiodata;
use yii\web\UploadedFile;
use app\models\system_core\TblUserAccess;

/**
 * KualitiController implements the CRUD actions for Kualiti model.
 */
class KualitiController extends Controller
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
     * Lists all Kualiti models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KualitiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIsms()
    {
        $searchModel = new KualitiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('isms', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDownload($id)
    {
        $download = Kualiti::findOne($id);
        $path = Yii::getAlias('@https://mediahost.ums.edu.my') . '/api/v1/viewFile/' . $download->file;


        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path);
        }
    }

    public function actionManual()
    {

        $icno = Yii::$app->user->getId();
        $access = TblUserAccess::findOne(['icno' => $icno, 'access' => 5]);
        $isms = TblUserAccess::findOne(['icno' => $icno, 'access' => 6]);
        if ($isms) {
            $searchModel = new KualitiSearch();
            $dataProvider = Kualiti::find()->where(['=', 'kategori_id', 1])
                ->andWhere(['id_type' => 2])
                ->orderBy(['no_prosedur' => SORT_ASC, 'susunan' => SORT_ASC, 'tajuk_prosedur' => SORT_ASC]);

            $query = new ActiveDataProvider([
                'query' => $dataProvider,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
        } else {
            $searchModel = new KualitiSearch();
            $dataProvider = Kualiti::find()->where(['=', 'kategori_id', 1])
                ->orderBy(['no_prosedur' => SORT_ASC, 'susunan' => SORT_ASC, 'tajuk_prosedur' => SORT_ASC]);

            $query = new ActiveDataProvider([
                'query' => $dataProvider,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
        }

        $searchModel = new KualitiSearch();
        if (Yii::$app->request->queryParams) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('manual', [
            'dataProvider' => $dataProvider,
            'query' => $query,
            'access' => $access,
            'isms' => $isms,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Kualiti model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewManual($id)
    {
        return $this->render('view-manual', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Kualiti model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionTambahManual()
    {
        $icno = Yii::$app->user->getId();
        $model = new Kualiti();
        $model->insert_date = date('Y-m-d H:i:s');
        $model->update_id = $icno;
        $model->kategori_id = 1;
        $isms = TblUserAccess::findOne(['icno' => $icno, 'access' => 6]);

        // $dept = Tblprcobiodata::findOne(['ICNO' => $icno]);

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                // if ($model->save()) {
                $fileapi = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Kualiti/dokumen_sokongan');
                if ($fileapi->status == true) {
                    $model->file = $fileapi->file_name_hashcode;
                    if ($isms) {
                        $model->id_type = 2;
                    } else {
                        $model->id_type = 1;
                    }
                    $model->save(false);
                    //
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                    return $this->redirect(['kualiti/manual']);
                    // }
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen.']);
            }
        }

        return $this->render('tambah-manual', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Kualiti model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateManual($id)
    {
        $icno = Yii::$app->user->getId();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->tempFile = UploadedFile::getInstance($model, 'tempFile');

            if ($model->tempFile) {
                $flag = true;
                $fileapi = Yii::$app->FileManager->UploadFile($model->tempFile->name, $model->tempFile->tempName, '04', 'Kualiti/dokumen_sokongan');
                if ($fileapi->status == true) {
                    $model->file = $fileapi->file_name_hashcode;
                } else {
                    $flag = false;
                }
            } else if ($model->file) {
                $flag = true;
            } else {
                $flag = false;

                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen.']);
            }

            if ($flag == true) {
                $model->update_date = date('Y-m-d H:i:s');
                $model->update_id = $icno;
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                return $this->redirect(['view-manual', 'id' => $model->msiso_id]);
            }
        }

        return $this->render('update-manual', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Kualiti model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteManual($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        return $this->redirect(['manual']);
    }

    public function actionProsedurKhusus()
    {

        // $searchModel = new KualitiSearch();
        $icno = Yii::$app->user->getId();
        $access = TblUserAccess::findOne(['icno' => $icno, 'access' => 5]);
        $isms = TblUserAccess::findOne(['icno' => $icno, 'access' => 6]);
        if ($isms) {
            $dataProvider = Kualiti::find()->where(['=', 'kategori_id', 2])
                ->andWhere(['id_type' => 2])
                ->orderBy(['susunan' => SORT_ASC, 'no_prosedur' => SORT_ASC, 'tajuk_prosedur' => SORT_ASC]);

            $query = new ActiveDataProvider([
                'query' => $dataProvider,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
        } else {
            $dataProvider = Kualiti::find()->where(['=', 'kategori_id', 2])
                ->orderBy(['susunan' => SORT_ASC, 'no_prosedur' => SORT_ASC, 'tajuk_prosedur' => SORT_ASC]);

            $query = new ActiveDataProvider([
                'query' => $dataProvider,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
        }
        $searchModel = new KualitiSearch();
        if (Yii::$app->request->queryParams) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('prosedur-khusus', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'query' => $query,
            'access' => $access,
            'isms' => $isms,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionViewPk($id)
    {
        return $this->render('view-pk', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTambahPk()
    {
        $icno = Yii::$app->user->getId();
        $model = new Kualiti();
        $model->insert_date = date('Y-m-d H:i:s');
        $model->update_id = $icno;
        $model->kategori_id = 2;
        $isms = TblUserAccess::findOne(['icno' => $icno, 'access' => 6]);

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');
            // $model->nama_fail = $model->file;


            if ($model->file) {
                // if ($model->save()) {

                $fileapi = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Kualiti');
                if ($fileapi->status == true) {
                    $model->file = $fileapi->file_name_hashcode;
                    if ($isms) {
                        $model->id_type = 2;
                    } else {
                        $model->id_type = 1;
                    }
                    $model->save(false);
                    //
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                    return $this->redirect(['kualiti/prosedur-khusus']);
                }
                // }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen.']);
            }
        }

        return $this->render('tambah-pk', [
            'model' => $model,
        ]);
    }

    public function actionUpdatePk($id)
    {
        $icno = Yii::$app->user->getId();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->tempFile = UploadedFile::getInstance($model, 'tempFile');

            if ($model->tempFile) {
                $flag = true;
                $fileapi = Yii::$app->FileManager->UploadFile($model->tempFile->name, $model->tempFile->tempName, '04', 'Kualiti/dokumen_sokongan');
                if ($fileapi->status == true) {
                    $model->file = $fileapi->file_name_hashcode;
                } else {
                    $flag = false;
                }
            } else if ($model->file) {
                $flag = true;
            } else {
                $flag = false;
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen.']);
            }

            if ($flag == true) {
                $model->update_date = date('Y-m-d H:i:s');
                $model->update_id = $icno;
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                return $this->redirect(['view-pk', 'id' => $model->msiso_id]);
            }
        }

        return $this->render('update-pk', [
            'model' => $model,
        ]);
    }

    public function actionDeletePk($id)
    {
        $this->findModel($id)->delete();

        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        return $this->redirect(['prosedur-khusus']);
    }

    public function actionDeleteFile($id, $title)
    {

        $model = Kualiti::findOne($id);
        $res = Yii::$app->FileManager->DeleteFile($model->file);
        $model->file = NULL;
        if ($model->kategori_id == 1) {
            $re = 'view-manual';
        } elseif ($model->kategori_id == 2) {
            $re = 'view-pk';
        } elseif ($model->kategori_id == 3) {
            $re = 'view-pu';
        } elseif ($model->kategori_id == 4) {
            $re = 'view-dokumenrujukan';
        } elseif ($model->kategori_id == 5) {
            $re = 'view-auditkit';
        }

        if ($res->status == true) {
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Fail berjaya dibuang']);
            return $this->redirect([$re, 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Fail tidak berjaya dibuang']);
            return $this->redirect([$re, 'id' => $id]);
        }
    }

    public function actionProsedurUmum($page = null)
    {

        // $searchModel = new KualitiSearch();
        $icno = Yii::$app->user->getId();
        $access = TblUserAccess::findOne(['icno' => $icno, 'access' => 5]);
        $isms = TblUserAccess::findOne(['icno' => $icno, 'access' => 6]);
        if ($isms) {
            $dataProvider = Kualiti::find()->where(['=', 'kategori_id', 3])
                ->andWhere(['id_type' => 2])
                ->orderBy(['no_prosedur' => SORT_ASC, 'susunan' => SORT_ASC, 'tajuk_prosedur' => SORT_ASC]);

            $query = new ActiveDataProvider([
                'query' => $dataProvider,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
        } else {
            $dataProvider = Kualiti::find()->where(['=', 'kategori_id', 3])
                ->orderBy(['no_prosedur' => SORT_ASC, 'susunan' => SORT_ASC, 'tajuk_prosedur' => SORT_ASC]);

            $query = new ActiveDataProvider([
                'query' => $dataProvider,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
        }
        $searchModel = new KualitiSearch();
        if (Yii::$app->request->queryParams) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('prosedur-umum', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'query' => $query,
            'access' => $access,
            'isms' => $isms,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionViewPu($id)
    {
        return $this->render('view-pu', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTambahPu()
    {
        $icno = Yii::$app->user->getId();
        $model = new Kualiti();
        $model->insert_date = date('Y-m-d H:i:s');
        $model->update_id = $icno;
        $model->kategori_id = 3;
        $isms = TblUserAccess::findOne(['icno' => $icno, 'access' => 6]);

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');
            // $model->nama_fail = $model->file;

            if ($model->file) {
                // if ($model->save()) {

                $fileapi = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Kualiti');
                if ($fileapi->status == true) {
                    $model->file = $fileapi->file_name_hashcode;
                    // $model->nama_fail = $fileapi->file_name;
                    if ($isms) {
                        $model->id_type = 2;
                    } else {
                        $model->id_type = 1;
                    }
                    $model->save(false);
                    //
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                    return $this->redirect(['kualiti/prosedur-umum']);
                }
                // }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen.']);
            }
        }

        return $this->render('tambah-pu', [
            'model' => $model,
        ]);
    }

    public function actionUpdatePu($id)
    {
        $icno = Yii::$app->user->getId();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->tempFile = UploadedFile::getInstance($model, 'tempFile');

            if ($model->tempFile) {
                $flag = true;
                $fileapi = Yii::$app->FileManager->UploadFile($model->tempFile->name, $model->tempFile->tempName, '04', 'Kualiti/dokumen_sokongan');
                if ($fileapi->status == true) {
                    $model->file = $fileapi->file_name_hashcode;
                } else {
                    $flag = false;
                }
            } else if ($model->file) {
                $flag = true;
            } else {
                $flag = false;
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen.']);
            }

            if ($flag == true) {
                $model->update_date = date('Y-m-d H:i:s');
                $model->update_id = $icno;
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                return $this->redirect(['view-pu', 'id' => $model->msiso_id]);
            }
        }

        return $this->render('update-pu', [
            'model' => $model,
        ]);
    }

    public function actionDeletePu($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        return $this->redirect(['prosedur-umum']);
    }

    public function actionAuditKit()
    {

        $icno = Yii::$app->user->getId();
        $access = TblUserAccess::findOne(['icno' => $icno, 'access' => 5]);
        $isms = TblUserAccess::findOne(['icno' => $icno, 'access' => 6]);
        if ($isms) {
            $dataProvider = Kualiti::find()->where(['=', 'kategori_id', 5])
                ->andWhere(['id_type' => 2])
                ->orderBy(['no_prosedur' => SORT_ASC, 'susunan' => SORT_ASC, 'tajuk_prosedur' => SORT_ASC]);

            $query = new ActiveDataProvider([
                'query' => $dataProvider,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
        } else {
            $dataProvider = Kualiti::find()->where(['=', 'kategori_id', 5])
                ->orderBy(['no_prosedur' => SORT_ASC, 'susunan' => SORT_ASC, 'tajuk_prosedur' => SORT_ASC]);

            $query = new ActiveDataProvider([
                'query' => $dataProvider,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
        }
        $searchModel = new KualitiSearch();
        if (Yii::$app->request->queryParams) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('audit-kit', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'query' => $query,
            'access' => $access,
            'isms' => $isms,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionViewAuditkit($id)
    {
        return $this->render('view-auditkit', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTambahAuditkit()
    {
        $icno = Yii::$app->user->getId();
        $model = new Kualiti();
        $model->insert_date = date('Y-m-d H:i:s');
        $model->update_id = $icno;
        $model->kategori_id = 5;
        $isms = TblUserAccess::findOne(['icno' => $icno, 'access' => 6]);
        // $dept = Tblprcobiodata::findOne(['ICNO' => $icno]);

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');
            // $model->nama_fail = $model->file;


            if ($model->file) {
                // if ($model->save()) {

                $fileapi = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Kualiti');
                if ($fileapi->status == true) {
                    $model->file = $fileapi->file_name_hashcode;
                    if ($isms) {
                        $model->id_type = 2;
                    } else {
                        $model->id_type = 1;
                    }
                    // $model->nama_fail = $fileapi->file_name;
                    $model->save(false);
                    //
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                    return $this->redirect(['kualiti/tambah-auditkit']);
                }
                // }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen.']);
            }
        }

        return $this->render('tambah-auditkit', [
            'model' => $model,
        ]);
    }

    public function actionUpdateAuditkit($id)
    {
        $icno = Yii::$app->user->getId();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->tempFile = UploadedFile::getInstance($model, 'tempFile');

            if ($model->tempFile) {
                $flag = true;
                $fileapi = Yii::$app->FileManager->UploadFile($model->tempFile->name, $model->tempFile->tempName, '04', 'Kualiti/dokumen_sokongan');
                if ($fileapi->status == true) {
                    $model->file = $fileapi->file_name_hashcode;
                } else {
                    $flag = false;
                }
            } else if ($model->file) {
                $flag = true;
            } else {
                $flag = false;
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen.']);
            }

            if ($flag == true) {
                $model->update_date = date('Y-m-d H:i:s');
                $model->update_id = $icno;
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                return $this->redirect(['view-auditkit', 'id' => $model->msiso_id]);
            }
        }

        return $this->render('update-auditkit', [
            'model' => $model,
        ]);
    }

    public function actionDeleteAuditkit($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        return $this->redirect(['audit-kit']);
    }

    public function actionDokumenRujukan()
    {

        // $searchModel = new KualitiSearch();
        $icno = Yii::$app->user->getId();
        $access = TblUserAccess::findOne(['icno' => $icno, 'access' => 5]);
        $isms = TblUserAccess::findOne(['icno' => $icno, 'access' => 6]);

        if ($isms) {
            $dataProvider = Kualiti::find()->where(['=', 'kategori_id', 4])
                ->andWhere(['id_type' => 2])
                ->orderBy(['no_prosedur' => SORT_ASC, 'susunan' => SORT_ASC, 'tajuk_prosedur' => SORT_ASC]);
            $query = new ActiveDataProvider([
                'query' => $dataProvider,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
            $searchModel = new KualitiSearch();
            if (Yii::$app->request->queryParams) {
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            }
        } else {
            $dataProvider = Kualiti::find()->where(['=', 'kategori_id', 4])
                ->orderBy(['no_prosedur' => SORT_ASC, 'susunan' => SORT_ASC, 'tajuk_prosedur' => SORT_ASC]);
            $query = new ActiveDataProvider([
                'query' => $dataProvider,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
            $searchModel = new KualitiSearch();
            if (Yii::$app->request->queryParams) {
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            }
        }

        return $this->render('dokumen-rujukan', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'query' => $query,
            'access' => $access,
            'isms' => $isms,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionViewDokumenrujukan($id)
    {
        return $this->render('view-dokumenrujukan', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTambahDokumenrujukan()
    {
        $icno = Yii::$app->user->getId();
        $model = new Kualiti();
        $model->insert_date = date('Y-m-d H:i:s');
        $model->update_id = $icno;
        $model->kategori_id = 4;
        $isms = TblUserAccess::findOne(['icno' => $icno, 'access' => 6]);
        // $dept = Tblprcobiodata::findOne(['ICNO' => $icno]);

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');
            // $model->nama_fail = $model->file;


            if ($model->file) {
                // if ($model->save()) {

                $fileapi = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Kualiti');
                if ($fileapi->status == true) {
                    $model->file = $fileapi->file_name_hashcode;
                    if ($isms) {
                        $model->id_type = 2;
                    } else {
                        $model->id_type = 1;
                    }
                    // $model->nama_fail = $fileapi->file_name;
                    $model->save(false);
                    //
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                    return $this->redirect(['kualiti/tambah-dokumenrujukan']);
                }
                // }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen.']);
            }
        }

        return $this->render('tambah-dokumenrujukan', [
            'model' => $model,
        ]);
    }

    public function actionUpdateDokumenrujukan($id)
    {
        $icno = Yii::$app->user->getId();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->tempFile = UploadedFile::getInstance($model, 'tempFile');

            if ($model->tempFile) {
                $flag = true;
                $fileapi = Yii::$app->FileManager->UploadFile($model->tempFile->name, $model->tempFile->tempName, '04', 'Kualiti/dokumen_sokongan');
                if ($fileapi->status == true) {
                    $model->file = $fileapi->file_name_hashcode;
                } else {
                    $flag = false;
                }
            } else if ($model->file) {
                $flag = true;
            } else {
                $flag = false;
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen.']);
            }

            if ($flag == true) {
                $model->update_date = date('Y-m-d H:i:s');
                $model->update_id = $icno;
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                return $this->redirect(['view-dokumenrujukan', 'id' => $model->msiso_id]);
            }
        }

        return $this->render('update-dokumenrujukan', [
            'model' => $model,
        ]);
    }

    public function actionDeleteDokumenrujukan($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        return $this->redirect(['dokumen-rujukan']);
    }

    public function actionPelanAudit()
    {

        // $searchModel = new KualitiSearch();
        $dataProvider = Kualiti::find()->where(['=', 'kategori_id', 6]);

        $query = new ActiveDataProvider([
            'query' => $dataProvider,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        return $this->render('pelan-audit', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'query' => $query,
        ]);
    }

    public function actionTambahPelanaudit()
    {
        $icno = Yii::$app->user->getId();
        $model = new Kualiti();
        $model->insert_date = date('Y-m-d H:i:s');
        $model->update_id = $icno;
        $model->kategori_id = 6;
        // $dept = Tblprcobiodata::findOne(['ICNO' => $icno]);

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file) {
                if ($model->save()) {

                    $fileapi = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Kualiti');
                    if ($fileapi->status == true) {
                        $model->file = $fileapi->file_name_hashcode;
                        // $model->nama_fail = $fileapi->file_name;
                        $model->save(false);
                        //
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                        return $this->redirect(['kualiti/tambah-pelanaudit']);
                    }
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen.']);
            }
        }

        return $this->render('tambah-pelanaudit', [
            'model' => $model,
        ]);
    }

    public function actionUpdatePelanaudit($id)
    {
        $icno = Yii::$app->user->getId();
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                if ($model->save()) {

                    $fileapi = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Kualiti/dokumen_sokongan');
                    if ($fileapi->status == true) {
                        $model->file = $fileapi->file_name_hashcode;
                        // $model->nama_fail = $fileapi->file_name;
                        $model->update_date = date('Y-m-d H:i:s');
                        $model->update_id = $icno;
                        $model->save(false);
                        //
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                        return $this->redirect(['view-pelanaudit', 'id' => $model->msiso_id]);
                    }
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen.']);
            }
        }

        return $this->render('update-pelanaudit', [
            'model' => $model,
        ]);
    }

    public function actionDeletePelanaudit($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        return $this->redirect(['pelan-audit']);
    }

    public function actionCarian()
    {
        $icno = Yii::$app->user->getId();
        $access = TblUserAccess::findOne(['icno' => $icno, 'access' => 5]);
        $model = Kualiti::find()
            ->orderBy(['kategori_id' => SORT_ASC, 'susunan' => SORT_ASC, 'no_prosedur' => SORT_ASC, 'tajuk_prosedur' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
        ]);

        $searchModel = new KualitiSearch();
        if (Yii::$app->request->queryParams) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        return $this->render('carian', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'access' => $access,
        ]);
    }




    /**
     * Finds the Kualiti model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kualiti the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kualiti::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
