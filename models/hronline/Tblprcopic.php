<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.tblprcopic_v2".
 *
 * @property string $icno
 * @property int $status
 */
class Tblprcopic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tblprcopic_v2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['icno'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
            'status' => 'Status',
        ];
    }

    
}
