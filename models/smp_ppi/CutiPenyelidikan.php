<?php

namespace app\models\smp_ppi;

use app\models\UtilitiesFunc;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dbo.vw_CutiPenyelidikan".
 *
 * @property string $NoKadPengenalan
 * @property string $ProjectID
 * @property string $TajukPenyelidikan
 * @property string $RingkasanPenyelidikan
 * @property string $TempatPenyelidikan
 * @property string $Penganjur
 * @property string $JangkanHasil
 * @property string $StartDate
 * @property string $EndDate
 */
class CutiPenyelidikan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_CutiPenyelidikan';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db6');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TajukPenyelidikan', 'RingkasanPenyelidikan', 'TempatPenyelidikan', 'JangkanHasil'], 'string'],
            [['StartDate', 'EndDate'], 'safe'],
            [['NoKadPengenalan', 'ProjectID'], 'string', 'max' => 50],
            [['Penganjur'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NoKadPengenalan' => 'No Kad Pengenalan',
            'ProjectID' => 'Project ID',
            'TajukPenyelidikan' => 'Tajuk Penyelidikan',
            'RingkasanPenyelidikan' => 'Ringkasan Penyelidikan',
            'TempatPenyelidikan' => 'Tempat Penyelidikan',
            'Penganjur' => 'Penganjur',
            'JangkanHasil' => 'Jangkan Hasil',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
        ];
    }


    /**
     * list of research list array sesuai digunakan utk dropdown
     * 
     * parameter icno 
     * 
     * 
     * result array ['project_id','tajuk_penyelidikan']
     * 
     * example output [
     *'GTA(S)003' => 'Inovasi dakwah masjid bandaraya kota kinabalu (Program Dakwah)'
     *'SLB0112-SKK-2015' => 'Genotyping of Rotavirus in Kota Kinabalu, Sabah'
     *'GPS0017-NSNH-1/2009' => 'Frogs Diversity and their Microhabitats in Tawau Hills Park, Sabah.'
     *]
     */
    public static function staffResearchList($icno)
    {

        $model = self::find()->where(['NoKadPengenalan' => $icno])->all();

        $arr = [];

        if ($model) {
            $arr = ArrayHelper::map($model, 'ProjectID', 'newTajuk');
        }

        return $arr;
    }

    public function getNewTajuk(){
        return $this->TajukPenyelidikan . ' (' . UtilitiesFunc::changeDateFormat($this->StartDate) . ')';
    }

    public static function title($id,$icno){
        $model = self::find()->where(['ProjectID' => $id,'NoKadPengenalan' => $icno])->one();

    }
}
