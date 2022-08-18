<?php

namespace app\models\elnpt;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\hronline\GredJawatan;
use app\models\elnpt\RefBahagian;
use app\models\elnpt\TblMrkhBhg;
use app\models\elnpt\TblLppTahun;
use app\models\elnpt\TblMarkahKeseluruhan;

/**
 * This is the model class for table "hrm.elnpt_tbl_main".
 *
 * @property string $lpp_id
 * @property string $lpp_datetime
 * @property string $PYD
 * @property int $PYD_sts_lantikan
 * @property int $gred_jawatan_id
 * @property string $tahun
 * @property int $jfpiu
 * @property string $PPP
 * @property int $gred_jawatan_id_PPP
 * @property int $jspiu_PPP
 * @property string $PPK
 * @property int $gred_jawatan_id_PPK
 * @property int $jspiu_PPK
 */
class TblMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_datetime', 'tahun'], 'safe'],
            [['PYD_sts_lantikan', 'gred_jawatan_id', 'jfpiu', 'gred_jawatan_id_PPP', 'jspiu_PPP', 'gred_jawatan_id_PPK', 'jspiu_PPK'], 'integer'],
            [['PYD', 'PPP', 'PPK'], 'string', 'max' => 12],
            [['lpp_datetime', 'tahun', 'PYD_sah_datetime', 'PPP_sah_datetime', 'PPK_sah_datetime'], 'safe'],
            [['PYD_sts_lantikan', 'gred_jawatan_id', 'jfpiu', 'gred_jawatan_id_PPP', 'jspiu_PPP', 'gred_jawatan_id_PPK', 'jspiu_PPK', 'PYD_sah', 'PPP_sah', 'PPK_sah', 'is_aktif'], 'integer'],
            [['PYD', 'PPP', 'PPK', 'deleted_by'], 'string', 'max' => 12],
            [['catatan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lpp_id' => 'Lpp ID',
            'lpp_datetime' => 'Lpp Datetime',
            'PYD' => 'Pyd',
            'PYD_sts_lantikan' => 'Pyd Sts Lantikan',
            'gred_jawatan_id' => 'Gred Jawatan ID',
            'tahun' => 'Tahun',
            'jfpiu' => 'Jfpiu',
            'PPP' => 'Ppp',
            'gred_jawatan_id_PPP' => 'Gred Jawatan Id Ppp',
            'jspiu_PPP' => 'Jspiu Ppp',
            'PPK' => 'Ppk',
            'gred_jawatan_id_PPK' => 'Gred Jawatan Id Ppk',
            'jspiu_PPK' => 'Jspiu Ppk',
            'PYD_sah' => 'Pyd Sah', 
            'PYD_sah_datetime' => 'Pyd Sah Datetime', 
            'PPP_sah' => 'Ppp Sah', 
            'PPP_sah_datetime' => 'Ppp Sah Datetime', 
            'PPK_sah' => 'Ppk Sah', 
            'PPK_sah_datetime' => 'Ppk Sah Datetime', 
            'catatan' => 'Catatan', 
            'is_aktif' => 'Is Aktif', 
            'deleted_by' => 'Deleted By', 
        ];
    }
    
    public function getGuru() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PYD']);
    }
    
    public function getPpp() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PPP']);
    }
    
    public function getPpk() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PPK']);
    }
    
    public function getDeptGuru() {
        return $this->hasOne(Department::className(), ['id' => 'jfpiu']);
    }
    
    public function getGredGuru() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_jawatan_id']);
    }
    
    public function getTahunLpp() {
        return $this->hasOne(TblLppTahun::className(), ['lpp_tahun' => 'tahun']);
    }
    
    public function getTotalBahagian() {
        $cntBhg = RefBahagian::find()->all()->count();
        $cntBhgLpp = TblMrkhBhg::findAll(['lpp_id' => $this->lpp_id])->count();
        return ($cntBhg === $cntBhgLpp);
    }
    
    public function getMarkahAll() {
        return $this->hasOne(TblMarkahKeseluruhan::className(), ['lpp_id' => 'lpp_id']);
    }
}
