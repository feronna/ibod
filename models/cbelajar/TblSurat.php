<?php

namespace app\models\cbelajar;

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
        return 'hrd.cb_tbl_surat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'integer'],
            [['tajuk', 'dokumen'], 'string', 'max' => 500],
            [['file'],'safe'],
//            [['file'], 'file','extensions'=>'pdf'],
            [['file'], 'file','extensions'=>['pdf'], 'maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id' => 'Permohonanan ID',
            'tajuk' => 'Tajuk',
            'dokumen' => 'Dokumen',
        ];
    }
}
