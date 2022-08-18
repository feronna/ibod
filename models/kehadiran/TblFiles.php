<?php

namespace app\models\kehadiran;

use Yii;

/**
 * This is the model class for table "tbl_files".
 *
 * @property int $id
 * @property string $file_name
 * @property string $file_type
 * @property string $file_size
 * @property string $file_content
 * @property string $create_dt
 */
class TblFiles extends \yii\db\ActiveRecord
{
    
     // add the function below:
    public static function getDb() {
        return Yii::$app->get('db8'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrv4.tbl_files';
    }
    
    public $uploadedFile;
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uploadedFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf ,png, jpg'],
//            [['file_content'], 'string'],
//            [['create_dt'], 'safe'],
//            [['file_name'], 'string', 'max' => 150],
//            [['file_type', 'file_size'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'file_type' => 'File Type',
            'file_size' => 'File Size',
            'file_content' => 'File Content',
            'create_dt' => 'Create Dt',
        ];
    }
}
