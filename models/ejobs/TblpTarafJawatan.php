<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_taraf_jawatan".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $taraf_jawatan_id
 */
class TblpTarafJawatan extends \yii\db\ActiveRecord
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
        return 'ejobs.tbl_taraf_jawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'taraf_jawatan_id'], 'required'],
            [['taraf_jawatan_id'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'taraf_jawatan_id' => 'Taraf Jawatan ID',
        ];
    }
}
