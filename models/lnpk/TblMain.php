<?php

namespace app\models\lnpk;

use app\models\hronline\Department;
use Yii;

use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;

/**
 * This is the model class for table "hrm.lnpk_tbl_main".
 *
 * @property string $lnpk_id
 * @property string $lnpk_datetime
 * @property int $lnpk_jenis
 * @property string $PYD
 * @property int $PYD_sts_lantikan
 * @property int $gred_jawatan_id
 * @property string $tahun
 * @property int $jspiu
 * @property string $PP
 * @property int $gred_jawatan_id_PP
 * @property int $jspiu_PP
 * @property int $PP_sah
 * @property string $PP_sah_datetime
 * @property string $catatan
 * @property int $is_deleted
 * @property string $deleted_by
 * @property string $deleted_datetime
 */
class TblMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lnpk_tbl_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lnpk_datetime', 'PPP_sah_datetime', 'PPK_sah_datetime',  'deleted_datetime'], 'safe'],
            [[
                'lnpk_jenis', 'tahun',
                'PYD_sts_lantikan', 'gred_jawatan_id', 'jspiu',
                'gred_jawatan_id_PPP', 'jspiu_PPP', 'PPP_sah',
                'gred_jawatan_id_PPK', 'jspiu_PPK',   'PPK_sah',
                'is_deleted', 'isPP'
            ], 'integer'],
            [['PYD', 'PPP', 'PPK', 'deleted_by'], 'string', 'max' => 12],
            [['catatan'], 'string', 'max' => 255],
            [[
                'lnpk_datetime', 'tahun', 'lnpk_jenis',
                'PYD', 'PYD_sts_lantikan', 'gred_jawatan_id', 'jspiu',
                'PPP', 'gred_jawatan_id_PPP', 'jspiu_PPP',
            ], 'required'],
            ['PPP_sah', 'validatePengesahanPpp', 'on' => 'sah_ppp'],
            ['PPK_sah', 'validatePengesahanPpk', 'on' => 'sah_ppk'],
            [
                'PPK', 'required',
                // 'message' => 'Status must be APPROVED because Value is not empty',
                'when' => function ($model, $attribute) {
                    return $model->isPP == 0;
                },
                'whenClient' => "function (attribute, value) {
                    return ($('#ispp').val() == 0);
                }",
            ],
            // [
            //     'isPP', 'required', 'requiredValue' => 1,
            //     'message' => 'Status must be APPROVED because Value is not empty',
            //     'when' => function ($model, $attribute) {
            //         return $model->PPK == null;
            //     },
            //     // 'whenClient' => "function (attribute, value) {
            //     //     return ($('#setppk').val() === ''); 
            //     // }",
            // ],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['sah_ppp'] = ['PPP_sah'];
        $scenarios['sah_ppk'] = ['PPK_sah'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lnpk_id' => 'Lnpk ID',
            'lnpk_datetime' => 'Lnpk Datetime',
            'lnpk_jenis' => 'Lnpk Jenis',
            'PYD' => 'Pyd',
            'PYD_sts_lantikan' => 'Pyd Sts Lantikan',
            'gred_jawatan_id' => 'Gred Jawatan ID',
            'tahun' => 'Tahun',
            'jspiu' => 'Jspiu',
            'PP' => 'Pp',
            'gred_jawatan_id_PP' => 'Gred Jawatan Id Pp',
            'jspiu_PP' => 'Jspiu Pp',
            'PP_sah' => 'Pp Sah',
            'PP_sah_datetime' => 'Pp Sah Datetime',
            'catatan' => 'Catatan',
            'is_deleted' => 'Is Deleted',
            'deleted_by' => 'Deleted By',
            'deleted_datetime' => 'Deleted Datetime',
        ];
    }

    public function getJenisBorang()
    {
        return $this->hasOne(RefJenisLnpk::className(), ['id' => 'lnpk_jenis']);
    }

    public function getPyd()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PYD']);
    }

    public function getGredPyd()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_jawatan_id']);
    }

    public function getDeptPyd()
    {
        return $this->hasOne(Department::className(), ['id' => 'jspiu']);
    }

    public function getPpp()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PPP']);
    }

    public function getGredPpp()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_jawatan_id_PPP']);
    }

    public function getDeptPpp()
    {
        return $this->hasOne(Department::className(), ['id' => 'jspiu_PPP']);
    }

    public function getPpk()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PPK']);
    }

    public function getGredPpk()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_jawatan_id_PPK']);
    }

    public function getDeptPpk()
    {
        return $this->hasOne(Department::className(), ['id' => 'jspiu_PPK']);
    }

    public function getUlasan()
    {
        return $this->hasOne(TblUlasan::className(), ['lnpk_id' => 'lnpk_id']);
    }

    public function getSktSign()
    {
        return $this->hasOne(TblSktTandatangan::className(), ['lnpk_id' => 'lnpk_id']);
    }

    public function getStatusPenilaian()
    {
        $check = 0;

        if (($tmp = $this->ulasan) != null) {
            if ($tmp->ulasan_PPP_tt) {
                $check = 1;
            }
        }

        if (($tmp = $this->sktSign) != null) {
            if ($tmp->sign_PP) {
                $check = 2;
            }
        }

        if ($this->PPP_sah != null) {
            $check = 3;
            if ($this->isPP) {
                $check = 4;
            }
        }

        if ($this->PPK_sah != null) {
            $check = 4;
        }

        return $check;
    }

    public function getTotalMarkahPPP()
    {
        return $this->hasMany(TblKriteriaMarkah::className(), ['lnpk_id' => 'lnpk_id'])->sum('kriteria_markah_ppp');
    }

    public function getTotalMarkahPPK()
    {
        return $this->hasMany(TblKriteriaMarkah::className(), ['lnpk_id' => 'lnpk_id'])->sum('kriteria_markah_ppk');
    }

    public function validatePengesahanPpp($attribute, $params, $validator)
    {
        $ulasan = TblUlasan::find()->where(['lnpk_id' => $this->lnpk_id])->one();

        $skt = TblSktTandatangan::find()->where(['lnpk_id' => $this->lnpk_id])->one();

        if (($this->PPP == Yii::$app->user->identity->ICNO) && !$this->PPP_sah) {
            $this->addError($attribute, 'Sila pangkah sebelum hantar pengesahan.');
        }

        if (is_null($skt) || is_null($skt->sign_PP)) {
            $this->addError($attribute, 'Anda belum mengesahkan skt.');
        }

        if (is_null($ulasan) || is_null($ulasan->ulasan_PPP_tt)) {
            $this->addError($attribute, 'Anda belum mengesahkan ulasan.');
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function validatePengesahanPpk($attribute, $params, $validator)
    {
        $ulasan = TblUlasan::find()->where(['lnpk_id' => $this->lnpk_id])->one();

        if (($this->PPK == Yii::$app->user->identity->ICNO) && !$this->PPK_sah) {
            $this->addError($attribute, 'Sila pangkah sebelum hantar pengesahan.');
        }

        if (is_null($ulasan) || is_null($ulasan->ulasan_PPP_tt) || is_null($ulasan->ulasan_PPK_tt)) {
            $this->addError($attribute, 'Anda belum mengesahkan ulasan.');
        }

        $this->addErrors($this->getErrors($attribute));
    }

    public function isPYD()
    {
        if ($this->PYD == Yii::$app->user->identity->ICNO)
            return true;

        return false;
    }

    public function isPPP()
    {
        if ($this->PPP == Yii::$app->user->identity->ICNO)
            return true;

        return false;
    }

    public function isPPK()
    {
        if ($this->PPK == Yii::$app->user->identity->ICNO)
            return true;

        return false;
    }

    public function isPP()
    {
        if ($this->isPPP()) {
            if ($this->isPP) {
                return true;
            }
        }

        return false;
    }

    public function disableInputPPP()
    {
        if ($this->isPPP() || $this->isPP()) {
            if ($this->PPP_sah) {
                return true;
            }

            if ($this->isAdmin()) {
                return false;
            }
        }

        return false;
    }

    public function disableInputPPK()
    {
        if ($this->isPPK()) {
            if ($this->PPK_sah) {
                return true;
            }

            if ($this->isAdmin()) {
                return false;
            }
        }

        return false;
    }

    public function hideInputPPP()
    {
        if ($this->isAdmin()) {
            return false;
        }

        if ($this->isPPP() || $this->isPP()) {
            return false;
        }

        return true;
    }

    public function hideInputPPK()
    {
        if ($this->isAdmin()) {
            return false;
        }

        if ($this->isPPK()) {
            return false;
        }

        return true;
    }

    public function isAdmin()
    {
        return \app\models\lppums\TblStafAkses::find()
            ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
            ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
            ->andWhere(['IS NOT', 'a.akses_lpp_tahun', NULL])
            ->exists();
    }

    public function disableButton()
    {
        if ($this->isAdmin()) {
            return false;
        }

        if ($this->isPPP() || $this->isPP()) {
            if ($this->PPP_sah) {
                return true;
            }
        }

        if ($this->isPPK()) {
            if ($this->PPK_sah) {
                return true;
            }
        }

        return false;
    }
}
