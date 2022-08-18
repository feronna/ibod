<?php

namespace app\models\ejobs;

use Yii;
use app\models\hronline\JenisLesen;
use app\models\hronline\KelasLesen;
use app\models\hronline\Tbllesen;
/**
 * This is the model class for table "ejobs.tbl_lesen".
 *
 * @property string $licId
 * @property string $ICNO
 * @property string $LicNo
 * @property string $LicCd
 * @property string $LicClassCd
 * @property string $LicExpiryDt
 * @property string $FirstLicIssuedDt
 */
class TblpLesen extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    public $file ;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_lesen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'LicNo','FirstLicIssuedDt','LicCd','LicClassCd'], 'required', 'message'=>'Required'],
            [['LicExpiryDt', 'FirstLicIssuedDt','FileLesen'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['LicNo'], 'string', 'max' => 20],
            [['LicCd'], 'string', 'max' => 2],
            [['LicClassCd'], 'string', 'max' => 3],
            [['file'], 'file','extensions'=>'pdf', 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'licId' => 'Lic ID',
            'ICNO' => 'Icno',
            'LicNo' => 'No. Lesen',
            'LicCd' => 'Jenis Lesen',
            'LicClassCd' => 'Kelas Lesen',
            'LicExpiryDt' => 'Tarikh Luput',
            'FirstLicIssuedDt' => 'Tarikh Dikeluarkan',
        ];
    }
    
    public function getJenisLesen() {
        return $this->hasOne(JenisLesen::className(), ['LicCd' => 'LicCd']);
    }
    
    public function getKelasLesen() {
        return $this->hasOne(KelasLesen::className(), ['LicClassCd' => 'LicClassCd']);
    }
    
     public function LaporDiri($ICNO) {
        $model = TblpLesen::findAll(['ICNO' => $ICNO]);
        $simpan = new Tbllesen();

        if ($model) {
            foreach ($model as $model) {
                if ($model->LicNo) {
                    $simpan->ICNO = $model->ICNO;
                    $simpan->LicNo = $model->LicNo;
                    $simpan->LicCd = $model->LicCd;
                    $simpan->LicClassCd = $model->LicClassCd;
                    $simpan->LicExpiryDt = $model->LicExpiryDt;
                    $simpan->FirstLicIssuedDt = $model->FirstLicIssuedDt;
                    $simpan->save(false);
                }
            }
        }
    }
}
