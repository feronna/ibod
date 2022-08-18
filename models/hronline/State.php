<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.state".
 *
 * @property string $StateCd
 * @property string $State
 * @property string $StateWeekend
 * @property string $CountryCd
 * @property string $StateCdMM
 */
class State extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.state';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['StateCd'], 'required'],
            [['StateCd'], 'string', 'max' => 2],
            [['State'], 'string', 'max' => 255],
            [['StateWeekend'], 'string', 'max' => 1],
            [['CountryCd'], 'string', 'max' => 4],
            [['StateCdMM'], 'string', 'max' => 20],
            [['StateCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'StateCd' => 'State Cd',
            'State' => 'State',
            'StateWeekend' => 'State Weekend',
            'CountryCd' => 'Country Cd',
            'StateCdMM' => 'State Cd Mm',
        ];
    }
}
