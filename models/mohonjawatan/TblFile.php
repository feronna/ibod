<?php

namespace app\models\mohonjawatan;
use yii\helpers\Html;

use Yii;

/**
 * This is the model class for table "mohonjawatan.tbl_file".
 *
 * @property int $id
 * @property string $namafile
 * @property int $permohonan_id reference to main table
 * @property string $upload_date
 * @property int $uploaded_by
 */
class TblFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.mj_tbl_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permohonan_id'], 'integer'],
            [['upload_date'], 'safe'],
            [['namafile'], 'file','skipOnEmpty'=>true],
            [['uploaded_by','status'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namafile' => 'Namafile',
            'permohonan_id' => 'Permohonan ID',
            'upload_date' => 'Upload Date',
            'uploaded_by' => 'Uploaded By',
            'status'=> 'status'
        ];
    }
    public function getDisplayLink() {
        if(!empty($this->namafile && $this->namafile != 'deleted')){
        return html::a(Yii::$app->FileManager->NameFile($this->namafile), Yii::$app->FileManager->DisplayFile($this->namafile));
        }
        return 'File not exist!';
    }
    
    
}
