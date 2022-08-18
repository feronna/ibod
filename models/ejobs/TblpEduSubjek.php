<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_edusubjek".
 *
 * @property int $id
 * @property int $bm_id
 * @property int $gred_id
 * @property int $subjek_id
 */
class TblpEdusubjek extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_edusubjek';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'gred_id', 'subjek_id'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['bm_id', 'gred_id', 'subjek_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bm_id' => 'BM',
            'gred_id' => 'Gred',
            'subjek_id' => 'Subjek',
        ];
    }
}
