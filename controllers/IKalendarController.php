<?php

namespace app\controllers;

use Yii;
use app\models\ikalendar\TblHrEvents;
use app\models\ikalendar\TblHrEventsSearch;
use app\models\ikalendar\TblHrDates;
use app\models\ikalendar\TblLaporan;
use app\models\ikalendar\TblHrStatus;
use app\models\ikalendar\TblHrUsers;
use app\models\ikalendar\TblHrUsersSearch;
use app\models\ikalendar\RefHrCategories;
use app\models\ikalendar\TblHrUsersGroups;
use app\models\ikalendar\TblHrUsersCategories;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\Exception;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * IKalendarController implements the CRUD actions for TblHrEvents model.
 */
class IKalendarController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'create', 'update', 'delete',
                            'takwim-aktiviti',
                            'pencapaian-tahunan', 'pencapaian-bulanan',
                            'laporan-keseluruhan',
                            'perincian-laporan',
                            'senarai-aktiviti-bahagian',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblHrUsers::find()->where(['email' => Yii::$app->user->identity->ICNO])->exists();

                            if ($query) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'senarai-pengguna', 'update-pengguna', 'create-pengguna', 'delete-pengguna',
                            'senarai-bhg-sek-unit', 'update-bhg', 'delete-bhg', 'create-bhg'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblHrUsers::find()->where(['email' => Yii::$app->user->identity->ICNO, 'isadmin' => 1])->exists();

                            if ($query) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TblHrEvents models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblHrEventsSearch();
        $list = $this->listBhgSeksyen();
        // return \yii\helpers\VarDumper::dump(\yii\helpers\ArrayHelper::getColumn($list, 'category_id'), $depth = 10, $highlight = true);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['`hronline`.`hr_events`.`category_id`' => \yii\helpers\ArrayHelper::getColumn($list, 'category_id')]);
        $dataProvider->query->andWhere(['<>', '`hronline`.`hr_events`.`title`', '']);
        $dataProvider->query->orderBy('`d`.`date`');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblHrEvents model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTakwimAktiviti()
    {
        $query = TblHrEvents::find();

        $list = $this->listBhgSeksyen();

        $eventsHr = $query->joinWith('eventDate d', true, 'LEFT JOIN')
            ->andWhere(['`hronline`.`hr_events`.`category_id`' => \yii\helpers\ArrayHelper::getColumn($list, 'category_id')])
            ->andWhere(['<>', '`hronline`.`hr_events`.`title`', ''])
            ->andWhere(['MONTH(`d`.`date`)' => date('m')])
            ->orderBy(['`d`.`date`' => SORT_ASC, '`hronline`.`hr_events`.`event_id`' => SORT_ASC])
            ->asArray()
            ->all();

        $events = array();

        foreach ($eventsHr as $ind => $ev) {
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $ind;
            $Event->title = $ev['title'];
            $Event->start = $ev['eventDate']['date'];
            $Event->end = $ev['eventDate']['end_date'];
            // $Event->url = Url::to(['i-kalendar/update', 'id' => $ev['event_id']]);
            $Event->nonstandard = [
                'dept' => $ev['venue'],
                'url' => Url::to(['i-kalendar/update', 'id' => $ev['event_id']]),
                'id' => $ev['event_id'],
                'urlDel' => Url::to(['i-kalendar/delete', 'id' => $ev['event_id']]),
            ];
            $events[] = $Event;
        }

        // $events = array();
        // //Testing
        // $Event = new \yii2fullcalendar\models\Event();
        // $Event->id = 1;
        // $Event->title = 'Testing';
        // $Event->start = date('Y-m-d\TH:i:s\Z');
        // $Event->nonstandard = [
        //     'field1' => 'Something I want to be included in object #1',
        //     'field2' => 'Something I want to be included in object #2',
        // ];
        // $events[] = $Event;

        // $Event = new \yii2fullcalendar\models\Event();
        // $Event->id = 2;
        // $Event->title = 'Testing';
        // $Event->start = date('Y-m-d\TH:i:s\Z', strtotime('tomorrow 6am'));
        // $events[] = $Event;

        // return \yii\helpers\VarDumper::dump($events, $depth = 10, $highlight = true);
        return $this->render('takwim_aktiviti', [
            'events' => $events,
        ]);
    }

    /**
     * Creates a new TblHrEvents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TblHrEvents();

        $dates = new TblHrDates();

        $list = $this->listBhgSeksyen();

        if (
            $model->load(Yii::$app->request->post())
            && $dates->load(Yii::$app->request->post())
        ) {
            $isValid = $model->validate();
            $isValid = $dates->validate() && $isValid;
            if ($isValid) {
                $model->save(false);
                $dates->save(false);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Aktiviti berjaya ditambah!']);
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('form', [
            'model' => $model,
            'date' => $dates,
            'list' => $list
        ]);
    }

    /**
     * Updates an existing TblHrEvents model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $dates = $this->findDates($model->event_id);

        $list = $this->listBhgSeksyen();

        if (
            $model->load(Yii::$app->request->post())
            && $dates->load(Yii::$app->request->post())
        ) {
            $isValid = $model->validate();
            $isValid = $dates->validate() && $isValid;
            if ($isValid) {
                $model->save(false);
                $dates->save(false);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Aktiviti berjaya dikemaskini!']);
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('form', [
            'model' => $model,
            'date' => $dates,
            'list' => $list
        ]);
    }

    /**
     * Deletes an existing TblHrEvents model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $this->findDates($model->event_id)->delete();

        $model->delete();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Aktiviti berjaya dibuang!']);
        $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the TblHrEvents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TblHrEvents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblHrEvents::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findDates($id)
    {
        if (($model = TblHrDates::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function listBhgSeksyen()
    {
        $list = RefHrCategories::find()
            ->alias('a')
            ->select(new Expression('`a`.`category_id` as category_id, CONCAT(`a`.`name` , \' - (\' , `a`.`description`, \')\') as name, `d`.`name` as sub_of'))
            ->leftJoin(['b' => '`hronline`.`hr_users_to_categories`'], '`b`.`category_id` = `a`.`category_id`')
            ->leftJoin(['c' => '`hronline`.`hr_users`'], '`b`.`user_id` = `c`.`user_id`')
            ->leftJoin(['d' => '`hronline`.`hr_categories`'], '`a`.`sub_of` = `d`.`category_id`')
            ->where(['`c`.`email`' => Yii::$app->user->identity->ICNO])
            ->andWhere(['<>', '`a`.`category_id`', 1])
            ->orderBy('category_id')
            // ->indexBy('category_id')
            ->asArray()
            ->all();

        return $list;
    }

    public function actionPencapaianTahunan()
    {
        // return \yii\helpers\VarDumper::dump($laporan, $depth = 10, $highlight = true);
        return $this->render('capai_tahun', [
            'laporan' => $this->getPencapaian(),
        ]);
    }

    public function actionPencapaianBulanan()
    {
        $model = new \yii\base\DynamicModel([
            'tahun', 'bulan'
        ]);

        $model->addRule(['tahun', 'bulan'], 'required');

        $laporan = [];

        if ($model->load(Yii::$app->request->post())) {
            // $model->tahun = $model->tahun;
            // \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $model->tahun]);
            // $this->redirect(Yii::$app->request->referrer);
            $laporan = $this->getPencapaian($model->tahun, $model->bulan);
            // return \yii\helpers\VarDumper::dump($laporan, $depth = 10, $highlight = true);
        }

        // return \yii\helpers\VarDumper::dump($laporan, $depth = 10, $highlight = true);
        return $this->render('capai_bulan', [
            'model' => $model,
            'laporan' => $laporan,
        ]);
    }

    public function getPencapaian($tahun = 2021, $bulan = null)
    {
        $deptList = RefHrCategories::find()
            ->where(['sub_of' => 1])
            ->asArray()
            ->all();

        $deptList = RefHrCategories::find()
            ->alias('a')
            ->leftJoin(['b' => '`hronline`.`hr_categories`'], '`b`.`sub_of` = `a`.`category_id`')
            ->where(['`a`.`sub_of`' => \yii\helpers\ArrayHelper::getColumn($deptList, 'category_id')])
            ->orderBy('`a`.`sub_of`')
            ->asArray()
            ->all();

        $result = \yii\helpers\ArrayHelper::map($deptList, 'category_id', 'category_id', 'sub_of');

        // return \yii\helpers\VarDumper::dump($result, $depth = 10, $highlight = true);

        $laporan = [];

        foreach ($result as $ind => $res) {
            array_push($res, $ind);

            $cat = TblLaporan::find()
                ->alias('a')
                ->select('bulan, COUNT(bulan) AS cnt')
                ->where(['`a`.`category_id`' => $res])
                ->andWhere(['`a`.`tahun`' => $tahun])
                ->andFilterWhere(['`a`.`bulan`' => $bulan])
                ->andWhere(['`a`.`stats_id`' => [6, 2, 8]])
                ->groupBy('`a`.`bulan`')
                ->orderBy('`a`.`bulan`');

            // return \yii\helpers\VarDumper::dump($cat, $depth = 10, $highlight = true);

            $reportByCat = TblLaporan::find()
                ->alias('a')
                ->select('a.bulan, ROUND(b.cnt / COUNT(a.bulan) * 100) AS SUM')
                ->leftJoin(['b' => $cat], '`b`.`bulan` = `a`.`bulan`')
                ->where(['`a`.`category_id`' => $res])
                ->groupBy('`a`.`bulan`')
                ->orderBy('`a`.`bulan`')
                ->asArray()
                ->all();

            array_push($laporan, \yii\helpers\ArrayHelper::map($reportByCat, 'bulan', 'SUM'));
        }

        return $laporan;
    }

    public function actionLaporanKeseluruhan()
    {
        $deptList = RefHrCategories::find()
            ->where(['sub_of' => 1])
            ->asArray()
            ->all();

        $deptList = RefHrCategories::find()
            ->alias('a')
            ->leftJoin(['b' => '`hronline`.`hr_categories`'], '`b`.`sub_of` = `a`.`category_id`')
            ->where(['`a`.`sub_of`' => \yii\helpers\ArrayHelper::getColumn($deptList, 'category_id')])
            ->orderBy('`a`.`sub_of`')
            ->asArray()
            ->all();

        $result = \yii\helpers\ArrayHelper::map($deptList, 'category_id', 'category_id', 'sub_of');

        // return \yii\helpers\VarDumper::dump($result, $depth = 10, $highlight = true);

        $laporan = [];

        foreach ($result as $ind => $res) {
            array_push($res, $ind);

            $cat = TblLaporan::find()
                ->alias('a')
                ->select('bulan, COUNT(bulan) AS cnt')
                ->where(['`a`.`category_id`' => $res])
                ->andWhere(['`a`.`stats_id`' => [6, 8, 5]])
                ->groupBy('`a`.`bulan`')
                ->orderBy('`a`.`bulan`');

            // return \yii\helpers\VarDumper::dump($cat, $depth = 10, $highlight = true);

            $reportByCat = TblLaporan::find()
                ->alias('a')
                // ->select('a.bulan, COALESCE(COUNT(a.bulan), \'0\') as R, COALESCE(b.cnt, \'0\') AS T')
                ->select(new Expression('a.bulan, COALESCE(COUNT(a.bulan), \'0\') as R, COALESCE(b.cnt, \'0\') AS T'))
                ->leftJoin(['b' => $cat], '`b`.`bulan` = `a`.`bulan`')
                ->where(['`a`.`category_id`' => $res])
                ->andWhere(['`a`.`stats_id`' => [1, 2, 3]])
                ->groupBy('`a`.`bulan`')
                ->orderBy('`a`.`bulan`')
                ->asArray()
                ->all();

            array_push($laporan, \yii\helpers\ArrayHelper::index($reportByCat, null, 'bulan'));
        }
        // return \yii\helpers\VarDumper::dump($laporan, $depth = 10, $highlight = true);
        // return \yii\helpers\VarDumper::dump(\yii\helpers\ArrayHelper::getColumn(array_values($laporan[1]), function ($element) {
        //     return $element[0]['R'];
        // }), $depth = 10, $highlight = true);
        return $this->render('whole_report', [
            'laporan' => $laporan,
        ]);
    }

    public function actionPerincianLaporan()
    {
        $model = new \yii\base\DynamicModel([
            'tahun', 'bulan', 'start_date', 'end_date'
        ]);

        $model->addRule(['tahun', 'bulan', 'start_date', 'end_date'], 'required');

        $laporan = [];

        if ($model->load(Yii::$app->request->post()) and $model->validate()) {

            $deptList = RefHrCategories::find()
                ->where(['sub_of' => 1])
                ->asArray()
                ->all();

            $deptList = RefHrCategories::find()
                ->alias('a')
                ->leftJoin(['b' => '`hronline`.`hr_categories`'], '`b`.`sub_of` = `a`.`category_id`')
                ->where(['`a`.`sub_of`' => \yii\helpers\ArrayHelper::getColumn($deptList, 'category_id')])
                ->orderBy('`a`.`sub_of`')
                ->asArray()
                ->all();

            $result = \yii\helpers\ArrayHelper::map($deptList, 'category_id', 'category_id', 'sub_of');

            $laporan = [];

            // return \yii\helpers\VarDumper::dump($result, $depth = 10, $highlight = true);

            foreach ($result as $ind => $res) {
                array_push($res, $ind);

                $tmp = TblLaporan::find()
                    ->alias('a')
                    ->select('bulan, COUNT(a.`stats_id`) as sts, a.`stats_id`, b.`name`')
                    ->leftJoin(['b' => '`hronline`.`hr_status`'], '`b`.`stats_id` = `a`.`stats_id`')
                    ->where(['`a`.`category_id`' => $res])
                    ->andWhere(['`a`.`bulan`' => $model->bulan])
                    // ->andWhere(['and', ['>', '`a`.`date`', $model->start_date], ['<', '`a`.`date`', $model->end_date]])
                    ->andWhere(['between', '`a`.`date`', $model->start_date, $model->end_date])
                    ->groupBy('`a`.`bulan`,  `a`.`stats_id`')
                    ->orderBy('`a`.`bulan`,  `a`.`stats_id`')
                    ->asArray()
                    ->all();

                array_push($laporan, $tmp);

                // return \yii\helpers\VarDumper::dump($laporan, $depth = 10, $highlight = true);
            }
        }

        // return \yii\helpers\VarDumper::dump($laporan, $depth = 10, $highlight = true);
        return $this->render('det_report', [
            'model' => $model,
            'laporan' => $laporan,
        ]);
    }

    public function actionSenaraiAktivitiBahagian()
    {
        $model = new \yii\base\DynamicModel([
            'tahun', 'bulan', 'bahagian'
        ]);

        $model->addRule(['tahun', 'bulan', 'bahagian'], 'required');

        $sub_of = 0;

        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            $sub_of = $model->bahagian;
        }

        $deptList = RefHrCategories::find()
            ->where(['sub_of' => $sub_of])
            ->asArray()
            ->all();

        $ttt = \yii\helpers\ArrayHelper::getColumn($deptList, 'category_id');

        // $ttt[] = $model->bahagian;

        $tmp = TblLaporan::find()
            ->alias('a')
            ->select(new Expression('`a`.`event_id`, `a`.`date`, `a`.`nama_aktiviti`, `a`.`tempat_aktiviti`, \'Bahagian\' as Peringkat, `a`.`status`, `a`.`category_id`, `b`.`name`, `a`.`tarikh_tunda`'))
            ->leftJoin(['b' => '`hronline`.`hr_categories`'], '`b`.`category_id` = `a`.`category_id`')
            ->where(['`a`.`category_id`' => $ttt])
            ->andFilterWhere(['`a`.`bulan`' => $model->bulan])
            // ->andWhere(['and', ['>', '`a`.`date`', $model->start_date], ['<', '`a`.`date`', $model->end_date]])
            ->orderBy(['`a`.`category_id`' => SORT_ASC, '`a`.`date`' => SORT_ASC])
            ->asArray()
            ->all();

        $arr = array();

        foreach ($tmp as $key => $item) {
            $arr[$item['name']][$key] = $item;
        }

        ksort($arr, SORT_NUMERIC);

        // return \yii\helpers\VarDumper::dump($arr, $depth = 10, $highlight = true);

        return $this->render('aktiviti_bhg', [
            'model' => $model,
            'laporan' => $arr,
        ]);
    }

    public function actionSenaraiPengguna()
    {
        \yii\helpers\Url::remember();
        $searchModel = new TblHrUsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('user_list', [
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdatePengguna($user_id)
    {
        $user = $this->findUser($user_id);

        $group = TblHrUsersGroups::find()->where(['user_id' => $user->user_id, 'group_id' => 1])->one();

        $tmp = RefHrCategories::find()
            ->alias('a')
            ->select('a.*, b.user_id as userId, b.category_id as catId, b.moderate')
            ->leftJoin(['b' => 'hronline.hr_users_to_categories'], 'a.category_id = b.category_id and `b`.`user_id` = ' . $user->user_id)
            ->orderBy(['sub_of' => SORT_ASC, 'sequence' => SORT_ASC])
            ->asArray()
            ->all();

        $tree = $this->buildTree($tmp);

        if ($user->load(Yii::$app->request->post())) {
            $this->processDataPengguna($user, $user->user_id,  $group, true);
            return $this->goBack();
        }

        return $this->renderAjax('user_info', [
            'model' => $user,
            'tree' => $tree,
        ]);
    }

    public function actionCreatePengguna()
    {
        $user = new TblHrUsers();

        $group = new TblHrUsersGroups();

        $tmp = RefHrCategories::find()
            ->alias('a')
            ->select(new Expression('a.*, b.user_id as userId, b.category_id as catId, Null as moderate'))
            ->leftJoin(['b' => 'hronline.hr_users_to_categories'], 'a.category_id = b.category_id and `b`.`user_id` = ' . ($user->user_id ?? 0))
            ->orderBy(['sub_of' => SORT_ASC, 'sequence' => SORT_ASC])
            ->asArray()
            ->all();

        $tree = $this->buildTree($tmp);

        if ($user->load(Yii::$app->request->post()) && $user->validate()) {
            $this->processDataPengguna($user, null, $group);
            return $this->goBack();
        }

        return $this->renderAjax('user_info', [
            'model' => $user,
            'tree' => $tree,
        ]);
    }

    private function processDataPengguna($model, $userId, $group, $upd = false)
    {
        $model->save(false);

        foreach ($model->moderate as $ind => $md) {
            if ($md) {
                $ttt = $this->findUserCat($userId ?? 0, $ind);
                $ttt->moderate = $md;
                $ttt->save(false);
            } else {
                $this->findUserCat($userId ?? 0, $ind, true);
            }
        }

        if ($upd) {
            $group->moderate = $model->modGroup;
            $group->subscribe = $model->subsGroup;
        } else {
            $group->user_id = $model->user_id;
            $group->group_id = 1;
        }
        $group->save(false);

        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $upd ? 'Data berjaya dikemaskini!' : 'Data berjaya ditambah!']);
    }

    protected function findUser($id)
    {
        if (($model = TblHrUsers::find()->where(['user_id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findCat($id)
    {
        if (($model = RefHrCategories::find()->where(['category_id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['sub_of'] == $parentId) {
                $children = $this->buildTree($elements, $element['category_id']);
                if ($children) {
                    $element['sub_of'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    protected function findUserCat($id, $cat, $del = false)
    {
        if (($model = TblHrUsersCategories::find()->where(['user_id' => $id, 'category_id' => $cat])->one()) !== null) {
            if ($del) {
                $model->delete();
                return;
            }
        } else {
            $model =  new TblHrUsersCategories();
            $model->user_id = $id;
            $model->category_id = $cat;
        }

        return $model;
    }

    public function actionDeletePengguna($user_id)
    {
        $usr = TblHrUsers::findOne($user_id);
        $usr->delete();

        // TblHrUsers::deleteAll(['user_id' => $user_id]);
        TblHrUsersGroups::deleteAll(['user_id' => $user_id]);
        TblHrUsersCategories::deleteAll(['user_id' => $user_id]);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
        return $this->goBack();
    }

    public function actionSenaraiBhgSekUnit()
    {
        \yii\helpers\Url::remember();

        $tmp = RefHrCategories::find()
            ->alias('a')
            ->select(new Expression('a.*, b.user_id as userId, b.category_id as catId, Null as moderate'))
            ->leftJoin(['b' => 'hronline.hr_users_to_categories'], 'a.category_id = b.category_id and `b`.`user_id` = 0')
            ->orderBy(['sub_of' => SORT_ASC, 'sequence' => SORT_ASC])
            ->asArray()
            ->all();

        $tree = $this->buildTree($tmp);

        return $this->render('list_unit', [
            'tree' => $tree,
        ]);
    }

    public function actionUpdateBhg($id)
    {
        $cat = $this->findCat($id);

        if ($cat->load(Yii::$app->request->post())) {
            $cat->save(false);
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
            return $this->goBack();
        }

        return $this->renderAjax('cat_info', [
            'model' => $cat,
        ]);
    }

    public function actionCreateBhg()
    {
        $cat = new RefHrCategories();

        if ($cat->load(Yii::$app->request->post())) {
            $cat->save(false);
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya ditambah!']);
            return $this->goBack();
        }

        return $this->renderAjax('cat_info', [
            'model' => $cat,
        ]);
    }

    public function actionDeleteBhg($id)
    {
        $cnt = RefHrCategories::find()->where(['sub_of' => $id])->count();

        if ($cnt == 0) {
            $cat = RefHrCategories::findOne($id);
            $cat->delete();
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
        } else {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'warning', 'msg' => 'Sila padam sub-categories terlebih dahulu!']);
        }


        return $this->goBack();
    }
}
