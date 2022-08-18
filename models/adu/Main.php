<?php

namespace app\models\adu;

use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "utilities.adu_tbl_main".
 *
 * @property int $id id
 * @property string $complainant Pengadu
 * @property int $location dept_id
 * @property string $assigned_staff icno staff yg kena assign
 * @property string $doc_name upload doc name
 * @property string $hashcode mediahost hashcode reference
 * @property string $title
 * @property string $detail
 * @property string $create_dt
 * @property string $status
 */
class Main extends \yii\db\ActiveRecord
{

    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.adu_tbl_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location','fungsi_id'], 'integer'],
            [['create_dt', 'respon_dt'], 'safe'],
            [['detail', 'respon_detail'], 'string'],
            [['complainant', 'assigned_staff', 'respon_by'], 'string', 'max' => 16],
            [['doc_name', 'title'], 'string', 'max' => 255],
            [['hashcode'], 'string', 'max' => 150],
            [['file'], 'file', 'maxSize' => 2000 * 1024, 'tooBig' => 'File Limit is 2MB only'],
            [['status'], 'string', 'max' => 10],
            [['status', 'location', 'detail', 'fungsi_id'], 'required', 'on' => 'aduan-baharu', 'message' => 'Ruangan adalah wajib'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'complainant' => 'Pengadu',
            'location' => 'Pusat Tanggungjawab (PTJ)',
            'assigned_staff' => 'Assign to staff',
            'doc_name' => 'Nama Fail',
            'hashcode' => 'Hashcode',
            'title' => 'Tajuk',
            'detail' => 'Perincian',
            'create_dt' => 'Entri',
            'update_dt' => 'Kemaskini Terakhir',
            'status' => 'Status',
            'file' => 'Lampiran / Bukti Gambar / Dokumen',
            'respon_by' => 'Responden',
            'respon_dt' => 'Respon Pada',
            'respon_detail' => 'Respon',
            'fungsi_id' => 'Fungsi Operasi',
        ];
    }

    public function getStaffBio()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'complainant']);
    }

    public function getAssignedBio()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'assigned_staff']);
    }

    public function getLocRel()
    {
        return $this->hasOne(Department::class, ['id' => 'location']);
    }

    public function getFungsiRel()
    {
        return $this->hasOne(Fungsi::class, ['id' => 'fungsi_id']);
    }

    public function getResponBio()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'respon_by']);
    }

    public function getStatusRel()
    {
        return $this->hasOne(status::class, ['code' => 'status']);
    }

    public function search($params, $icno = null)
    {
        $query = self::find();
        $query->joinWith(['staffBio']);
        $query->limit(100);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'adu_tbl_main.complainant' => $icno,
        ]);

        $query->andFilterWhere(['like', 'adu_tbl_main.title', $this->title])
            ->andFilterWhere(['=', 'adu_tbl_main.status', $this->status]);

        $query->orderBy(['create_dt' => SORT_DESC]);

        return $dataProvider;
    }

    public function searchKj($params, $deptId = null)
    {
        $query = self::find();
        $query->joinWith(['staffBio']);
        $query->limit(100);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tblprcobiodata.DeptId' => $deptId,
        ]);

        $query->andFilterWhere(['like', 'adu_tbl_main.title', $this->title])
            ->andFilterWhere(['=', 'adu_tbl_main.status', $this->status]);

        $query->orderBy(['create_dt' => SORT_DESC]);

        return $dataProvider;
    }


    /**
     * ni utk KJ atau dekan
     */
    public static function isUserKj($userid)
    {

        $model = Department::findOne(['chief' => $userid]);

        if ($model) {
            return true;
        }

        return false;
    }

    /**
     * ni utk Admin
     */
    public static function isUserAdmin($userid)
    {

       if($userid == '890426495037' || $userid == '710418125051' || $userid == '840813125655'){
           return true;
       }

        return false;
    }

    /**
     * ni utk Ketua BSM
     */
    public static function isUserBsm($userid)
    {

        $model = Department::findOne(['chief' => $userid, 'shortname' => 'BSM']);

        if ($model) {
            return true;
        }

        return false;
    }

    /**
     * ni utk Ketua BSM
     */
    public static function isUserPpuu($userid)
    {

        $model = Department::findOne(['chief' => $userid, 'shortname' => 'PPUU']);

        if ($model) {
            return true;
        }

        return false;
    }

    public static function totalByStatus($icno)
    {

        $inProgress = self::find()->where(['complainant' => $icno,])->andWhere(['IN', 'status', ['ENTRY', 'KJ', 'ASSIGNED', 'BSM', 'PPUU']])->count();
        $completed = self::find()->where(['complainant' => $icno, 'status' => 'COMPLETED'])->count();

        $arr = [
            'completed' => $completed,
            'inProgress' => $inProgress,
        ];

        return $arr;
    }

    public static function totalPendingAction($icno)
    {
        
        $count = self::find()
            ->where(['assigned_staff' => $icno, 'status' => 'ASSIGNED'])
            ->asArray()
            ->count('id');

        return $count;
    }

    public static function totalPendingKj($icno)
    {
        $department = Department::findOne(['chief'=>$icno]);

        $count = self::find()
            ->where(['location' => $department->id, 'status' => 'ENTRY'])
            ->asArray()
            ->count('id');

        return $count;
    }
}
