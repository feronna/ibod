<?php

namespace app\models\pengesahan;

use Yii;

/**
 * This is the model class for table "pengesahan.tbl_surat".
 *
 * @property int $id
 * @property int $pengesahan_id id dari tbl_pengesahan
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
//        return 'pengesahan.tbl_surat';
        return 'hrm.sah_tbl_surat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pengesahan_id'], 'integer'],
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
            'pengesahan_id' => 'Pengesahan ID',
            'tajuk' => 'Tajuk',
            'dokumen' => 'Dokumen',
        ];
    }
}
