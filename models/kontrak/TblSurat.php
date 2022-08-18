<?php

namespace app\models\kontrak;

use Yii;

/**
 * This is the model class for table "kontrak.tbl_surat".
 *
 * @property int $id
 * @property int $kontrak_id id dari tbl_kontrak
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
        return 'hrm.kontrak_tbl_surat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kontrak_id'], 'integer'],
            [['tajuk', 'dokumen'], 'string', 'max' => 500],
            [['file'],'safe'],
            [['file'], 'file','extensions'=>'pdf, png, jpg', 'maxFiles' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kontrak_id' => 'Kontrak ID',
            'tajuk' => 'Tajuk',
            'dokumen' => 'Dokumen',
        ];
    }
}
