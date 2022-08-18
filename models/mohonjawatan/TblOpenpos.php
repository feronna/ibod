<?php

namespace app\models\mohonjawatan;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;

use Yii;

/**
 * This is the model class for table "mohonjawatan.tbl_openpos".
 *
 * @property int $id
 * @property string $icno icno pembuka permohonan
 * @property string $date_start
 * @property string $date_end
 * @property int $status 1 = active ,2 = inactive
 */
class TblOpenpos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.mj_tbl_openpos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_start', 'date_end','entry_dt'], 'safe'],
            [['status'], 'integer'],
            [['icno'], 'string', 'max' => 15],
            [['remark'], 'string', 'max' => 150],
            [['remark'],'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'icno',
            'date_start' => 'Tarikh Mula',
            'date_end' => 'Tarikh Akhir',
            'status' => 'Status',
            'remark' => 'Remark',
            'entry_date' => 'Tarikh Masuk',
        ];
    }
     public function getTarikhMohon() {
        return $this->date_start ? date('d/m/Y', strtotime($this->date_start)) : '-';
    }
   
    public function getKakitangan()
    {
                return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getSenaraipermohonan() {
        return $this->hasOne(RefWp::className(), ['id' => 'id']);
    }
    public function getGredjawatan(){
        return $this->hasOne(GredJawatan::className(), ['id' => 'jawatan_dipohon']);
    }
     public function getStatusLabel() {
        if ($this->status == 'ENTRY') {
            return '<span class="label label-warning">ENTRY</span>';
        }

        if ($this->status == 'VERIFIED') {
            return '<span class="label label-primary">VERIFIED</span>';
        }

        if ($this->status == 'APPROVED') {
            return '<span class="label label-success">APPROVED</span>';
        }
         if ($this->status == 'PINDAAN') {
            return '<span class="label label-info">PINDAAN</span>';
        }
    }
     public function getTarikhAkhir()
    {
        return $this->hasOne(TblOpenpos::classname(),['status'=>1]);
    }
    
    public function getStat(){
         if ($this->status == 1 ) {
            return '<span class="label label-success">Aktif</span>';
        }
         if ($this->status == 0 ) {
            return '<span class="label label-danger">Tidak Aktif</span>';
        }
        
    }
    public function getTarikhMula(){
               return $this->date_start ? date('d/m/Y', strtotime($this->date_start)) : '-';
    }
    public function getTarikhTamat(){
                  return $this->date_end ? date('d/m/Y', strtotime($this->date_end)) : '-';
}
    
}
    