<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.r_table".
 *
 * @property string $table
 * @property string $nama
 */
class RTable extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.r_table';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['table'], 'required'],
            [['table', 'nama'], 'string', 'max' => 50],
            [['table'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'table' => 'Table',
            'nama' => 'Nama',
        ];
    }
}
