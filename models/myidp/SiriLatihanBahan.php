<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "myidp.siriLatihanBahan".
 *
 * @property int $siriLatihanID
 * @property string $filename
 */
class SiriLatihanBahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_siriLatihanBahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siriLatihanID', 'filename'], 'required'],
            [['siriLatihanID'], 'integer'],
            [['filename'], 'string', 'max' => 100],
            [['siriLatihanID', 'filename'], 'unique', 'targetAttribute' => ['siriLatihanID', 'filename']],
            [['file'], 'file','extensions'=>'pdf', 'maxFiles' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'siriLatihanID' => 'Siri Latihan ID',
            'filename' => 'Filename',
        ];
    }
}
