<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_cawangan".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $cawangan_id
 */
class TblpCawangan extends \yii\db\ActiveRecord
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
        return 'ejobs.tbl_cawangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'cawangan_id'], 'required'],
            [['cawangan_id'], 'integer'],
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
            'cawangan_id' => 'Cawangan',
        ];
    }
}
