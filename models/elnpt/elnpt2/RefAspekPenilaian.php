<?php

namespace app\models\elnpt\elnpt2;

use app\models\hronline\Department;
use app\models\hronline\Tblrscoadminpost;
use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "hrm.elnpt_v2_ref_aspek_penilaian".
 *
 * @property int $id
 * @property int $bhg_no
 * @property string $aspek
 * @property string $desc
 */
class RefAspekPenilaian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_ref_aspek_penilaian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bhg_no'], 'integer'],
            [['aspek', 'desc'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bhg_no' => 'Bhg No',
            'aspek' => 'Aspek',
            'desc' => 'Desc',
        ];
    }

    public function getPeratus($gred, $bhg_no = null, $dept_no = null, $icno = null)
    {
        if ($bhg_no == 11) {
            return $this->hasMany(RefAspekPeratus::className(), ['aspek_id' => 'id']);
        }

        if (!is_null($bhg_no) && !is_null($dept_no)) {
            $kump_dept = TblKumpDept::find()->where(['dept_id' => $dept_no])->one();
            if ($bhg_no == 1) {
                if ($this->id == 1) {
                    $dept_cat = Department::find()->where(['id' => $dept_no])->one();
                    // if (!Tblrscoadminpost::find()->where(['ICNO' => $icno, 'dept_id' => $dept_no, 'paymentStatus' => 1, 'flag' => 1])->exists()) {
                    if ($dept_cat->category_id == 1) {
                        switch (true) {
                            case $gred == 'DS45':
                            case $gred == 'DG41':
                            case $gred == 'DG44':
                                $peratusGred = 0;
                                break;
                            case $gred == 'DS51':
                            case $gred == 'DS52':
                            case $gred == 'DG48':
                            case $gred == 'DG52':
                            case $gred == 'DU51':
                            case $gred == 'DU52':
                                $peratusGred = 5;
                                break;
                            case $gred == 'DS53':
                            case $gred == 'DS54':
                            case $gred == 'DG54':
                            case $gred == 'DU54':
                            case $gred == 'DU56':
                            case $gred == 'UMSDF8':
                                $peratusGred = 10;
                                break;
                            default:
                                $peratusGred = 15;
                        }
                    } else {
                        $peratusGred = 25;
                    }
                } else {
                    $peratusGred = 0;
                }
            } else if (($bhg_no == 4)) {
                if (in_array($kump_dept->ref_kump_dept_id, [1, 2, 4, 5, 6])) {
                    switch (true) {
                        case $gred == 'DS45':
                        case $gred == 'DG41':
                        case $gred == 'DG44':
                            $peratusGred = 30;
                            break;
                        case $gred == 'DS51':
                        case $gred == 'DS52':
                        case $gred == 'DG48':
                        case $gred == 'DG52':
                        case $gred == 'DU51':
                        case $gred == 'DU52':
                            $peratusGred = 20;
                            break;
                        case $gred == 'DS53':
                        case $gred == 'DS54':
                        case $gred == 'DG54':
                        case $gred == 'DU54':
                        case $gred == 'DU56':
                        case $gred == 'UMSDF8':
                            $peratusGred = 10;
                            break;
                        default:
                            $peratusGred = 10;
                    }
                } else if (in_array($kump_dept->ref_kump_dept_id, [3])) {
                    switch (true) {
                        case $gred == 'DS45':
                            // case $gred == 'DG41':
                            // case $gred == 'DG44':
                            $peratusGred = 20;
                            break;
                        case $gred == 'DS51':
                        case $gred == 'DS52':
                            // case $gred == 'DG48':
                            // case $gred == 'DG52':
                            // case $gred == 'DU51':
                            // case $gred == 'DU52':
                            $peratusGred = 10;
                            break;
                        case $gred == 'DS53':
                        case $gred == 'DS54':
                            // case $gred == 'DG54':
                            // case $gred == 'DU54':
                            // case $gred == 'DU56':
                        case $gred == 'UMSDF8':
                            $peratusGred = 0;
                            break;
                        default:
                            $peratusGred = 0;
                    }
                }
            } else if (in_array($kump_dept->ref_kump_dept_id, [2, 4, 5])) {
                switch (true) {
                    case $gred == 'DS45':
                    case $gred == 'DG41':
                    case $gred == 'DG44':
                        $peratusGred = 20;
                        break;
                    case $gred == 'DS51':
                    case $gred == 'DS52':
                    case $gred == 'DG48':
                    case $gred == 'DG52':
                    case $gred == 'DU51':
                    case $gred == 'DU52':
                        $peratusGred = 10;
                        break;
                    case $gred == 'DS53':
                    case $gred == 'DS54':
                    case $gred == 'DG54':
                    case $gred == 'DU54':
                    case $gred == 'DU56':
                    case $gred == 'UMSDF8':
                        $peratusGred = 0;
                        break;
                    default:
                        $peratusGred = 0;
                }
            } else {
                switch (true) {
                    case $gred == 'DS45':
                    case $gred == 'DG41':
                    case $gred == 'DG44':
                        $peratusGred = 10;
                        break;
                    case $gred == 'DS51':
                    case $gred == 'DS52':
                    case $gred == 'DG48':
                    case $gred == 'DG52':
                    case $gred == 'DU51':
                    case $gred == 'DU52':
                        $peratusGred = 0;
                        break;
                    case $gred == 'DS53':
                    case $gred == 'DS54':
                    case $gred == 'DG54':
                    case $gred == 'DU54':
                    case $gred == 'DU56':
                    case $gred == 'UMSDF8':
                        $peratusGred = -10;
                        break;
                    default:
                        $peratusGred = -10;
                }
            }
        } else {
            switch (true) {
                case $gred == 'DS45':
                case $gred == 'DG41':
                case $gred == 'DG44':
                    $peratusGred = 30;
                    break;
                case $gred == 'DS51':
                case $gred == 'DS52':
                case $gred == 'DG48':
                case $gred == 'DG52':
                case $gred == 'DU51':
                case $gred == 'DU52':
                    $peratusGred = 20;
                    break;
                case $gred == 'DS53':
                case $gred == 'DS54':
                case $gred == 'DG54':
                case $gred == 'DU54':
                case $gred == 'DU56':
                case $gred == 'UMSDF8':
                    $peratusGred = 10;
                    break;
                default:
                    $peratusGred = 0;
            }
        }

        return $this->hasMany(RefAspekPeratus::className(), ['aspek_id' => 'id'])
            ->select(new Expression('elnpt_v2_ref_aspek_peratus.id, elnpt_v2_ref_aspek_peratus.bahagian, elnpt_v2_ref_aspek_peratus.aspek_id, elnpt_v2_ref_aspek_peratus.min_skor, elnpt_v2_ref_aspek_peratus.julat_skor, LEAST(( IF(elnpt_v2_ref_aspek_peratus.peratus = 0, elnpt_v2_ref_aspek_peratus.peratus, elnpt_v2_ref_aspek_peratus.peratus  + ' . $peratusGred . ')), 100) as peratus'))
            ->orderBy(['aspek_id' => SORT_ASC, 'min_skor' => SORT_ASC]);
    }

    public function getSkor()
    {
        return $this->hasMany(RefAspekSkor::className(), ['aspek_id' => 'id'])
            ->select(new Expression('elnpt_v2_ref_aspek_skor.id, elnpt_v2_ref_aspek_skor.bahagian, elnpt_v2_ref_aspek_skor.aspek_id, elnpt_v2_ref_aspek_skor.desc, elnpt_v2_ref_aspek_skor.skor'))
            ->orderBy(['elnpt_v2_ref_aspek_skor.aspek_id' => SORT_ASC, 'elnpt_v2_ref_aspek_skor.skor' => SORT_ASC]);
    }

    public function getPemberat()
    {
        return $this->hasOne(RefAspekPemberat::className(), ['aspek_id' => 'id']);
    }
}
