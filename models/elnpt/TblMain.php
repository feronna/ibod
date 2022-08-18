<?php

namespace app\models\elnpt;

use Yii;
use app\models\elnpt\Tblprcobiodata;
use app\models\elnpt\Department;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblrscosandangan;
use app\models\elnpt\RefBahagian;
use app\models\elnpt\TblMrkhBhg;
use app\models\elnpt\TblLppTahun;
use app\models\elnpt\TblMarkahKeseluruhan;
use app\models\elnpt\outreaching\TblOutreachingManual;
use app\models\elnpt\TblBulanPgt;
use app\models\elnpt\TblCadanganApc;
use app\models\elnpt\TblApt;
use app\models\elnpt\TblApc;
//use app\models\elnpt\TblMarkahKeseluruhan;
//use app\models\elnpt\TblMrkhBhg;

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
 * @property string $PEER
 * @property int $gred_jawatan_id_PEER
 * @property int $jspiu_PEER
 * @property int $PYD_sah
 * @property string $PYD_sah_datetime
 * @property int $PPP_sah
 * @property string $PPP_sah_datetime
 * @property int $PPK_sah
 * @property string $PPK_sah_datetime
 * @property int $PEER_sah
 * @property string $PEER_sah_datetime
 * @property string $catatan
 * @property int $is_aktif
 * @property string $deleted_by
 */
class TblMain extends \yii\db\ActiveRecord
{
    public $tidak_setuju;

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
            [['PYD', 'PYD_sts_lantikan', 'gred_jawatan_id', 'jfpiu',], 'required'],
            [[
                'lpp_datetime', 'tahun', 'PYD_sah_datetime', 'PPP_sah_datetime',
                'PPK_sah_datetime', 'PEER_sah_datetime', 'deleted_datetime', 'gred_jawatan_id_PEER', 'jspiu_PEER', 'PEER', 'PYD', 'PPP', 'PPK', 'kump_dept_id', 'tidak_setuju'
            ], 'safe'],
            [['PYD_sts_lantikan', 'gred_jawatan_id', 'jfpiu', 'gred_jawatan_id_PPP', 'jspiu_PPP', 'gred_jawatan_id_PPK', 'jspiu_PPK', 'PYD_sah', 'PPP_sah', 'PPK_sah', 'PEER_sah', 'is_aktif', 'is_deleted'], 'integer'],
            [['deleted_by'], 'string', 'max' => 12],
            [['catatan'], 'string', 'max' => 255],
            ['PYD_sah', 'validatePengesahanPyd', 'on' => 'sah_pyd'],
            ['tidak_setuju', 'validatePengesahanMarkahPyd', 'on' => 'sah_pyd_markah'],
            ['PPP_sah', 'validatePengesahanPpp', 'on' => 'sah_ppp'],
            ['PPK_sah', 'validatePengesahanPpk', 'on' => 'sah_ppk'],
            ['PEER_sah', 'validatePengesahanPeer', 'on' => 'sah_peer'],
            [['PEER'], 'penetapPeer'],
            ['jspiu_PEER', 'required', 'when' => function ($model) {
                return $model->PEER != null;
            }, 'enableClientValidation' => false],
            ['PEER', 'required', 'when' => function ($model) {
                return $model->jspiu_PEER != null;
            }, 'enableClientValidation' => false],

            ['jspiu_PPP', 'required', 'when' => function ($model) {
                return $model->PPP != null;
            }, 'enableClientValidation' => false],
            ['PPP', 'required', 'when' => function ($model) {
                return $model->jspiu_PPP != null;
            }, 'enableClientValidation' => false],

            ['jspiu_PPK', 'required', 'when' => function ($model) {
                return $model->PPK != null;
            }, 'enableClientValidation' => false],
            ['PPK', 'required', 'when' => function ($model) {
                return $model->jspiu_PPK != null;
            }, 'enableClientValidation' => false],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['sah_ppk'] = ['PPK_sah'];
        $scenarios['sah_ppp'] = ['PPP_sah'];
        $scenarios['sah_pyd'] = ['PYD_sah'];
        $scenarios['sah_peer'] = ['PEER_sah'];
        $scenarios['sah_pyd_markah'] = ['tidak_setuju'];
        return $scenarios;
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
            'PEER' => 'Peer',
            'gred_jawatan_id_PEER' => 'Gred Jawatan Id Peer',
            'jspiu_PEER' => 'Jspiu Peer',
            'PYD_sah' => 'Pyd Sah',
            'PYD_sah_datetime' => 'Pyd Sah Datetime',
            'PPP_sah' => 'Ppp Sah',
            'PPP_sah_datetime' => 'Ppp Sah Datetime',
            'PPK_sah' => 'Ppk Sah',
            'PPK_sah_datetime' => 'Ppk Sah Datetime',
            'PEER_sah' => 'Peer Sah',
            'PEER_sah_datetime' => 'Peer Sah Datetime',
            'catatan' => 'Catatan',
            'is_aktif' => 'Is Aktif',
            'deleted_by' => 'Deleted By',
        ];
    }

    public function getGuru()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PYD']);
    }

    public function getPpp()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PPP']);
    }

    public function getPpk()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PPK']);
    }

    public function getPeer()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PEER']);
    }

    public function getDeptGuru()
    {
        return $this->hasOne(Department::className(), ['id' => 'jfpiu']);
    }

    public function getGredGuru()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_jawatan_id']);
    }

    public function getTahunLpp()
    {
        return $this->hasOne(TblLppTahun::className(), ['lpp_tahun' => 'tahun']);
    }

    public function getSandanganKhidmat()
    {
        return $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'PYD'])
            ->andOnCondition(['sdgKhidmat.gredjawatan' => 'gred_jawatan_id'])
            ->andOnCondition(['sdgKhidmat.sandangan_id' => ['24', '25']]);
    }

    public function getTotalBahagian()
    {
        $cntBhg = RefBahagian::find()->count();
        $cntBhgLpp = TblMrkhBhg::find()->where(['lpp_id' => $this->lpp_id])->count();
        return ($cntBhg === $cntBhgLpp);
    }

    public function getMarkahAll()
    {
        return $this->hasOne(TblMarkahKeseluruhan::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getSumMarkah()
    {
        $sum = TblMrkhBhg::find()
            ->where(['lpp_id' => $this->lpp_id])
            ->sum('markah');

        return $sum;
    }

    public function getMarkahAkhir()
    {
        $m = TblMarkahKeseluruhan::find()->where(['lpp_id' => $this->lpp_id])->one();
        return $m ? $m->markah : '';
    }

    public function validatePengesahanPyd($attribute, $params, $validator)
    {
        if (!$this->PYD_sah) {
            $this->addError($attribute, 'Sila pangkah sebelum hantar borang.');
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function validatePengesahanMarkahPyd($attribute, $params, $validator)
    {
        if (!$this->tidak_setuju) {
            $this->addError($attribute, 'Sila pangkah sebelum hantar pengesahan.');
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function validatePengesahanPpp($attribute, $params, $validator)
    {
        if (!$this->PYD_sah) {
            $this->addError($attribute, 'PYD belum menghantar borang LNPT.');
        }

        if (!$this->PPP_sah) {
            $this->addError($attribute, 'Sila pangkah sebelum hantar pengesahan.');
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function validatePengesahanPpk($attribute, $params, $validator)
    {
        if (!$this->PYD_sah) {
            $this->addError($attribute, 'PYD belum menghantar borang LNPT.');
        }

        if (!$this->PPK_sah) {
            $this->addError($attribute, 'Sila pangkah sebelum hantar pengesahan.');
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function validatePengesahanPeer($attribute, $params, $validator)
    {
        // if (!$this->PYD_sah) {
        //     $this->addError($attribute, 'PYD belum menghantar borang LNPT.');
        // }

        if (!$this->PEER_sah) {
            $this->addError($attribute, 'Sila pangkah sebelum hantar pengesahan.');
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function penetapPeer($attribute, $params, $validator)
    {
        if (($this->PEER == $this->PPP) or ($this->PEER == $this->PPK)) {
            $this->addError('PEER', 'Peer');
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function getStatusBorang()
    {
        if ($this->PYD_sah == 0) {
            $res = 'Menunggu Pengesahan anda';
        } else if ($this->PPP_sah == 0) {
            $res = 'Menunggu Pengesahan PPP';
        } else if ($this->PPK_sah == 0) {
            $res = 'Menunggu Pengesahan PPK';
        } else if ($this->PEER_sah == 0) {
            $res = 'Menunggu Pengesahan PEER';
        } else {
            $mrkh = TblMarkahKeseluruhan::findOne(['lpp_id' => $this->lpp_id]);
            $res1 = $mrkh->markah;
        }

        return isset($res) ? '<span class="label label-warning">' . $res . '</span>' : $res1;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (!empty($this->PPP)) {
            $ppp_gred = \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $this->PPP]);
            $this->gred_jawatan_id_PPP = $ppp_gred->gredJawatan;
        } else {
            $this->gred_jawatan_id_PPP = null;
        }

        if (!empty($this->PPK)) {
            $ppk_gred = \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $this->PPK]);
            $this->gred_jawatan_id_PPK = $ppk_gred->gredJawatan;
        } else {
            $this->gred_jawatan_id_PPK = null;
        }

        if (!empty($this->PEER)) {
            $peer_gred = \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $this->PEER]);
            $this->gred_jawatan_id_PEER = $peer_gred->gredJawatan;
        } else {
            $this->gred_jawatan_id_PEER = null;
        }

        // ...custom code here...
        return true;
    }

    public function getOutreachingManual()
    {
        return $this->hasMany(TblOutreachingManual::className(), ['lpp_id' => 'lpp_id']);
    }

    //cvonline

    public function getOutreachingManualInternational()
    {
        return $this->hasMany(TblOutreachingManual::className(), ['lpp_id' => 'lpp_id'])->where(['tahap_penyertaan' => 'International']);
    }

    public function getOutreachingManualNational()
    {
        return $this->hasMany(TblOutreachingManual::className(), ['lpp_id' => 'lpp_id'])->where(['tahap_penyertaan' => 'National']);
    }

    public function getOutreachingManualState()
    {
        return $this->hasMany(TblOutreachingManual::className(), ['lpp_id' => 'lpp_id'])->where(['tahap_penyertaan' => 'State']);
    }

    public function getOutreachingManualUniversity()
    {
        return $this->hasMany(TblOutreachingManual::className(), ['lpp_id' => 'lpp_id'])->where(['tahap_penyertaan' => 'University']);
    }

    public function getOutreachingManualDaerah()
    {
        return $this->hasMany(TblOutreachingManual::className(), ['lpp_id' => 'lpp_id'])->where(['tahap_penyertaan' => 'Daerah']);
    }

    public function getOutreachingManualSekolah()
    {
        return $this->hasMany(TblOutreachingManual::className(), ['lpp_id' => 'lpp_id'])->where(['tahap_penyertaan' => 'Sekolah']);
    }

    public function getOutreachingManualKampung()
    {
        return $this->hasMany(TblOutreachingManual::className(), ['lpp_id' => 'lpp_id'])->where(['tahap_penyertaan' => 'Kampung']);
    }



    public function getBulanPgt()
    {
        return $this->hasOne(TblBulanPgt::className(), ['ICNO' => 'PYD']);

        //        $connection = Yii::$app->getDb();
        //        $command = $connection->createCommand("
        //            SELECT `a`.`ICNO` AS `ICNO`,`a`.`SalMoveMth` AS `SalMoveMth`,`a`.`SalMoveMthType` 
        //            AS `SalMoveMthType`,`a`.`SalMoveMthStDt` AS `SalMoveMthStDt`,`a`.`id` AS `id` 
        //            FROM `hronline`.`tblrscosalmovemth` `a` WHERE (`a`.`SalMoveMthStDt` = (SELECT MAX(`temp`.`SalMoveMthStDt`) 
        //            AS `MAX(temp.``SalMoveMthStDt``)` FROM `hronline`.`tblrscosalmovemth` `temp` WHERE (`temp`.`ICNO` = `a`.`ICNO`))) 
        //            AND	 icno = :icno
        //            GROUP BY `a`.`ICNO`", [':icno' => $this->PYD]);
        //
        //        $result = $command->queryOne();
        //        
        //        return $result['SalMoveMth'];

    }

    //cvonline
    public function getTeknologiInvasi()
    {
        return $this->hasMany(\app\models\elnpt\elnpt2\TblTeknologiInovasi::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getPengajaranManual()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaranPembelajaran::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getPenyelidikanManual()
    {
        return $this->hasMany(\app\models\elnpt\TblPenyelidikanManual::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getPenyelidikanManualLeader()
    {
        return $this->hasMany(\app\models\elnpt\TblPenyelidikanManual::className(), ['lpp_id' => 'lpp_id'])->where(['peranan' => 'Leader'])->OrderBy(['mula' => SORT_ASC]);
    }

    public function getPenyelidikanManualMember()
    {
        return $this->hasMany(\app\models\elnpt\TblPenyelidikanManual::className(), ['lpp_id' => 'lpp_id'])->where(['peranan' => 'Member'])->OrderBy(['mula' => SORT_ASC]);
    }

    public function getCdg()
    {
        return $this->hasOne(TblCadanganApc::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getApc()
    {
        return $this->hasOne(TblApc::className(), ['ICNO' => 'PYD']);
    }

    public function getApt()
    {
        return $this->hasOne(TblApt::className(), ['ICNO' => 'PYD']);
    }

    public function getSandangan()
    {
        return $this->hasOne(TblSandangan::className(), ['icno' => 'PYD']);
    }

    public function getSandangan2()
    {
        return $this->hasOne(TblSandangan2::className(), ['icno' => 'PYD']);
    }

    public function getSandangan3()
    {
        return $this->hasOne(TblSandangan3::className(), ['icno' => 'PYD']);
    }

    public function getAlasan()
    {
        return $this->hasMany(TblAlasanSemakan::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getProfilePic()
    {
        return '<img src="https://hronline.ums.edu.my/picprofile/picstf/' . strtoupper(sha1($this->PYD)) . '.jpeg" width="150" height="180">';
    }
}
