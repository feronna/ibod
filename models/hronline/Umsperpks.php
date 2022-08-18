<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.umsperpks".
 *
 * @property int $Id
 * @property string $ICNO
 * @property int $JobId
 * @property int $DeptId
 * @property int $campus_id
 * @property string $COOldID
 * @property string $StartDate
 * @property string $COOldIDDt
 * @property string $COOldIDNo
 */
class Umsperpks extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    public static function tableName()
    {
        return 'hronline.umsperpks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['JobId', 'DeptId', 'campus_id'], 'integer'],
            [['StartDate'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['COOldID'], 'string', 'max' => 15],
            [['COOldIDDt'], 'string', 'max' => 6],
            [['COOldIDNo'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'ICNO' => 'Icno',
            'JobId' => 'Job ID',
            'DeptId' => 'Dept ID',
            'campus_id' => 'Campus ID',
            'COOldID' => 'Co Old ID',
            'StartDate' => 'Start Date',
            'COOldIDDt' => 'Co Old Id Dt',
            'COOldIDNo' => 'Co Old Id No',
        ];
    }
}
