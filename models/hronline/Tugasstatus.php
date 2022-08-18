<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.tugasstatus".
 *
 * @property int $tugaststatus_id
 * @property string $tugasstatus_desc
 */
class Tugasstatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tugasstatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tugasstatus_desc'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tugasstatus_id' => 'Status ID',
            'tugasstatus_desc' => 'Deskripsi Status Tugas',
        ];
    }
   
}
