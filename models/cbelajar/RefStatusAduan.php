<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_ref_status_aduan".
 *
 * @property int $id
 * @property string $output
 * @property string $color
 * @property string $desc
 */
class RefStatusAduan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_status_aduan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desc'], 'string'],
            [['output'], 'string', 'max' => 50],
            [['color'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'output' => 'Output',
            'color' => 'Color',
            'desc' => 'Desc',
        ];
    }
}
