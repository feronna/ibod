<?php

namespace app\models\ln;

use Yii;

/**
 * This is the model class for table "hrm.ln_tbl_surat".
 *
 * @property int $id
 * @property int $ln_id //id dari tbl_ln
 * @property string $tajuk
 * @property string $dokumen
 */
class TblSurat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    public $file ;
            
    public static function tableName()
    {
        return 'hrm.ln_tbl_surat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ln_id'], 'integer'],
            [['tajuk', 'dokumen'], 'string', 'max' => 500],
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
            'id' => 'ID',
            'ln_id' => 'Ln ID',
            'tajuk' => 'Tajuk',
            'dokumen' => 'Dokumen',
        ];
    }
}
