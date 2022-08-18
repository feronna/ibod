<?php

namespace app\models\harta;

use Yii;

/**
 * This is the model class for table "harta.ref_jenis_bayaran".
 *
 * @property int $id
 * @property string $fullname
 */
class RefJenisBayaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_ref_jenis_bayaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
        ];
    }
    
}
