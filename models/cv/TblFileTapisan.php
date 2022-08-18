<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_tbl_file_tapisan".
 *
 * @property int $id
 * @property int $jawatan_id
 * @property string $added_by
 * @property string $added_at
 * @property string $file
 */
class TblFileTapisan extends \yii\db\ActiveRecord {

    public $file1,$file2,$file3,$file4,$file5,$file6,$file7,$file8,$file9,$file10;
    public $id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10;
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.cv_tbl_file_tapisan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['file1', 'file2', 'file3', 'file4', 'file5', 'file6', 'file7', 'file8', 'file9', 'file10'], 'file', 'extensions' => 'xlsx,csv,docx,pdf', 'maxSize' => 1024 * 1024 * 5],
            [['id1', 'id2', 'id3', 'id4', 'id5', 'id6', 'id7', 'id8', 'id9', 'id10',], 'safe'],
            [['jawatan_id'], 'integer'],
            [['added_at'], 'safe'],
            [['file'], 'string'],
            [['added_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'jawatan_id' => 'Jawatan ID',
            'added_by' => 'Added By',
            'added_at' => 'Added At',
            'file' => 'File',
        ];
    }
    
    public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'jawatan_id']);
    }

}
