<?php

namespace app\models\ejobs;

use app\models\ejobs\TblpPermohonan;
use Yii;
use app\models\ejobs\Penempatan;
use app\models\hronline\PendidikanTertinggi;

class Iklan extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7');  // second database
    }

    public $taraf_jawatan = [];
    public $penempatan = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ejobs.iklan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['penempatan', 'jawatan_id', 'kumpulan_id', 'klasifikasi_id', 'kategori_iklan_id', 'jumlah_kekosongan', 'tarikh_buka', 'tarikh_tutup', 'min_edu', 'min_bm_spm', 'min_bm_pmr'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['jawatan_id', 'kumpulan_id', 'klasifikasi_id', 'penempatan_id', 'kategori_iklan_id', 'jumlah_kekosongan', 'status', 'min_edu', 'min_bm_spm', 'min_bm_pmr', 'status_dalaman'], 'integer'],
            [['status_skype_iv','tarikh_buka', 'tarikh_tutup', 'min_edu', 'min_bm_spm', 'min_bm_pmr', 'jumlah_layak', 'jumlah_tidak_layak'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'jawatan_id' => 'Jawatan',
            'kumpulan_id' => 'Kumpulan',
            'klasifikasi_id' => 'Klasifikasi',
            'penempatan_id' => 'Penempatan',
            'kategori_iklan_id' => 'Kategori',
            'jumlah_kekosongan' => 'Jumlah Kekosongan',
            'tarikh_buka' => 'Tarikh Buka',
            'tarikh_tutup' => 'Tarikh Tutup',
            'status' => 'Status',
        ];
    }

    public function getJawatan() {
        return $this->hasOne(\app\models\ejobs\GredJawatan::className(), ['id' => 'jawatan_id']);
    }

    public function getKumpulan() {
        return $this->hasOne(\app\models\hronline\Kumpulankhidmat::className(), ['id' => 'kumpulan_id']);
    }

    public function getKlasifikasi() {
        return $this->hasOne(\app\models\ejobs\KlasifikasiJawatan::className(), ['id' => 'klasifikasi_id']);
    }

    public function getPendidikanTertinggi() {
        return $this->hasOne(PendidikanTertinggi::className(), ['HighestEduLevelCd' => 'min_edu']);
    } 

    public function getKategori() {
        return $this->hasOne(\app\models\ejobs\KategoriJawatan::className(), ['id' => 'kategori_iklan_id']);
    }

    public function getTarafJawatan() {
        return $this->hasMany(\app\models\ejobs\TarafJawatan::className(), ['iklan_id' => 'id']);
    }

    public function getPenempatan() {
        return $this->hasMany(\app\models\ejobs\Penempatan::className(), ['iklan_id' => 'id']);
    }

    public function getKelayakan() {
        return $this->hasMany(\app\models\ejobs\Kelayakan::className(), ['jawatan_id' => 'id']);
    }

    public function getGaji() {
        if (($model = \app\models\gaji\RefJadualGaji::findOne(['r_jg_gred' => $this->jawatan->gred])) !== null) {
            return $model;
        } else {
            return 0;
        }
    }

    public function getTugas() {
        return $this->hasMany(\app\models\ejobs\TugasJawatan::className(), ['jawatan_id' => 'id']);
    }

    public function getTarikh($bulan) {

        $m = date_format(date_create($bulan), "m");
        if ($m == 01) {
            $m = "Januari";
        } elseif ($m == 02) {
            $m = "Februari";
        } elseif ($m == 03) {
            $m = "Mac";
        } elseif ($m == 04) {
            $m = "April";
        } elseif ($m == 05) {
            $m = "Mei";
        } elseif ($m == 06) {
            $m = "Jun";
        } elseif ($m == 07) {
            $m = "Julai";
        } elseif ($m == '08') {
            $m = "Ogos";
        } elseif ($m == '09') {
            $m = "September";
        } elseif ($m == '10') {
            $m = "Oktober";
        } elseif ($m == '11') {
            $m = "November";
        } elseif ($m == '12') {
            $m = "Disember";
        }

        return date_format(date_create($bulan), "d") . ' ' . $m . ' ' . date_format(date_create($bulan), "Y");
    }

    public function checkPermohonan($id) {
        $model = TblpPermohonan::findOne(['ICNO' => Yii::$app->user->getId(), 'iklan_id' => $id]);

        return $model;
    }

    public function getPermohonan() {
        return $this->hasMany(\app\models\ejobs\TblpPermohonan::className(), ['iklan_id' => 'id']);
    }

    public function allPenempatan($iklan_id) {
        return Penempatan::find()->where(['iklan_id' => $iklan_id])->all();
    }
 
    public static function findActiveAds() {
        $model = Iklan::find()->where(['status' => 1])->andWhere(['status_dalaman' => 1])->all();
        $active = array();
        foreach ($model as $model) {
            if ((date('Y-m-d') >= $model->tarikh_buka) && (date('Y-m-d') <= $model->tarikh_tutup)) {
                $active[] = $model->jawatan_id;
            }
        }

        return $active;
    }
}
