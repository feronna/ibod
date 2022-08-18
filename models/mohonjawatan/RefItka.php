<?php

namespace app\models\mohonjawatan;

use Yii;

/**
 * This is the model class for table "mohonjawatan.ref_itka".
 *
 * @property int $id
 * @property int $gred
 * @property int $jumlah
 */
class RefItka extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.mj_ref_itka';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gred', 'jumlah'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gred' => 'Gred',
            'jumlah' => 'Jumlah',
        ];
    }
}
