<?php

namespace app\models\mohonjawatan;

use Yii;

/**
 * This is the model class for table "mohonjawatan.ref_biw".
 *
 * @property int $id
 * @property string $lingkungan_gaji
 * @property double $kadar
 */
class RefBiw extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.mj_ref_biw';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kadar','min_lingkungan','max_lingkungan'], 'number'],
            [['lingkungan_gaji'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lingkungan_gaji' => 'Lingkungan Gaji',
            'kadar' => 'Kadar',
        ];
    }
}
