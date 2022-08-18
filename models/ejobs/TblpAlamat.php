<?php

namespace app\models\ejobs;

use Yii;
use app\models\hronline\JenisAlamat;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use app\models\hronline\Bandar;
use app\models\hronline\Tblalamat;
/**
 * This is the model class for table "ejobs.tbl_alamat".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $StateCd
 * @property string $CityCd
 * @property string $AddrTypeCd
 * @property string $CountryCd
 * @property string $Addr1
 * @property string $Addr2
 * @property string $Addr3
 * @property string $Postcode
 * @property string $TelNo
 */
class TblpAlamat extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ejobs.tbl_alamat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ICNO', 'StateCd', 'CityCd', 'CountryCd', 'AddrTypeCd', 'Addr1', 'TelNo', 'Postcode'], 'required', 'message' => 'Required'],
            [['ICNO', 'Postcode'], 'string', 'max' => 12],
            [['StateCd'], 'string', 'max' => 5],
            [['CityCd'], 'string', 'max' => 6],
            [['AddrTypeCd'], 'string', 'max' => 2],
            [['CountryCd'], 'string', 'max' => 3],
            [['Addr1', 'Addr2', 'Addr3'], 'string', 'max' => 50],
            [['TelNo'], 'string', 'max' => 14],
            [['ICNO', 'Addr1'], 'unique', 'targetAttribute' => ['ICNO', 'Addr1']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'StateCd' => 'Negeri',
            'CityCd' => 'Daerah',
            'AddrTypeCd' => 'Jenis Alamat',
            'CountryCd' => 'Negara',
            'Addr1' => 'Alamat 1',
            'Addr2' => 'Alamat 2',
            'Addr3' => 'Alamat 3',
            'Postcode' => 'Poskod',
            'TelNo' => 'Tel No',
        ];
    }

    public function getJenisAlamat() {
        return $this->hasOne(JenisAlamat::className(), ['AddrTypeCd' => 'AddrTypeCd']);
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
        
        if(ucwords($this->Addr2)){
            $add2 = ', ';
        }else{
            $add2 = '';
        }
        
        if(ucwords($this->Addr3)){
            $add3 = ', ';
        }else{
            $add3 = '';
        }
        
        return  ucwords($this->Addr1) . ', ' .  $add2 . $add3 .
                $this->Postcode . ', ' . $this->bandar->City . ', ' . $this->negeri->State . ', ' . $this->negara->Country . '.';
    }

    public function LaporDiri($ICNO) {
        $model = TblpAlamat::findAll(['ICNO' => $ICNO]);
        $simpan = new Tblalamat();

        if ($model) {
            foreach ($model as $model) {
                $simpan->ICNO = $model->ICNO;
                $simpan->StateCd = $model->StateCd;
                $simpan->CityCd = $model->CityCd;
                $simpan->AddrTypeCd = $model->AddrTypeCd;
                $simpan->CountryCd = $model->CountryCd;
                $simpan->Addr1 = $model->Addr1;
                $simpan->Addr2 = $model->Addr2;
                $simpan->Addr3 = $model->Addr3;
                $simpan->Postcode = $model->Postcode;
                $simpan->TelNo = $model->TelNo;
                $simpan->save(false);
            }
        }
    }

}
