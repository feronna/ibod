<?php

namespace app\models\portfolio;
use app\models\portfolio\RefFungsiUnit;
use Yii;
use app\models\portfolio\TblProsesKerjaAktiviti;

/**
 * This is the model class for table "hrm.portfolio_tbl_proses_kerja".
 *
 * @property int $id
 * @property string $icno
 * @property string $proses_kerja
 * @property string $pegawai_lain
 * @property string $undang-undang
 * @property string $tempoh
 * @property string $rajah
 */
class TblProsesKerja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $files;
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_proses_kerja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
 
            [['icno'], 'string', 'max' => 15],
              [['file'], 'string', 'max' => 255],
          //   [['file'], 'file','extensions'=>'pdf','maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'], 
          //  [['files'], 'file','extensions'=>'pdf','maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'], 
            [['section_id', 'unit_id', 'fungsi_unit','aktiviti_fungsi', 'undang' ], 'required','message' => Yii::t('app', 'Wajib Diisi')]  

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'proses_kerja' => 'Proses Kerja',
            'pegawai_lain' => 'Pegawai Lain',
            'undang-undang' => 'Undang Undang',
            'tempoh' => 'Tempoh',
            'rajah' => 'Rajah',
        ];
    }
    
//        public function getKakitangan() {
//        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'tanggungjawab']);
//    }
//    
//        public function getPegawai() {
//        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'pegawai_lain']);
//    }
    
       public function getFungsiUnit() {
        return $this->hasOne(RefFungsiUnit::className(), ['id' => 'fungsi_unit']);
    }
    
       public function getFungsiAktiviti() {
        return $this->hasOne(TblAktiviti::className(), ['id' => 'aktiviti_fungsi']);
    }
    
    
}
