<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_penumpang".
 *
 * @property int $id
 * @property string $jp_icno
 * @property string $jp_nama
 */
class TblPenumpang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_penumpang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jp_icno'], 'string', 'max' => 12],
            [['jp_nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jp_icno' => 'Jp Icno',
            'jp_nama' => 'Jp Nama',
        ];
    }
}
