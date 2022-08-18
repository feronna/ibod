<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_ref_peratus_kategori".
 *
 * @property int $id
 * @property double $peratus_min
 * @property string $kategori
 */
class RefPeratusKategori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_ref_peratus_kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['peratus_min'], 'number'],
            [['kategori'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peratus_min' => 'Peratus Min',
            'kategori' => 'Kategori',
        ];
    }
}
