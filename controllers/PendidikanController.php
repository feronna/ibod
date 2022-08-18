<?php

namespace app\controllers;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblpendidikan;
use app\models\hronline\TblpendidikanSearch;
use app\models\hronline\Tblsubjek;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\Publications;
use app\models\hronline\Tblprclinicalcert;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\db\Exception;


class PendidikanController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-pub' => ['POST'],
                    'admin-delete-pub' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'index', 'view', 'adminview', 'lihatpendidikan', 'adminlihatpendidikan', 'tambahpendidikan', 'admintambahpendidikan',
                    'update', 'adminupdate', 'delete', 'admindelete', 'deletegambar', 'admindeletegambar', 'view-subjek',
                    'tambah-subjek', 'admintambah-subjek', 'kemaskini-subjek', 'adminkemaskini-subjek', 'padam-subjek', 'adminpadam-subjek',
                    'admin-add-pub','admin-update-pub',
                ],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
                    [
                        'actions' => [
                            'index', 'adminview', 'adminlihatpendidikan', 'admintambahpendidikan', 'adminupdate', 'admindelete',
                            'admindeletegambar'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $access = Yii::$app->user->identity->accessLevel;
                            $secondaccess = Yii::$app->user->identity->accessSecondLevel;
                            switch ($access) {
                                case '1':
                                    return true;
                                    break;
                                case '2':

                                    if (in_array($secondaccess, ['1', '3'])) {
                                        return true;
                                    }
                                    if (in_array($secondaccess, ['4', '5', '6'])) {
                                        return true;
                                    }
                                    return false;
                                    break;
                                case '3':
                                    if (in_array($secondaccess, ['7', '8', '9'])) {
                                        return true;
                                    }
                                    return false;
                                    break;

                                default:
                                    return false;
                                    break;
                            }
                        }
                    ],
                    [
                        'actions' => ['admintambah-subjek'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $access = Yii::$app->user->identity->accessLevel;
                            $icno = Yii::$app->request->get('icno');
                            $Edu_id = Yii::$app->request->get('Edu_id');
                            $check = Tblpendidikan::findAll(['id' => $Edu_id, 'ICNO' => $icno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $access === 1 && $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['adminkemaskini-subjek', 'adminpadam-subjek'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $access = Yii::$app->user->identity->accessLevel;
                            $id = Yii::$app->request->get('id');
                            $check = Tblsubjek::findOne(['id' => $id]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $access === 1 && $boleh === true;
                        }
                    ],
                    [
                        'actions' => [
                            'lihatpendidikan', 'update', 'delete', 'deletegambar',
                            'add-pub', 'update-pub','admin-add-pub','admin-update-pub',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $icno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $check = Tblpendidikan::findAll(['id' => $id, 'ICNO' => $icno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['view-subjek', 'tambah-subjek'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $icno = Yii::$app->user->getId();
                            $Edu_id = Yii::$app->request->get('Edu_id');
                            $check = Tblpendidikan::findAll(['id' => $Edu_id, 'ICNO' => $icno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['kemaskini-subjek', 'padam-subjek'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $icno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $check = Tblsubjek::findAll(['id' => $id, 'ICNO' => $icno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['view', 'tambahpendidikan', 'add-pub', 'update-pub','admin-add-pub','admin-update-pub',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionView()
    {
        $icno = Yii::$app->user->getId();
        $degree = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['in', '`educationallevel`.`HighestEduLevelRank`', [1,2,3]])->all();
        $diploma = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['in', '`educationallevel`.`HighestEduLevelRank`', [4]])->all();
        $sijil = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['in', '`educationallevel`.`HighestEduLevelRank`', [5]])->all();
        $spm = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['in', '`educationallevel`.`HighestEduLevelRank`', [6]])->all();
        $pmr = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['in', '`educationallevel`.`HighestEduLevelRank`', [7]])->all();
        $lainlain = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['in', '`educationallevel`.`HighestEduLevelRank`', [8,9,10]])->all();

        $publication = Publications::find()->where(['icno' => $icno])->all();

        return $this->render('view', [
            'degree' => $degree,
            'diploma' => $diploma,
            'sijil' => $sijil,
            'spm' => $spm,
            'pmr' => $pmr,
            'lainlain' => $lainlain,
            'publication' => $publication,
        ]);
    }

    public function actionAdminview($icno)
    {
        if ($this->findModel($icno)) {
            $degree = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['in', '`educationallevel`.`HighestEduLevelRank`', [1, 2, 3]])->all();
            $diploma = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['in', '`educationallevel`.`HighestEduLevelRank`', [4]])->all();
            $sijil = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['in', '`educationallevel`.`HighestEduLevelRank`', [5]])->all();
            $spm = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['in', '`educationallevel`.`HighestEduLevelRank`', [6]])->all();
            $pmr = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['in', '`educationallevel`.`HighestEduLevelRank`', [7]])->all();
            $lainlain = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['in', '`educationallevel`.`HighestEduLevelRank`', [8, 9, 10]])->all();

            $publication = Publications::find()->where(['icno' => $icno])->all();

            return $this->render('adminview', [
                'degree' => $degree,
                'diploma' => $diploma,
                'sijil' => $sijil,
                'spm' => $spm,
                'pmr' => $pmr,
                'lainlain' => $lainlain,
                'ICNO' => $icno,
                'publication' => $publication,
            ]);
        }
    }

    public function actionLihatpendidikan($id)
    {
        $model = $this->findModelbyid($id);
        $subjek = Tblsubjek::find()->where(['ICNO' => $model->ICNO, 'Edu_id' => $id])->all();
        $mustaddsubjek = [13, 14, 15, 23];
        if (in_array($model->HighestEduLevelCd, $mustaddsubjek)) {
            switch ($model->HighestEduLevelCd) {
                case '13':
                    $title = 'STPM/STP/HSC';
                    break;
                case '14':
                    $title = 'SPM/MCE/Setaraf';
                    break;
                case '15':
                    $title = 'PMR/SRP/LCE/Setaraf';
                    break;
                case '23':
                    $title = 'SPVM';
                    break;
            }
            return $this->render('lihatpendidikan', [
                'model' => $model,
                'Edu_id' => $id,
                'subjek' => $subjek,
                'level' => $title,
            ]);
        }

        return $this->render('lihatpendidikan', [
            'model' => $model,
        ]);
    }
    public function actionAdminlihatpendidikan($id)
    {
        $model = $this->findModelbyid($id);
        $subjek = Tblsubjek::find()->where(['ICNO' => $model->ICNO, 'Edu_id' => $id])->all();
        $mustaddsubjek = [13, 14, 15, 23];
        if (in_array($model->HighestEduLevelCd, $mustaddsubjek)) {
            switch ($model->HighestEduLevelCd) {
                case '13':
                    $title = 'STPM/STP/HSC';
                    break;
                case '14':
                    $title = 'SPM/MCE/Setaraf';
                    break;
                case '15':
                    $title = 'PMR/SRP/LCE/Setaraf';
                    break;
                case '23':
                    $title = 'SPVM';
                    break;
            }
            return $this->render('adminlihatpendidikan', [
                'model' => $model,
                'subjek' => $subjek,
                'level' => $title,
            ]);
        }
        return $this->render('adminlihatpendidikan', [
            'model' => $model,
        ]);
    }

    public function actionTambahpendidikan($key = null)
    {   
        if($key != null && $key == 'clCert'){
            return $this->redirect(['add-cl-cert']);
        }

        $mustaddsubjek = [13, 14, 15, 23];
        $icno = Yii::$app->user->getId();
        $model = new Tblpendidikan();
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                if ($model->save()) {
                    $id = $model->id;
                    $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/Pendidikan');

                    if ($res->status == true) {
                        $model->filename = $res->file_name_hashcode;
                        $model->save();
                        self::setHighEdu($icno, $id);
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);

                        if (in_array($model->HighestEduLevelCd, $mustaddsubjek)) {
                            return $this->redirect(['view-subjek', 'Edu_id' => $id]);
                        }
                        return $this->redirect(['lihatpendidikan', 'id' => $id]);
                    } else {

                        Tblpendidikan::deleteAll(['id' => $id]);
                        Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                        return $this->redirect(['view']);
                    }
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik dokumen berkaitan!']);
            }
        }

        return $this->render('tambahpendidikan', [
            'model' => $model,
        ]);
    }

    public function actionAdmintambahpendidikan($icno)
    {

        $mustaddsubjek = [13, 14, 15, 23];
        $model = new Tblpendidikan();
        $model->ICNO = $icno;
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                if ($model->save()) {
                    $id = $model->id;
                    $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/Pendidikan');

                    if ($res->status == true) {
                        $model->filename = $res->file_name_hashcode;
                        $model->save();
                        self::setHighEdu($icno, $id);
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        if (in_array($model->HighestEduLevelCd, $mustaddsubjek)) {
                            return $this->redirect(['adminview-subjek', 'Edu_id' => $id]);
                        }
                        return $this->redirect(['adminlihatpendidikan', 'id' => $id]);
                    } else {

                        Tblpendidikan::deleteAll(['id' => $id]);
                        Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                        return $this->redirect(['adminview', 'icno' => $icno]);
                    }
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik dokumen berkaitan!']);
            }
        }

        if ($this->findModel($icno)) {
            return $this->render('admintambahpendidikan', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {

        $model = $this->findModelbyid($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->Bon == 0) {
                $model->JumlahBon = NULL;
            }
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                if ($model->save()) {
                    $id = $model->id;
                    $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/Pendidikan');

                    if ($datas->status == true) {
                        $model->filename = $datas->file_name_hashcode;
                        $model->save();
                        self::setHighEdu($model->ICNO, $id);
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        return $this->redirect(['lihatpendidikan', 'id' => $id]);
                    } else {
                        Tblpendidikan::deleteAll(['id' => $id]);
                        Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                        return $this->redirect(['view']);
                    }
                }
            } elseif (!empty($model->filename) && $model->filename != 'deleted') {
                if ($model->save()) {
                    self::setHighEdu($model->ICNO, $id);
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    return $this->redirect(['lihatpendidikan', 'id' => $id]);
                }
            } else {
                Yii::$app->session->setFlash('Gagal', "Sila Upload file");
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAdminupdate($id)
    {

        $model = $this->findModelbyid($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->Bon == 0) {
                $model->JumlahBon = NULL;
            }
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                if ($model->save()) {
                    $id = $model->id;
                    $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/Pendidikan');

                    if ($datas->status == true) {
                        $model->filename = $datas->file_name_hashcode;
                        $model->save();
                        self::setHighEdu($model->ICNO, $id);
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        return $this->redirect(['adminlihatpendidikan', 'id' => $id]);
                    } else {
                        Tblpendidikan::deleteAll(['id' => $id]);
                        Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                        return $this->redirect(['adminview', 'icno' => $model->ICNO]);
                    }
                }
            } elseif (!empty($model->filename) && $model->filename != 'deleted') {
                if ($model->save()) {
                    self::setHighEdu($model->ICNO, $id);
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    return $this->redirect(['adminlihatpendidikan', 'id' => $id]);
                }
            } else {
                Yii::$app->session->setFlash('Gagal', "Sila Upload file");
            }
        }
        return $this->render('adminupdate', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $mustdelete = [13, 14, 15, 23];
        $model = $this->findModelbyid($id);
        if ($model->delete()) {
            if (!empty($model->filename) && $model->filename != 'deleted') {
                $res = Yii::$app->FileManager->DeleteFile($model->filename);
                if ($res->status == true) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang']);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang, File tidak berjaya dipadam!']);
                }
            }
            if (in_array($model->HighestEduLevelCd, $mustdelete)) {
                Tblsubjek::deleteAll(['ICNO' => $model->ICNO, 'EduLevel_id' => $model->HighestEduLevelCd]);
            }
            if ($model->HighEdu == '1') {
                self::setBioEduAD($model->ICNO);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat tidak berjaya Dibuang']);
        }
        return $this->redirect(['view']);
    }

    public function actionAdmindelete($id)
    {
        $mustdelete = [13, 14, 15, 23];
        $model = $this->findModelbyid($id);
        if ($model->delete()) {
            if (!empty($model->filename) && $model->filename != 'deleted') {
                $res = Yii::$app->FileManager->DeleteFile($model->filename);
                if ($res->status == true) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang']);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang, File tidak berjaya dipadam!']);
                }
            }
            if (in_array($model->HighestEduLevelCd, $mustdelete)) {
                Tblsubjek::deleteAll(['ICNO' => $model->ICNO, 'EduLevel_id' => $model->HighestEduLevelCd]);
            }
            if ($model->HighEdu == '1') {
                self::setBioEduAD($model->ICNO);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'success', 'msg' => 'Maklumat tidak berjaya Dibuang']);
        }
        return $this->redirect(['adminview', 'icno' => $model->ICNO]);
    }

    public function actionDeletegambar($id)
    {
        $model = Tblpendidikan::findOne($id);
        if (!empty($model->filename && $model->filename != 'deleted')) {
            $res = Yii::$app->FileManager->DeleteFile($model->filename);
            if ($res->status == true) {
                $model->filename = 'deleted';
                $model->update();
            }
        }
        return $this->redirect(['update', 'id' => $id]);
    }


    public function actionAdmindeletegambar($id)
    {
        $model = Tblpendidikan::findOne($id);
        if (!empty($model->filename && $model->filename != 'deleted')) {
            $res = Yii::$app->FileManager->DeleteFile($model->filename);
            if ($res->status == true) {
                $model->filename = 'deleted';
                $model->update();
            }
        }
        return $this->redirect(['adminupdate', 'id' => $id]);
    }

    public function actionSyncBiodataPendidikan()
    {
        $biodata = Tblprcobiodata::find()->where(['!=', 'status', '06'])->all();
        // $res = self::highestEducation('700829125153 ', '12');
        // die;
        $bio_dt_null = 0;
        $cdsamadtxsama = 0;
        $counter_tukar = 0;
        $counter_equal = 0;
        $counter_lower = 0;
        $counter_pendidikan_null = 0;
        $counter_biodata_null = 0;
        foreach ($biodata as $b) {
            $res = self::highestEducation($b->ICNO, $b->HighestEduLevelCd);
            switch ($res['status']) {
                case 'bio_dt_null':
                    // echo $b->ICNO.' | '.$b->HighestEduLevelCd .' / '. $res['EduCd'] .' | '. $b->ConfermentDt .' / '. $res['EduDt'];
                    // echo'</br>';
                    // $b->ConfermentDt = $res['EduDt'];
                    // $b->save(false);
                    $bio_dt_null++;
                    break;
                case 'higher':
                    echo $b->ICNO . ' | ' . $b->HighestEduLevelCd . ' / ' . $res['EduCd'] . ' | ' . $b->ConfermentDt . ' / ' . $res['EduDt'];
                    echo '</br>';
                    $b->HighestEduLevelCd = $res['EduCd'];
                    $b->ConfermentDt = $res['EduDt'];
                    $b->save(false);
                    $counter_tukar++;
                    break;
                case 'cdsamadtxsama':
                    echo $b->ICNO . ' | ' . $b->HighestEduLevelCd . ' / ' . $res['EduCd'] . ' | ' . $b->ConfermentDt . ' / ' . $res['EduDt'];
                    echo '</br>';
                    $b->HighestEduLevelCd = $res['EduCd'];
                    $b->ConfermentDt = $res['EduDt'];
                    $b->save(false);
                    $cdsamadtxsama++;
                    break;

                case 'equal':
                    // echo $b->HighestEduLevelCd .' / '. $res['EduCd'] .' | '. $b->ConfermentDt .' / '. $res['EduDt'];
                    // echo'</br>';
                    $counter_equal++;

                    break;
                case 'lower':
                    echo $b->ICNO . ' | ' . $b->HighestEduLevelCd . ' / ' . $res['EduCd'] . ' | ' . $b->ConfermentDt . ' / ' . $res['EduDt'];
                    echo '</br>';
                    $counter_lower++;

                    break;
                case 'tblpendidikan':
                    $counter_pendidikan_null++;

                    break;
                case 'biodata':
                    // $b->HighestEduLevelCd = $res['EduCd'];
                    // $b->ConfermentDt = $res['EduDt'];
                    // $b->save(false);
                    $counter_biodata_null++;

                    break;

                default:
                    echo $b->ICNO . ' | tiada ';
                    echo '</br>';
                    break;
            }
        }
        echo 'bio null = ' . $bio_dt_null;
        echo '</br>';
        echo 'cdsamadtxsama = ' . $cdsamadtxsama;
        echo '</br>';
        echo 'tukar = ' . $counter_tukar;
        echo '</br>';
        echo 'equal = ' . $counter_equal;
        echo '</br>';
        echo 'lower = ' . $counter_lower;
        echo '</br>';
        echo 'pendidikan null = ' . $counter_pendidikan_null;
        echo '</br>';
        echo 'biodata null = ' . $counter_biodata_null;
        echo '</br>';
        die;
        return true;
    }

    public function highestEducation($icno, $HighestEduLevelCd)
    {

        $pendidikan = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->asArray()->all();
        $biodata_pendidikan = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $icno])->andWhere(['`tblpreduach`.`HighestEduLevelCd`' => $HighestEduLevelCd])->asArray()->one();

        //sort;
        $pendidikan = self::bubbleSort($pendidikan);

        //compare;
        $res = [];
        if (!empty($biodata_pendidikan) && !empty($pendidikan)) {
            if ($biodata_pendidikan['pendidikanTertinggi']['HighestEduLevelRank'] > $pendidikan[0]['pendidikanTertinggi']['HighestEduLevelRank']) {
                // echo 'tukar rank bio lagi kecil dri rank tblpendidikan';
                $res = ['status' => 'higher', 'EduCd' => $pendidikan[0]['HighestEduLevelCd'], 'EduDt' => $pendidikan[0]['ConfermentDt']];
            } elseif ($biodata_pendidikan['pendidikanTertinggi']['HighestEduLevelRank'] == $pendidikan[0]['pendidikanTertinggi']['HighestEduLevelRank']) {

                if ($biodata_pendidikan['ConfermentDt'] < $pendidikan[0]['ConfermentDt']) {
                    // echo 'tukar';
                    // $res = ['status'=>'higher','EduCd'=>$pendidikan[0]['HighestEduLevelCd'],'EduDt'=>$pendidikan[0]['ConfermentDt']];
                    $res = ['status' => 'cdsamadtxsama', 'EduCd' => $pendidikan[0]['HighestEduLevelCd'], 'EduDt' => $pendidikan[0]['ConfermentDt']];
                } elseif ($biodata_pendidikan['ConfermentDt'] == $pendidikan[0]['ConfermentDt']) {
                    // echo 'tukar';
                    $res = ['status' => 'equal', 'EduCd' => $pendidikan[0]['HighestEduLevelCd'], 'EduDt' => $pendidikan[0]['ConfermentDt']];
                } else {
                    // echo 'tidak tukar level sama tapi date bio lgi latest';
                    $res = ['status' => 'lower', 'EduCd' => $pendidikan[0]['HighestEduLevelCd'], 'EduDt' => $pendidikan[0]['ConfermentDt']];
                }
            } else {
                // echo 'tidak tukar rank bio lagi besar dari rank tblpendidikan';
                // echo'</br>';
                // echo 'rank bio = '.$biodata_pendidikan['pendidikanTertinggi']['HighestEduLevelRank'] .' | '. $biodata_pendidikan['HighestEduLevelCd'];
                // echo'</br>';
                // echo 'rank tblpendidikan = '.$pendidikan[0]['pendidikanTertinggi']['HighestEduLevelRank'].' | '. $pendidikan[0]['HighestEduLevelCd'];
                $res = ['status' => 'lower', 'EduCd' => $pendidikan[0]['HighestEduLevelCd'], 'EduDt' => $pendidikan[0]['ConfermentDt']];
            }
        } elseif (empty($pendidikan)) { //notify user to update pendidikan
            // echo 'tidak tukar pendidikan kosong';
            $res = ['status' => 'tblpendidikan', 'EduCd' => null, 'EduDt' => null];
        } else { //replace biodata pendidikan from tblpendidikan
            // echo 'tukar bio kosong';
            $res = ['status' => 'biodata', 'EduCd' => $pendidikan[0]['HighestEduLevelCd'], 'EduDt' => $pendidikan[0]['ConfermentDt']];
        }
        // die;
        return $res;
    }

    private function bubbleSort($array)
    {
        for ($i = 0; $i < count($array); $i++) {

            for ($j = 0; $j < count($array); $j++) {
                if ($array[$i]['pendidikanTertinggi']['HighestEduLevelRank'] > $array[$j]['pendidikanTertinggi']['HighestEduLevelRank'] &&  $i < $j) {

                    $temp = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $temp;
                } else if ($array[$i]['pendidikanTertinggi']['HighestEduLevelRank'] == $array[$j]['pendidikanTertinggi']['HighestEduLevelRank'] &&  $i < $j) {
                    if ($array[$i]['ConfermentDt'] < $array[$j]['ConfermentDt']) {
                        $temp = $array[$i];
                        $array[$i] = $array[$j];
                        $array[$j] = $temp;
                    }
                } else {
                }
            }
        }
        return $array;
    }

    protected function findModelbyid($id)
    {
        if (($model = Tblpendidikan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModel($icno)
    {
        if (($model = Tblprcobiodata::findOne(['ICNO' => $icno])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function setHighEdu($icno, $id)
    {

        $highest = $this->findModelbyid($id);
        if ($highest->HighEdu == '1') {
            $biodata = $this->findModel($icno);
            $edulevel = Tblpendidikan::find()->where(['ICNO' => $icno])->andWhere(['!=', 'id', $id])->all();
            if (!empty($edulevel)) {
                foreach ($edulevel as $edulevels) {
                    $edulevels->HighEdu = '0';
                    $edulevels->save();
                }
            }
            $biodata->HighestEduLevelCd = $highest->HighestEduLevelCd;
            $biodata->ConfermentDt = $highest->ConfermentDt;
            $biodata->save();
        }

        return 0;
    }

    protected function setBioEduAD($icno)
    {

        $biodata = $this->findModel($icno);
        $biodata->HighestEduLevelCd = null;
        $biodata->ConfermentDt = null;
        $biodata->save();
        return 0;
    }

    /////Subjek

    public function actionViewSubjek($Edu_id)
    {
        $mustaddsubjek = [13, 14, 15, 23];
        $model = $this->findModelbyid($Edu_id);
        $subjek = Tblsubjek::find()->where(['ICNO' => $model->ICNO, 'Edu_id' => $Edu_id])->all();
        if (in_array($model->HighestEduLevelCd, $mustaddsubjek)) {
            //Tajuk Halaman
            switch ($model->HighestEduLevelCd) {
                case '13':
                    $title = 'STPM/STP/HSC';
                    break;
                case '14':
                    $title = 'SPM/MCE/Setaraf';
                    break;
                case '15':
                    $title = 'PMR/SRP/LCE/Setaraf';
                    break;
                case '23':
                    $title = 'SPVM';
                    break;
            }
            return $this->render('view-subjek1', [
                'Edu_id' => $Edu_id,
                'subjek' => $subjek,
                'level' => $title,
            ]);
        }

        return $this->render('lihatpendidikan', [
            'model' => $model,
        ]);
    }

    public function actionTambahSubjek($Edu_id, $f)
    {
        $model = new Tblsubjek();
        $pendidikan = Tblpendidikan::findOne(['id' => $Edu_id]);
        $id = $pendidikan->HighestEduLevelCd;

        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = Yii::$app->user->getId();
            $model->EduLevel_id = $pendidikan->HighestEduLevelCd;
            $model->Edu_id = $pendidikan->id;
            if ($model->save()) {
                if ($f == 1) {
                    return $this->redirect(['view-subjek', 'Edu_id' => $Edu_id]);
                }
                return $this->redirect(['lihatpendidikan', 'id' => $Edu_id]);
            }
        }
        //Tajuk Halaman
        switch ($id) {
            case '13':
                $title = 'STPM/STP/HSC';
                break;
            case '14':
                $title = 'SPM/MCE/Setaraf';
                break;
            case '15':
                $title = 'PMR/SRP/LCE/Setaraf';
                break;
            case '23':
                $title = 'SPVM';
                $id = '14';
                break;
        }

        return $this->render('tambah-subjek', [
            'title' => $title,
            'model' => $model,
            'lvl' => $id,

        ]);
    }

    public function actionAdmintambahSubjek($Edu_id, $icno)
    {
        $pendidikan = Tblpendidikan::findOne(['id' => $Edu_id]);
        $model = new Tblsubjek();
        $id = $pendidikan->HighestEduLevelCd;

        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $pendidikan->ICNO;
            $model->EduLevel_id = $pendidikan->HighestEduLevelCd;
            $model->Edu_id = $pendidikan->id;

            if ($model->save()) {
                return $this->redirect(['adminlihatpendidikan', 'id' => $Edu_id]);
            }
        }
        //Tajuk Halaman
        switch ($id) {
            case '13':
                $title = 'STPM/STP/HSC';
                break;
            case '14':
                $title = 'SPM/MCE/Setaraf';
                break;
            case '15':
                $title = 'PMR/SRP/LCE/Setaraf';
                break;
            case '23':
                $title = 'SPVM';
                break;
        }
        return $this->render('tambah-subjek', [
            'title' => $title,
            'model' => $model,
            'lvl' => $id,

        ]);
    }

    public function actionKemaskiniSubjek($id)
    {
        $model = Tblsubjek::findOne(['id' => $id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['lihatpendidikan', 'id' => $model->Edu_id]);
        }
        switch ($model->EduLevel_id) {
            case '13':
                $title = 'STPM/STP/HSC';
                break;
            case '14':
                $title = 'SPM/MCE/Setaraf';
                break;
            case '15':
                $title = 'PMR/SRP/LCE/Setaraf';
                break;
            case '23':
                $title = 'SPVM';
                break;
        }
        return $this->render('kemaskini-subjek', [
            'title' => $title,
            'model' => $model,
            'lvl' => $model->EduLevel_id,

        ]);
    }

    public function actionAdminkemaskiniSubjek($id)
    {
        $model = Tblsubjek::findOne(['id' => $id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['adminlihatpendidikan', 'id' => $model->Edu_id]);
        }
        switch ($model->EduLevel_id) {
            case '13':
                $title = 'STPM/STP/HSC';
                break;
            case '14':
                $title = 'SPM/MCE/Setaraf';
                break;
            case '15':
                $title = 'PMR/SRP/LCE/Setaraf';
                break;
            case '23':
                $title = 'SPVM';
                break;
        }
        return $this->render('kemaskini-subjek', [
            'title' => $title,
            'model' => $model,
            'lvl' => $model->EduLevel_id,

        ]);
    }

    public function actionPadamSubjek($id)
    {
        $model = Tblsubjek::findOne(['id' => $id]);
        if ($model->delete()) {
            return $this->redirect(['lihatpendidikan', 'id' => $model->Edu_id]);
        }
    }

    public function actionAdminpadamSubjek($id)
    {
        $model = Tblsubjek::findOne(['id' => $id]);
        if ($model->delete()) {
            return $this->redirect(['adminlihatpendidikan', 'id' => $model->Edu_id]);
        }
    }

    public function actionUpdateBiodataPendidikan()
    {
        $biodata = Tblprcobiodata::find()->where(['!=', 'status', '06'])->all();
        $affected = 0;

        foreach ($biodata as $bio) {
            //$tahap_pendidikan_biodata = $bio->pendidikan->newEduRank ?? '98';
            $tblpendidikan = Tblpendidikan::find()->joinWith('pendidikanTertinggi')->where(['ICNO' => $bio->ICNO])->asArray()->all();
            $tblpendidikan = self::bubbleSort1($tblpendidikan);
            if (!empty($tblpendidikan)) {
                $bio->HighestEduLevelCd = $tblpendidikan[0]['HighestEduLevelCd'];
                $bio->ConfermentDt = $tblpendidikan[0]['ConfermentDt'];
                $bio->save(false);
                $affected++;
            }
        }

        echo $affected;
    }

    private function bubbleSort1($array)
    {
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
        return $array;
    }

    //---------------START OF PUBLICATIONS PART-----------------------------//

    public function actionAddPub()
    {

        $this->view->title = 'New Publication';
        $icno = Yii::$app->user->getId();
        $model = new Publications();
        $model->nokp = $icno;
        $model->scenario = 'newRecord';

        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $icno;
            $model->create_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['view']);
            }
        }

        return $this->render('form-pub', [
            'model' => $model,
            'disabled' => false,
            'backBtn' => ['view'],
        ]);
    }

    public function actionUpdatePub($id)
    {

        $this->view->title = 'Update Publication';
        $model = Publications::findOne($id);


        if ($model->load(Yii::$app->request->post())) {

            $model->update_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['view']);
            }
        }

        return $this->render('form-pub', [
            'model' => $model,
            'disabled' => true,
            'backBtn' => ['view'],
        ]);
    }

    public function actionDeletePub($id)
    {

        $model = Publications::findOne($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Information are succesfully removed!']);
            return $this->redirect(['view']);
        }
    }

    public function actionAdminAddPub($id)
    {

        $this->view->title = 'New Publication';
        $icno = $id;
        $model = new Publications();
        $model->nokp = $icno;
        $model->scenario = 'newRecord';

        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $icno;
            $model->create_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['adminview', 'icno' => $id]);
            }
        }

        return $this->render('form-pub', [
            'model' => $model,
            'disabled' => false,
            'backBtn' => ['adminview', 'icno' => $id],
        ]);
    }

    public function actionAdminUpdatePub($id)
    {

        $this->view->title = 'Update Publication';
        $model = Publications::findOne($id);


        if ($model->load(Yii::$app->request->post())) {

            $model->update_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['adminview', 'icno' => $model->icno]);
            }
        }

        return $this->render('form-pub', [
            'model' => $model,
            'disabled' => true,
            'backBtn' => ['adminview', 'icno' => $model->icno],
        ]);
    }

    public function actionAdminDeletePub($id)
    {

        $model = Publications::findOne($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Information are succesfully removed!']);
            return $this->redirect(['adminview', 'icno' => $model->icno]);
        }
    }
    //---------------END OF PUBLICATIONS PART-----------------------------//
    //---------------START OF CLINICAL CERT PART-----------------------------//

    

    public function actionAddClCert(){
        $model = new Tblprclinicalcert();
        $model->scenario = 'add';

        if($model->load(Yii::$app->request->post())){
            $model->icno = Yii::$app->user->getId();
            $model->file = UploadedFile::getInstance($model, 'file');
            $valid = $model->validate();
            if ($valid && $model->file) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if($flag = $model->save(false)){
                        $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/Pendidikan');
                        if ($res->status == true) {
                            $model->filename = $res->file_name_hashcode;
                            $flag = $model->save(false);
                            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        } else {
                            $flag = false;
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view']);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            } 
        }
        return $this->render('clinicalCert/_tambah',[
            'model' => $model,
        ]);
    }

    //---------------END OF CLINICAL CERT PART-----------------------------//
}
