<?php

namespace app\models\aduan;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "keselamatan.rpt_tbl_siasatan".
 *
 * @property int $aduan_id aduan_id from rpt_tbl_aduan
 * @property string $penyiasat_icno ICNO from hronline.tblprcobiodata
 * @property string $penetap_icno Ketua BK whom will set the pegawai penyiasat for each case aduan.
 * @property string $date
 */
class RptTblSiasatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.rpt_tbl_siasatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aduan_id', 'penyiasat_icno'], 'required'],
            [['aduan_id'], 'integer'],
            [['date'], 'safe'],
            [['penyiasat_icno', 'penetap_icno'], 'string', 'max' => 12],
            [['aduan_id', 'penyiasat_icno'], 'unique', 'targetAttribute' => ['aduan_id', 'penyiasat_icno']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aduan_id' => 'Aduan ID',
            'penyiasat_icno' => 'Penyiasat Icno',
            'penetap_icno' => 'Penetap Icno',
            'date' => 'Date',
        ];
    }

    public function getBiodata()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'penyiasat_icno']);
    }

    public function getAduan()
    {
        return $this->hasOne(RptTblAduan::className(), ['aduan_id' => 'aduan_id']);
    }

    public function getPenyiasat($aduan_id)
    {

        $model = RptTblSiasatan::find()->where(['aduan_id' => $aduan_id])->all();

        $a = "";

        if ($model) {

            foreach ($model as $p) {
                $a = '</br>';
                $a = $a . ' ' . strtoupper($p->biodata->gelaran->Title) . ' ' . $p->biodata->CONm . '</br>';
                $a = $a . ' ' . strtoupper($p->biodata->displayJawatan) . '</br>';
                $a = $a . ' '.strtoupper($p->biodata->department->fullname) . '</br>';
                $a = $a . '<i class="fa fa-envelope"></i> '.strtolower($p->biodata->COEmail) . '</br>';
                $a = $a . '<i class="fa fa-phone"></i> '.strtoupper($p->biodata->COHPhoneNo) . '</br></br>';
                echo $a;
            }
        } else {
            echo '';
        }
    }
}
