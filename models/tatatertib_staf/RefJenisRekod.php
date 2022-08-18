<?php

namespace app\models\tatatertib_staf;

use Yii;

/**
 * This is the model class for table "tatatertib_staf.ref_jenis_rekod".
 *
 * @property int $id
 * @property string $description
 */
class RefJenisRekod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tertib_ref_jenis_rekod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
        ];
    }
}
