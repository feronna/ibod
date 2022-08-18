<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.ref_kenderaan_bkums".
 *
 * @property int $id
 * @property string $nom_plate
 * @property string $model_kenderaan
 * @property int $jenis_kenderaan
 */
class RefKenderaanBkums extends \yii\db\ActiveRecord
{

    
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.ref_kenderaan_bkums';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_kenderaan','isActive'], 'integer'],
            [['num_plate'], 'string', 'max' => 10],
            [['model_kenderaan'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num_plate' => 'Num Plate',
            'model_kenderaan' => 'Model Kenderaan',
            'jenis_kenderaan' => 'Jenis Kenderaan',
        ];
    }
}
