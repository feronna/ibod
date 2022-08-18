<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_jam_waktu".
 *
 * @property int $id
 * @property string $lpp_id
 * @property int $ref_id
 * @property int $waktu_perdana_s
 * @property int $waktu_malam_s
 * @property int $hujung_minggu_s
 * @property int $waktu_perdana_t
 * @property int $waktu_malam_t
 * @property int $hujung_minggu_t
 * @property int $waktu_perdana_m
 * @property int $waktu_malam_m
 * @property int $hujung_minggu_m
 * @property double $teaching_file
 * @property int $jenis_syarahan 0 = hakiki, 1 = bebayar
 * @property int $bil_pengajar
 * @property int $sah_ppp
 */
class TblJamWaktu extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.elnpt_tbl_jam_waktu';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db2');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['lpp_id', 'ref_id'], 'required'],
            [['lpp_id', 'ref_id', 'waktu_perdana_s', 'waktu_malam_s', 'hujung_minggu_s', 'waktu_perdana_t', 'waktu_malam_t', 'hujung_minggu_t', 'waktu_perdana_m', 'waktu_malam_m', 'hujung_minggu_m', 'jenis_syarahan', 'bil_pengajar', 'sah_ppp'], 'integer'],
            [['teaching_file'], 'number'],
            [['waktu_perdana_s', 'waktu_malam_s', 'hujung_minggu_s', 'waktu_perdana_t', 'waktu_malam_t', 'hujung_minggu_t', 'waktu_perdana_m', 'waktu_malam_m', 'hujung_minggu_m', 'teaching_file', 'jenis_syarahan', 'bil_pengajar', 'sah_ppp'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'ref_id' => 'Ref ID',
            'waktu_perdana_s' => 'Waktu Perdana S',
            'waktu_malam_s' => 'Waktu Malam S',
            'hujung_minggu_s' => 'Hujung Minggu S',
            'waktu_perdana_t' => 'Waktu Perdana T',
            'waktu_malam_t' => 'Waktu Malam T',
            'hujung_minggu_t' => 'Hujung Minggu T',
            'waktu_perdana_m' => 'Waktu Perdana M',
            'waktu_malam_m' => 'Waktu Malam M',
            'hujung_minggu_m' => 'Hujung Minggu M',
            'teaching_file' => 'Teaching File',
            'jenis_syarahan' => 'Jenis Syarahan',
            'bil_pengajar' => 'Bil Pengajar',
            'sah_ppp' => 'Sah Ppp',
        ];
    }

    public function getteachingFileDesc() {
        switch ($this->teaching_file) {
            case 1:
                return 'COMPLETE';
            case 0:
                return 'NOT COMPLETE';
            case 0.5:
                return 'PARTIAL COMPLETE';
        }
    }

    public function getjenisSyarahan() {
        switch ($this->jenis_syarahan) {
            case 0:
                return 'HAKIKI';
            case 1:
                return 'BERBAYAR';
        }
    }

    public function getbilPengajar() {
        return $this->bil_pengajar;
    }

    public function getpppSah() {
        switch ($this->sah_ppp) {
            case 0:
                return 'Unverified';
            case 1:
                return 'Verified';
        }
    }

    public function getLpp() {
        return $this->hasMany(\app\models\elnpt\TblMain::className(), ['lpp_id' => 'lpp_id']);
    } 
    
    public function getPengajaran() {
        return $this->hasOne(TblPengajaranPembelajaran::className(), ['id' => 'ref_id']);
    } 

    public function getRekodPengajaran($id) {
        $auto = \app\models\elnpt\TblPengajaran::find()->where(['AutoId' => $this->ref_id])->andWhere(['NOKP' => $id])->one();
        $manual = TblPengajaranPembelajaran::find()->where(['id' => $this->ref_id])->one();
        if (!empty($auto)) {
            return $auto;
        } elseif (!empty($manual)) {
            return $manual;
        } else {
            return null;
        }
    }

    public function getStatusRekodPengajaran($id) {
        $auto = \app\models\elnpt\TblPengajaran::find()->where(['AutoId' => $this->ref_id])->andWhere(['NOKP' => $id])->one();
        $manual = TblPengajaranPembelajaran::find()->where(['id' => $this->ref_id])->one();
        if (!empty($auto)) {
            return 'Auto';
        } elseif (!empty($manual)) {
            return 'Manual';
        } else {
            return null;
        }
    }

}
