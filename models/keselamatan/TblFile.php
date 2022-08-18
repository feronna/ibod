<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.tbl_file".
 *
 * @property int $id
 * @property string $file
 * @property string $description
 */
class TblFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['file'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' =>  Yii::t('app', 'ID'),
            'file' =>  Yii::t('app', 'File'),
            'description' =>  Yii::t('app', 'Description'),
        ];
    }
}
