<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "dbo.vw_scopus".
 *
 * @property string $staff_name
 * @property string $ic_no
 * @property string $Grade
 * @property string $Number of Documents
 * @property string $h-index
 * @property string $Citations
 */
class RefHindex extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_scopus';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db12');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_name'], 'string', 'max' => 100],
            [['ic_no', 'Grade'], 'string', 'max' => 50],
            [['Number of Documents', 'Citations'], 'string', 'max' => 10],
            [['h_index'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'staff_name' => 'Staff Name',
            'ic_no' => 'Ic No',
            'Grade' => 'Grade',
            'Number of Documents' => 'Number Of Documents',
            'h-index' => 'H Index',
            'Citations' => 'Citations',
        ];
    }
}
