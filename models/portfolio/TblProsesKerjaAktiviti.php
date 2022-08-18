<?php

namespace app\models\portfolio;
use app\models\portfolio\TblProsesKerja;
use Yii;

/**
 * This is the model class for table "hrm.portfolio_tbl_proses_kerja_aktiviti".
 *
 * @property int $id
 * @property int $myjd_id
 * @property string $icno
 * @property int $section_id
 * @property int $unit_id
 * @property int $fungsi_unit
 * @property int $aktiviti_fungsi
 * @property string $tanggungjawab
 * @property string $aktiviti
 * @property string $proses_kerja
 * @property string $pegawai_lain
 * @property string $undang
 * @property string $tempoh
 * @property string $rajah
 * @property string $file
 * @property string $created_at
 */
class TblProsesKerjaAktiviti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_proses_kerja_aktiviti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_proses','myjd_id'], 'integer'],
            [['proses_kerja'], 'string'],
            [['created_at'], 'safe'],
            [['icno', 'tanggungjawab', 'pegawai_lain'], 'string', 'max' => 15],
            
            [['undang', 'tempoh', 'rajah'], 'string', 'max' => 500],
          //  [['file'], 'string', 'max' => 255],
                //   [['file'], 'file','extensions'=>'pdf','maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'], 
            

            [['tanggungjawab', 'tempoh' , 'proses_kerja'], 'required','message' => Yii::t('app', 'Wajib Diisi')]  

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'myjd_id' => 'Myjd ID',
            'icno' => 'Icno',
            'section_id' => 'Section ID',
            'unit_id' => 'Unit ID',
            'fungsi_unit' => 'Fungsi Unit',
            'aktiviti_fungsi' => 'Aktiviti Fungsi',
            'tanggungjawab' => 'Tanggungjawab',
            'aktiviti' => 'Aktiviti',
            'proses_kerja' => 'Proses Kerja',
            'pegawai_lain' => 'Pegawai Lain',
            'undang' => 'Undang',
            'tempoh' => 'Tempoh',
            'rajah' => 'Rajah',
            'file' => 'File',
            'created_at' => 'Created At',
        ];
    }
    
    
           public function getPegawai() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'pegawai_lain']);
    }
         public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'tanggungjawab']);
    }
    
   public function getAktivitiProses() {
        return $this->hasOne(TblProsesKerja::className(), ['id' => 'id_proses']);
    }
    
    
}
