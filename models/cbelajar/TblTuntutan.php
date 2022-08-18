<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_tuntutan".
 *
 * @property int $id
 * @property string $jenis_tuntutan
 * @property string $perkara
 * @property string $c1
 * @property string $j_gantirugi
 */
class TblTuntutan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_tuntutan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['c1'], 'string'],
            [['jenis_tuntutan', 'perkara', 'j_gantirugi', 'j_cb', 'icno', 'j_keseluruhan','movtype'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_tuntutan' => 'Jenis Tuntutan',
            'perkara' => 'Perkara',
            'c1' => 'C1',
            'j_gantirugi' => 'J Gantirugi',
            'icno' => 'ICNO',
            'j_cb' => 'JUMLAH PENGAJIAN',
            'j_keseluruhan' => 'KESELURUHAN',
            'movtype' => 'JENIS PERGERAKAN',
        ];
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getPengajian() {
       
        return $this->hasOne(TblPengajian::className(), ['id' => 'pID', 'HighestEduLevelCd'=>'HighestEduLevelCd']);
       
   }
   public function getPendidikanTertinggi() {
        return $this->hasOne(Edulevel::className(), ['HighestEduLevelCd'=>'jenis_tuntutan']);
   }

   public function getTahapPendidikan() {
      
       return $this->pendidikanTertinggi->HighestEduLevel;
   }
}
