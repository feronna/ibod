<?php

namespace app\models\adu;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use app\models\lppums\RefBahagian;
use app\models\lppums\RefKriteria;
use app\models\hronline\Tblprcobiodata;
use app\models\lppums\Lpp;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "utilities.adu_tbl_komp2".
 *
 * @property int $id
 * @property string $icno ppp / ppk
 * @property string $pyd pegawai yang dinilai
 * @property string $detail
 * @property int $bhgn_id
 * @property int $kriteria_id
 * @property string $create_dt
 * @property string $update_dt
 * @property int $skala_pp
 * @property int $skala_pyd
 * @property string $doc_name
 * @property string $hashcode
 * @property string $status
 */
class Komp2 extends \yii\db\ActiveRecord
{

    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.adu_tbl_komp2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detail'], 'string'],
            [['bhgn_id', 'kriteria_id'], 'integer'],
            [['create_dt', 'update_dt'], 'safe'],
            [['icno', 'pyd'], 'string', 'max' => 16],
            [['doc_name', 'hashcode'], 'string', 'max' => 150],
            [['file'], 'file', 'maxSize' => 2000 * 1024, 'tooBig' => 'File Limit is 2MB only'],
            [['status'], 'string', 'max' => 10],
            [['status', 'detail', 'create_dt', 'bhgn_id', 'kriteria_id', 'pyd'], 'required', 'on' => 'baharu', 'message' => 'Ruangan adalah wajib'],
            [['status', 'detail_pyd', 'update_dt'], 'required', 'on' => 'maklumbalas', 'message' => 'Ruangan adalah wajib'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'PPP / PPK',
            'pyd' => 'Pegawai yang dinilai (PYD)',
            'detail' => 'Perincian',
            'detail_pyd' => 'Maklumbalas PYD',
            'bhgn_id' => 'Aspek Penilaian',
            'kriteria_id' => 'Kriteria Penilaian',
            'create_dt' => 'Tarikh Entri',
            'update_dt' => 'Kemaskini Terakhir',
            'skala_pp' => 'Skala Kepada PYD',
            'skala_pyd' => 'Skala Maklumbalas kepada penilai',
            'doc_name' => 'Dokumen',
            'hashcode' => 'Hashcode',
            'status' => 'Status',
        ];
    }



    public function getPydBio()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'pyd']);
    }

    public function getPpBio()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'icno']);
    }

    public function getStatusRel()
    {
        return $this->hasOne(status::class, ['code' => 'status']);
    }

    public function getBhgnRel()
    {
        return $this->hasOne(RefBahagian::class, ['bahagian_id' => 'bhgn_id']);
    }

    public function getKriteriaRel()
    {
        return $this->hasOne(RefKriteria::class, ['kriteria_id' => 'kriteria_id']);
    }

    public function search($params, $icno = null)
    {
        $query = self::find();
        $query->joinWith(['pydBio']);
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
            'adu_tbl_komp2.icno' => $icno,
        ]);

        $query->andFilterWhere(['=', 'adu_tbl_komp2.bhgn_id', $this->bhgn_id])
            ->andFilterWhere(['like', 'tblprcobiodata.CONm', $this->pyd])
            ->andFilterWhere(['=', 'adu_tbl_komp2.status', $this->status]);

        $query->orderBy(['create_dt' => SORT_DESC]);

        return $dataProvider;
    }

    public static function totalByStatus($icno)
    {

        $inProgress = self::find()->where(['icno' => $icno,])->andWhere(['IN', 'status', ['ENTRY']])->count();
        $completed = self::find()->where(['icno' => $icno, 'status' => 'COMPLETED'])->count();

        $arr = [
            'completed' => $completed,
            'inProgress' => $inProgress,
        ];

        return $arr;
    }

    public static function PydList($icno)
    {
        $year = date('Y'); //=change to year now

        $ppp = Lpp::find()
            ->joinWith(['pydBio'])
            ->select(['PYD' => 'icno', 'name' => 'tblprcobiodata.CONm'])
            ->where(['tahun' => $year])
            ->andFilterWhere(['PPP' => $icno])
            ->all();

        $ppp_arr = ArrayHelper::map($ppp, 'PYD', 'pydBio.CONm');

        $ppk = Lpp::find()
            ->joinWith(['pydBio'])
            ->select(['PYD' => 'icno', 'name' => 'tblprcobiodata.CONm'])
            ->where(['tahun' => $year])
            ->andFilterWhere(['PPK' => $icno])
            ->all();

        $ppk_arr = ArrayHelper::map($ppk, 'PYD', 'pydBio.CONm');

        $arr = ArrayHelper::merge($ppp_arr, $ppk_arr);

        return $arr;
    }

    public static function totalPendingAction($icno)
    {
        
        $count = self::find()
            ->where(['pyd' => $icno, 'status' => 'ENTRY'])
            ->asArray()
            ->count('id');

        return $count;
    }
}
