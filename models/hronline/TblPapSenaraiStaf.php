<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\Tblprcobiodata;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "hronline.tbl_pap_senaraistaf".
 *
 * @property int $id
 * @property string $icno
 * @property string $sebab_perubahan
 * @property string $tarikh_ubah
 * @property string $tarikh_kuatkuasa
 * @property string $catatan_ketua
 * @property string $tandatangan_ketua
 * @property string $tarikh_tt_ketua
 * @property int $status_pelayan 1=sudah selesai;0=belum selesai
 * @property string $penerangan_pelayan
 * @property string $tandatangan_pelayan
 * @property string $tarikh_pelayan
 * @property int $status_PD Pengkalan Data
 * @property string $penerangan_PD
 * @property string $tandatangan_PD
 * @property string $tarikh_tt_PD
 * @property int $status_SA sistem aplikasi
 * @property string $penerangan_SA
 * @property string $tandatangan_SA
 * @property string $tarikh_tt_SA
 * @property int $status_fizikal fizikal
 * @property string $penerangan_fizikal
 * @property string $tandatangan_fizikal
 * @property string $tarikh_tt_fizikal
 */
class TblPapSenaraiStaf extends \yii\db\ActiveRecord
{
    public $status = null;
    public $_action = null;

    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.tbl_pap_senaraistaf';
    }

    public function rules()
    {
        return [
            [['tarikh_ubah', 'tarikh_kuatkuasa', 'tarikh_tt_ketua', 'tarikh_tt_pelayan', 'tarikh_tt_pd', 'tarikh_tt_sa', 'tarikh_tt_fizikal'], 'safe'],
            [['catatan_ketua', 'penerangan_pelayan', 'penerangan_pd', 'penerangan_sa', 'penerangan_fizikal'], 'string'],
            [['status_pelayan', 'status_pd', 'status_sa', 'status_fizikal'], 'integer'],
            [['icno'], 'string', 'max' => 15],
            [['sebab_perubahan', 'tandatangan_ketua', 'tandatangan_pelayan', 'tandatangan_pd', 'tandatangan_sa', 'tandatangan_fizikal'], 'string', 'max' => 100],
            [['nama','jfpib'], 'string'],
            ['status','safe'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'nama' => 'Nama',
            'jfpib' => 'JFPIB',
            'sebab_perubahan' => 'Sebab Perubahan',
            'tarikh_ubah' => 'Tarikh Ubah',
            'tarikh_kuatkuasa' => 'Tarikh Kuatkuasa',
            'catatan_ketua' => 'Catatan Ketua',
            'tandatangan_ketua' => 'Tandatangan Ketua',
            'tarikh_tt_ketua' => 'Tarikh Tt Ketua',
            'status_pelayan' => 'Status Pelayan',
            'penerangan_pelayan' => 'Penerangan Pelayan',
            'tandatangan_pelayan' => 'Tandatangan Pelayan',
            'tarikh_tt_pelayan' => 'Tarikh Pelayan',
            'status_pd' => 'Status Pd',
            'penerangan_pd' => 'Penerangan Pengkalan Data',
            'tandatangan_pd' => 'Tandatangan Pd',
            'tarikh_tt_pd' => 'Tarikh Tt Pd',
            'status_SA' => 'Status Sa',
            'penerangan_SA' => 'Penerangan Sa',
            'tandatangan_SA' => 'Tandatangan Sa',
            'tarikh_tt_SA' => 'Tarikh Tt Sa',
            'status_fizikal' => 'Status Fizikal',
            'penerangan_fizikal' => 'Penerangan Fizikal',
            'tandatangan_fizikal' => 'Tandatangan Fizikal',
            'tarikh_tt_fizikal' => 'Tarikh Tt Fizikal',
        ];
    }
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getTindakan4() {
        return $this->hasOne(TblPapTindakan::className(), ['pap_ss_id' => 'id'])->andWhere(['jenis_akses'=>4]);
    }

    public function getStatusAD(){
        if($this->biodata){
            $res = Yii::$app->ActiveDirectory->AdEmailExist($this->biodata->COEmail, 'email');
            if($res->exists){
                return '<span class="label label-success">Selesai</span>';
            }elseif($res->exists == false){
                return '<span class="label label-warning">Belum Selesai</span>';
            }else{
                return '<span class="label label-danger">Error Occurs</span>';
            }
        }
        return 'Staf profile not found in HR Data';
    }

    public function searchPenamatanAkses($params)
    {
        $query = self::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'sebab_perubahan', $this->sebab_perubahan])
            ->andFilterWhere(['like', 'se', $this->tarikh_ubah]);

        return $dataProvider;
    }
    
    public function search($params)
    {
        $query = self::find()->where(['sebab_perubahan'=>'Lantikan Baru'])->andWhere(['>','tarikh_ubah','2022-04-01']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if($this->status != null){

            switch ($this->status) {
                case '1':
                    $query->joinwith('tindakan4')->andWhere(['`tbl_pap_tindakan`.`status`'=>1]);

                    break;
                case '0':
                    $query->joinwith('tindakan4')->andWhere(['or',['`tbl_pap_tindakan`.`status`'=>null],['`tbl_pap_tindakan`.`status`'=>0]]);

                    break;
                case '-1':
                    $array_1 = [];
                    $s_bs = self::find()->joinwith('tindakan4')->select('`tbl_pap_senaraistaf`.`id`')->where(['sebab_perubahan'=>'Lantikan Baru'])->andWhere(['>','tarikh_ubah','2022-04-01'])
                    ->asArray()->all();
                    foreach($s_bs as $s_bs){
                        array_push($array_1,$s_bs['id']);
                    }

                    $query->where(['NOT IN','id',$array_1]);
                    break;
                default:
                    
                    break;
            }
        }
        $query->andWhere(['sebab_perubahan'=>'Lantikan Baru'])->andWhere(['>','tarikh_ubah','2022-04-01']);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'tarikh_ubah', $this->tarikh_ubah]);

        return $dataProvider;
    }


    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['id' => $this->id]);
        $attrib = $this->activeAttributes();

        switch ($insert) {
            case (false):
                for ($i = 0; $i < count($attrib); $i++) {

                    if ($tempObj->{$attrib[$i]} != $this->{$attrib[$i]}) {
                        array_push($changes, [$attrib[$i], $tempObj->{$attrib[$i]}, $this->{$attrib[$i]}]);
                    }
                }

                break;

            default:
                //aftersave will handle it
                break;
        }
        // auto set tandatangan dan tarikh tandatangan ;//
        if ($this->_action == 'kemaskini penamatan_akses') {
            for ($i = 0; $i < count($changes); $i++) {
                if ($changes[$i][0] == 'catatan_ketua') {
                    $this->tandatangan_ketua = Yii::$app->user->identity->CONm;
                    // $this->tarikh_tt_ketua = date('y-m-d');
                } else if ($changes[$i][0] == 'status_pelayan' || $changes[$i][0] == 'penerangan_pelayan') {
                    $this->tandatangan_pelayan = Yii::$app->user->identity->CONm;
                    // $this->tarikh_tt_pelayan = date('y-m-d');
                } else if ($changes[$i][0] == 'status_pd' || $changes[$i][0] == 'penerangan_pd') {
                    $this->tandatangan_pd = Yii::$app->user->identity->CONm;
                    // $this->tarikh_tt_PD = date('y-m-d');
                } else if ($changes[$i][0] == 'status_sa' || $changes[$i][0] == 'penerangan_sa') {
                    $this->tandatangan_sa = Yii::$app->user->identity->CONm;
                    // $this->tarikh_tt_SA = date('y-m-d');
                } else if ($changes[$i][0] == 'status_fizikal' || $changes[$i][0] == 'penerangan_fizikal') {
                    $this->tandatangan_fizikal = Yii::$app->user->identity->CONm;
                    // $this->tarikh_tt_fizikal = date('y-m-d');
                }
            }
        }

        return true;
    }

}
