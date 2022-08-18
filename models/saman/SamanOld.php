<?php

namespace app\models\saman;
use yii\data\ActiveDataProvider;
use app\models\saman\SamanStatus;
use Yii;

/**
 * This is the model class for table "e_saman.t_02_eks_saman".
 *
 * @property string $NOSAMAN
 * @property string $TRKHSAMAN
 * @property string $KATEGORI
 * @property string $IDNO
 * @property string $NAMA
 * @property string $ICNO
 * @property string $NO_KENDERAAN
 * @property string $SIRI_PELEKAT
 * @property string $KODJENIS
 * @property string $KODMODEL
 * @property string $LOKASI
 * @property string $KODKAMPUS
 * @property string $KODKOLEJ
 * @property string $KODJFPIU
 * @property string $KODPROGRAM
 * @property string $TOTALAMN1
 * @property string $TOTALAMN2
 * @property string $TOTALAMN3
 * @property string $TOTALAMN4
 * @property string $KODSALAH1
 * @property string $NOTA1
 * @property string $KODSALAH1_AMN1
 * @property string $KODSALAH1_AMN2
 * @property string $KODSALAH1_AMN3
 * @property string $KODSALAH1_AMN4
 * @property string $KODSALAH2
 * @property string $NOTA2
 * @property string $KODSALAH2_AMN1
 * @property string $KODSALAH2_AMN2
 * @property string $KODSALAH2_AMN3
 * @property string $KODSALAH2_AMN4
 * @property string $KODSALAH3
 * @property string $NOTA3
 * @property string $KODSALAH3_AMN1
 * @property string $KODSALAH3_AMN2
 * @property string $KODSALAH3_AMN3
 * @property string $KODSALAH3_AMN4
 * @property string $KODSALAH4
 * @property string $NOTA4
 * @property string $KODSALAH4_AMN1
 * @property string $KODSALAH4_AMN2
 * @property string $KODSALAH4_AMN3
 * @property string $KODSALAH4_AMN4
 * @property string $NOKUNCI
 * @property string $KODBADAN
 * @property string $KODPGUATKUASA
 * @property string $DATELOG
 * @property string $LATITUD
 * @property string $LONGITUD
 * @property string $ACTION
 * @property string $ISTRANSFER
 * @property string $AMNKUNCI
 * @property string $STATUS
 * @property string $CATATAN
 */
class SamanOld extends \yii\db\ActiveRecord {

      public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ekeselamatan.t_02_eks_saman';
    }
    

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['NOSAMAN','TOTALAMN4','NO_KENDERAAN'], 'required'],
            [['TRKHSAMAN', 'DATELOG'], 'safe'],
            [['TOTALAMN1', 'TOTALAMN2', 'TOTALAMN3', 'TOTALAMN4', 'KODSALAH1_AMN1', 'KODSALAH1_AMN2', 'KODSALAH1_AMN3', 'KODSALAH1_AMN4', 'KODSALAH2_AMN1', 'KODSALAH2_AMN2', 'KODSALAH2_AMN3', 'KODSALAH2_AMN4', 'KODSALAH3_AMN1', 'KODSALAH3_AMN2', 'KODSALAH3_AMN3', 'KODSALAH3_AMN4', 'KODSALAH4_AMN1', 'KODSALAH4_AMN2', 'KODSALAH4_AMN3', 'KODSALAH4_AMN4', 'AMNKUNCI'], 'number'],
            [['NOSAMAN'], 'string', 'max' => 12],
            [['NOSAMAN','NO_KENDERAAN','ICNO'],  'filter', 'filter' => 'trim'],
            [['KATEGORI', 'NOKUNCI', 'ACTION', 'ISTRANSFER'], 'string', 'max' => 1],
            [['IDNO', 'NO_KENDERAAN'], 'string', 'max' => 15],
            [['NAMA'], 'string', 'max' => 60],
            [['ICNO'], 'string', 'max' => 16],
            [['SIRI_PELEKAT', 'KODKOLEJ', 'KODSALAH1', 'KODSALAH2', 'KODSALAH3', 'KODSALAH4', 'KODPGUATKUASA', 'LATITUD', 'LONGITUD'], 'string', 'max' => 10],
            [['KODJENIS', 'KODMODEL'], 'string', 'max' => 3],
            [['LOKASI', 'NOTA1', 'NOTA2', 'NOTA3', 'NOTA4', 'CATATAN'], 'string', 'max' => 100],
            [['KODKAMPUS'], 'string', 'max' => 5],
            [['KODJFPIU'], 'string', 'max' => 6],
            [['KODPROGRAM'], 'string', 'max' => 8],
            [['KODBADAN'], 'string', 'max' => 20],
            [['STATUS'], 'string', 'max' => 2],
            [['NOSAMAN'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'NOSAMAN' => 'No saman',
            'TRKHSAMAN' => 'Tarikh saman',
            'KATEGORI' => 'Kategori',
            'IDNO' => 'No Pekerja',
            'NAMA' => 'Nama',
            'ICNO' => 'No Kad Pegenalan',
            'NO_KENDERAAN' => 'No Kenderaan',
            'SIRI_PELEKAT' => 'Siri Pelekat',
            'KODJENIS' => 'Kodjenis',
            'KODMODEL' => 'Kodmodel',
            'LOKASI' => 'Lokasi',
            'KODKAMPUS' => 'Kodkampus',
            'KODKOLEJ' => 'Kodkolej',
            'KODJFPIU' => 'Kodjfpiu',
            'KODPROGRAM' => 'Kodprogram',
            'TOTALAMN1' => 'Jumlah 1',
            'TOTALAMN2' => 'Jumlah 2',
            'TOTALAMN3' => 'Jumlah 3',
            'TOTALAMN4' => 'Jumlah Saman',
            'KODSALAH1' => 'Kodsalah1',
            'NOTA1' => 'Nota1',
            'KODSALAH1_AMN1' => 'Kodsalah1 Amn1',
            'KODSALAH1_AMN2' => 'Kodsalah1 Amn2',
            'KODSALAH1_AMN3' => 'Kodsalah1 Amn3',
            'KODSALAH1_AMN4' => 'Kodsalah1 Amn4',
            'KODSALAH2' => 'Kodsalah2',
            'NOTA2' => 'Nota2',
            'KODSALAH2_AMN1' => 'Kodsalah2 Amn1',
            'KODSALAH2_AMN2' => 'Kodsalah2 Amn2',
            'KODSALAH2_AMN3' => 'Kodsalah2 Amn3',
            'KODSALAH2_AMN4' => 'Kodsalah2 Amn4',
            'KODSALAH3' => 'Kodsalah3',
            'NOTA3' => 'Nota3',
            'KODSALAH3_AMN1' => 'Kodsalah3 Amn1',
            'KODSALAH3_AMN2' => 'Kodsalah3 Amn2',
            'KODSALAH3_AMN3' => 'Kodsalah3 Amn3',
            'KODSALAH3_AMN4' => 'Kodsalah3 Amn4',
            'KODSALAH4' => 'Kodsalah4',
            'NOTA4' => 'Nota4',
            'KODSALAH4_AMN1' => 'Kodsalah4 Amn1',
            'KODSALAH4_AMN2' => 'Kodsalah4 Amn2',
            'KODSALAH4_AMN3' => 'Kodsalah4 Amn3',
            'KODSALAH4_AMN4' => 'Kodsalah4 Amn4',
            'NOKUNCI' => 'Nokunci',
            'KODBADAN' => 'Kodbadan',
            'KODPGUATKUASA' => 'Kodpguatkuasa',
            'DATELOG' => 'Datelog',
            'LATITUD' => 'Latitud',
            'LONGITUD' => 'Longitud',
            'ACTION' => 'Action',
            'ISTRANSFER' => 'Istransfer',
            'AMNKUNCI' => 'Amnkunci',
            'STATUS' => 'Status',
            'CATATAN' => 'Catatan',
        ];
    }

    public function getSaman() {
        return $this->hasOne(SamanStatus::className(), ['NOSAMAN' => 'NOSAMAN']);
    }
    
    public function getSamanPaid() {
        return $this->hasOne(SamanStatus::className(), ['NOSAMAN' => 'NOSAMAN']);
    }
    
    public function getSamanPending() {
        return $this->hasOne(SamanStatus::className(), ['NOSAMAN' => 'NOSAMAN']);
    }
    
    public static function findGrid($type) {
        
        if($type=='PENDING'){
            $query = SamanOld::find()->joinWith('saman')
                    ->where(['t_02_eks_saman.ICNO' => Yii::$app->user->getId()])
                    ->andWhere(['t_19_eks_bayar.STATUS'=>'PENDING']);
        }else{
            $query = SamanOld::find()->joinWith('saman')
                    ->where(['t_02_eks_saman.ICNO' => Yii::$app->user->getId()])
                    ->andWhere(['t_19_eks_bayar.STATUS'=>'PAID']);
        }
    
        $saman = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $saman;
    }

    public function changeDateFormat($date) {

        $dt = date_create($date);

        $v = date_format($dt, "d-m-Y");

        return $v;
    }

    public function getFormatTarikh() {

        return $this->changeDateFormat($this->TRKHSAMAN);
    }
  
}
