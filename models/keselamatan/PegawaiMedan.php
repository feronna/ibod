<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.pegawai_medan".
 *
 * @property int $id
 * @property string $icno
 * @property int $week
 * @property int $active
 */
class PegawaiMedan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.pegawai_medan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['week', 'active'], 'integer'],
            [['icno'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'week' => 'Week',
            'active' => 'Active',
        ];
    }
}
