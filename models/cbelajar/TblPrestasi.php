<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_prestasi".
 *
 * @property int $id
 * @property string $catatan
 * @property string $idlanjutan
 */
class TblPrestasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_prestasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catatan'], 'string'],
            [['idlanjutan'], 'string', 'max' => 12],
            [['komen'], 'string', 'max' => 255],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catatan' => 'Catatan',
            'idlanjutan' => 'Idlanjutan',
            'komen'=>'KOmen',
        ];
    }
}
