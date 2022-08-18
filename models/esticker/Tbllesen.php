<?php

namespace app\models\esticker;

use Yii; 
use app\models\esticker\JenisLesen;
use app\models\esticker\KelasLesen; 
use yii\helpers\Html;
/**
 * This is the model class for table "hronline.tblprlic".
 *
 * @property string $licId
 * @property string $ICNO
 * @property string $LicNo
 * @property string $LicCd
 * @property string $LicClassCd
 * @property string $LicExpiryDt
 * @property string $LicRnwlFee
 * @property string $FirstLicIssuedDt
 */
class Tbllesen extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public $file ;
    
    public static function tableName()
    {
        return 'keselamatan.stc_tblprlic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LicNo', 'LicCd', 'LicClassCd', 'LicExpiryDt', 'FirstLicIssuedDt', 'LicRnwlFee'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['LicNo'], 'unique', 'message' => 'Nombor Lesen sudah wujud!'],
            [['LicExpiryDt', 'FirstLicIssuedDt'], 'safe'],
            [['LicRnwlFee'], 'number'],
            [['ICNO'], 'string', 'max' => 12],
            [['LicNo'], 'string', 'max' => 20],
            [['LicCd'], 'string', 'max' => 2],
            [['LicClassCd'], 'string', 'max' => 3],
            [['filename'], 'string', 'max'=>100],
            [['file'],'safe'],
            [['file'], 'file','extensions'=>'pdf'],

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
            'LicNo' => 'Nombor Lesen',
            'LicCd' => 'Jenis Lesen',
            'LicClassCd' => 'Kelas Lesen',
            'LicExpiryDt' => 'Tarikh Luput',
            'LicRnwlFee' => 'Yuran Pembaharuan',
            'FirstLicIssuedDt' => 'Tarikh Dikeluarkan',
        ];
    }
    
    public function getJenisLesen() {
        return $this->hasOne(JenisLesen::className(), ['LicCd' => 'LicCd']);
    }
    
    public function getJenlesen() {
        if($this->jenisLesen){
            return $this->jenisLesen->LicType;
        }
        return '-';
    }
    
    public function getKelasLesen() {
        return $this->hasOne(KelasLesen::className(), ['LicClassCd' => 'LicClassCd']);
    }
    
    public function getKellesen() {
        if($this->kelasLesen){
            return $this->kelasLesen->LicClass;
        }
        return '-';
    }

    public function getDisplayLink() {
        if(!empty($this->filename)){
        return html::a(Yii::$app->FileManager->NameFile($this->filename), Yii::$app->FileManager->DisplayFile($this->filename), ['target'=>'_blank']);
        }
        return 'Tiada Maklumat!';
    }
    
    public function getFirstLicIssuedDt() {
        return Yii::$app->MP->Tarikh($this->FirstLicIssuedDt);
    }
    public function getLicExpiryDt() {
        return Yii::$app->MP->Tarikh($this->LicExpiryDt);
    }
     
    public static function expirydate($icno) {
        return Tbllesen::find()->where(['ICNO' => $icno])->orderBy(['licId' => SORT_DESC])->one()?
                Tbllesen::find()->where(['ICNO' => $icno])->orderBy(['licId' => SORT_DESC])->one()->LicExpiryDt:'';
    }
}
