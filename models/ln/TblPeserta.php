<?php

namespace app\models\ln;

use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "ln.tbl_peserta".
 *
 * @property int $id
 * @property string $icno
 * @property string $nama
 * @property string $entry_date
 * @property string $ref_icno
 * @property int $parent_id
 */
class TblPeserta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'ln.tbl_peserta';
        return 'hrm.ln_tbl_peserta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'peranan'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['entry_date'], 'safe'],
            [['parent_id'], 'integer'],
            [['icno', 'ref_icno', 'peranan'], 'string', 'max' => 15],
//            [['nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
//            'nama' => 'Nama',
            'entry_date' => 'Entry Date',
            'icno' => 'Icno',
            'ref_icno' => 'Ref Icno',
            'parent_id' => 'Parent ID',
            'peranan' => 'Peranan',
        ];
    }
    
        public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getRole(){
        return $this->hasOne(Refperanan::className(), ['id' => 'peranan']);
    }
    
}
