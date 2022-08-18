<?php

namespace app\controllers\survey;

use app\models\survey\TblAktiviti;
use app\models\survey\TblCalon;
use app\models\survey\TblPengundi;
use app\models\survey\TblVotes;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class StaffController extends \yii\web\Controller
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $this->view->title = "Survey";

        $icno = Yii::$app->user->getId();

        $dt = date('Y-m-d H:i:s');

        $aktiviti = TblAktiviti::find()->joinWith('relPengundi')->where(['status' => 1, 'survey_tbl_pengundi.icno' => $icno])->andFilterWhere(['<=', 'start_dt', $dt])->andFilterWhere(['>=', 'end_dt', $dt])->all();

        return $this->render('index', [
            'aktiviti' => $aktiviti,
            'bil' => 1,
            'icno' => $icno,
        ]);
    }

    public function actionVote($key)
    {
        $this->view->title = "Survey";

        $icno = Yii::$app->user->getId();

        $dt = date('Y-m-d H:i:s');

        $aktiviti = TblAktiviti::find()->where(['SHA2(id,"256")' => $key])->one();

        $calon = TblCalon::find()->where(['aktiviti_id' => $aktiviti->id])->all();

        $pengundi = TblPengundi::findOne(['aktiviti_id' => $aktiviti->id, 'icno' => $icno]);

        //klu sda.. trus redirect ke done page
        if ($pengundi->vote_status == 1) {
            return $this->redirect(['done', 'key' => $key]);
        }

        $vote = new TblVotes();

        if ($vote->load(Yii::$app->request->post())) {

            if ($vote->calon_id == 0) {
                echo 'error';
                return $this->redirect(['vote', 'key' => $key]);
            }

            $vote->aktiviti_id = $aktiviti->id;
            $vote->pengundi_id = $pengundi->id;
            $vote->vote_dt = $dt;

            $pengundi->vote_status = 1;
            $pengundi->vote_dt = $dt;

            $updateCalon = TblCalon::findOne($vote->calon_id);
            $updateCalon->total_vote = $updateCalon->totalVote;

            if ($vote->save() && $pengundi->save() && $updateCalon->save()) {
                return $this->redirect(['done', 'key' => $key]);
            }
        }

        return $this->render('vote', [
            'aktiviti' => $aktiviti,
            'calon' => $calon,
            'vote' => $vote,
            'bil' => 1,
        ]);
    }

    public function actionDone($key)
    {
        $this->view->title = "Survey Completed!";

        $icno = Yii::$app->user->getId();

        $aktiviti = TblAktiviti::find()->where(['SHA2(id,"256")' => $key])->one();

        $pengundi = TblPengundi::findOne(['aktiviti_id' => $aktiviti->id, 'icno' => $icno]);

        return $this->render('done', [
            'aktiviti' => $aktiviti,
            'pengundi' => $pengundi,
            'bil' => 1,
        ]);
    }
}
