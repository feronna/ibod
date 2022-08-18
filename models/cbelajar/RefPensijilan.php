<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_ref_pensijilan".
 *
 * @property int $id
 * @property string $kategori
 */
class RefPensijilan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_pensijilan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kategori' => 'Kategori',
        ];
    }
}
