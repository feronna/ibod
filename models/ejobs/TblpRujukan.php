<?php

namespace app\models\ejobs;

use Yii;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use app\models\hronline\Bandar;
/**
 * This is the model class for table "ejobs.tbl_rujukan".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $nama
 * @property string $hubungan
 * @property string $jawatan
 * @property string $nama_majikan
 * @property string $Addr1
 * @property string $Addr2
 * @property string $Addr3
 * @property string $Postcode
 * @property string $StateCd
 * @property string $CityCd
 * @property string $CountryCd
 * @property string $TelNo
 * @property string $Emel
 */
class TblpRujukan extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_rujukan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'nama', 'hubungan', 'jawatan', 'nama_majikan', 'Addr1', 'Postcode', 'StateCd', 'CityCd', 'CountryCd', 'TelNo', 'Emel'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['ICNO', 'Postcode'], 'string', 'max' => 12],
            [['nama', 'jawatan', 'Emel'], 'string', 'max' => 100],
            [['hubungan', 'Addr1', 'Addr2', 'Addr3'], 'string', 'max' => 50],
            [['nama_majikan'], 'string', 'max' => 150],
            [['StateCd'], 'string', 'max' => 5],
            [['CityCd'], 'string', 'max' => 6],
            [['CountryCd'], 'string', 'max' => 3],
            [['TelNo'], 'string', 'max' => 14],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'nama' => 'Nama',
            'hubungan' => 'Hubungan',
            'jawatan' => 'Jawatan',
            'nama_majikan' => 'Nama Majikan',
            'Addr1' => 'Addr1',
            'Addr2' => 'Addr2',
            'Addr3' => 'Addr3',
            'Postcode' => 'Postcode',
            'StateCd' => 'State Cd',
            'CityCd' => 'City Cd',
            'CountryCd' => 'Country Cd',
            'TelNo' => 'Tel No',
            'Emel' => 'Emel',
        ];
    }
    
    public function getNegara() {
        return $this->hasOne(Negara::className(), ['CountryCd' => 'CountryCd']);
    }

    public function getNegeri() {
        return $this->hasOne(Negeri::className(), ['StateCd' => 'StateCd']);
    }

    public function getBandar() {
        return $this->hasOne(Bandar::className(), ['CityCd' => 'CityCd']);
    }

    public function getAlamatPenuh() { 
        return $this->Addr1.', '.$this->Addr2.', '.$this->Addr3.'</br>'.
               $this->Postcode.', '.$this->bandar->City.', '.$this->negeri->State.', '.$this->negara->Country.'.';
    }
}
