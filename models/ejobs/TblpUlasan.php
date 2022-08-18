<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_sbbfail".
 *
 * @property int $id
 * @property int $permohonan_id
 * @property string $desc
 */
class TblpUlasan extends \yii\db\ActiveRecord
{
    public $status;
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_ulasan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status','desc'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['ulasan_at','status_id'], 'safe'],
            [['permohonan_id'], 'integer'],
            [['ulasan_by'], 'string'], 
            [['desc'], 'string', 'max' => 1000], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'permohonan_id' => 'Permohonan ID',
            'desc' => 'Ulasan : ',
            'status' => 'Status Persetujuan : ',
        ];
    }
}
