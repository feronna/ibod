<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.ref_rollcall".
 *
 * @property int $id
 * @property string $jenis
 * @property string $panduan
 */
class RefRollcall extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.ref_rollcall';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis'], 'string', 'max' => 10],
            [['panduan'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis' => 'Jenis',
            'panduan' => 'Panduan',
        ];
    }
}
