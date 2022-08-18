<?php

namespace app\models\utilities\epos;

use Yii;

/**
 * This is the model class for table "utilities.pos_ref_jenis_khidmat_mel".
 *
 * @property int $id
 * @property string $jenis
 */
class JenisKhidmatMel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.pos_ref_jenis_khidmat_mel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis'], 'string', 'max' => 20],
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
        ];
    }
}
