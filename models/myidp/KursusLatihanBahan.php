<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "myidp.kursusLatihanBahan".
 *
 * @property int $kursusLatihanID
 * @property string $filename
 */
class KursusLatihanBahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'myidp.kursusLatihanBahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kursusLatihanID', 'filename'], 'required'],
            [['kursusLatihanID'], 'integer'],
            [['filename'], 'string', 'max' => 100],
            [['kursusLatihanID', 'filename'], 'unique', 'targetAttribute' => ['kursusLatihanID', 'filename']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kursusLatihanID' => 'Kursus Latihan ID',
            'filename' => 'Filename',
        ];
    }
}
