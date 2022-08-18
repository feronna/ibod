<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.occupationsector".
 *
 * @property string $OccSectorCd
 * @property string $OccSector
 */
class SektorPekerjaan extends \yii\db\ActiveRecord
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
        return 'hronline.occupationsector';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OccSectorCd'], 'required'],
            [['OccSectorCd'], 'string', 'max' => 2],
            [['OccSector'], 'string', 'max' => 255],
            [['OccSectorCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OccSectorCd' => 'Occ Sector Cd',
            'OccSector' => 'Occ Sector',
        ];
    }
}
