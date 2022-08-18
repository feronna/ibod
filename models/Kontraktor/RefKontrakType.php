<?php

namespace app\models\Kontraktor;

use Yii;

/**
 * This is the model class for table "keselamatan.utils_ref_kontrak_type".
 *
 * @property int $id
 * @property string $jenis_desc
 */
class RefKontrakType extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db');
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.utils_ref_kontrak_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'],'safe'],
            [['jenis_desc'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_desc' => 'Jenis Desc',
        ];
    }
}
