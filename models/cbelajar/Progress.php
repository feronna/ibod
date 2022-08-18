<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_lkk_progress".
 *
 * @property int $id
 * @property int $description
 * @property int $semester
 * @property string $icno
 * @property string $comment
 * @property int $progressID
 */
class Progress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_lkk_progress';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'description', 'semester', 'progressID'], 'integer'],
            [['comment'], 'string'],
            [['icno'], 'string', 'max' => 12],
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
            'semester' => 'Semester',
            'icno' => 'Icno',
            'comment' => 'Comment',
            'progressID' => 'Progress ID',
        ];
    }
}
