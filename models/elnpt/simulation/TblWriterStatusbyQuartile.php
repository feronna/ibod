<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "Scopus.vw_Writer_Status_by_Quartile".
 *
 * @property string $ic_no
 * @property string $staff_name
 * @property int $Total Main
 * @property int $Main Q1
 * @property int $Main Q2
 * @property int $Main Q3
 * @property int $Main Q4
 * @property int $Main -
 * @property int $Total Corresponding
 * @property int $Corresponding Q1
 * @property int $Corresponding Q2
 * @property int $Corresponding Q3
 * @property int $Corresponding Q4
 * @property int $Corresponding -
 * @property int $Total Collaborating
 * @property int $Collaborating Q1
 * @property int $Collaborating Q2
 * @property int $Collaborating Q3
 * @property int $Collaborating Q4
 * @property int $Collaborating -
 * @property int $Total Q1
 * @property int $Total Q2
 * @property int $Total Q3
 * @property int $Total Q4
 * @property int $Total -
 * @property int $Grand Total
 */
class TblWriterStatusbyQuartile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Scopus.vw_Writer_Status_by_Quartile';
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
            [['Total Main', 'Main Q1', 'Main Q2', 'Main Q3', 'Main Q4', 'Main -', 'Total Corresponding', 'Corresponding Q1', 'Corresponding Q2', 'Corresponding Q3', 'Corresponding Q4', 'Corresponding -', 'Total Collaborating', 'Collaborating Q1', 'Collaborating Q2', 'Collaborating Q3', 'Collaborating Q4', 'Collaborating -', 'Total Q1', 'Total Q2', 'Total Q3', 'Total Q4', 'Total -', 'Grand Total'], 'integer'],
            [['ic_no'], 'string', 'max' => 50],
            [['staff_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ic_no' => 'Ic No',
            'staff_name' => 'Staff Name',
            'Total Main' => 'Total Main',
            'Main Q1' => 'Main Q 1',
            'Main Q2' => 'Main Q 2',
            'Main Q3' => 'Main Q 3',
            'Main Q4' => 'Main Q 4',
            'Main -' => 'Main',
            'Total Corresponding' => 'Total Corresponding',
            'Corresponding Q1' => 'Corresponding Q 1',
            'Corresponding Q2' => 'Corresponding Q 2',
            'Corresponding Q3' => 'Corresponding Q 3',
            'Corresponding Q4' => 'Corresponding Q 4',
            'Corresponding -' => 'Corresponding',
            'Total Collaborating' => 'Total Collaborating',
            'Collaborating Q1' => 'Collaborating Q 1',
            'Collaborating Q2' => 'Collaborating Q 2',
            'Collaborating Q3' => 'Collaborating Q 3',
            'Collaborating Q4' => 'Collaborating Q 4',
            'Collaborating -' => 'Collaborating',
            'Total Q1' => 'Total Q 1',
            'Total Q2' => 'Total Q 2',
            'Total Q3' => 'Total Q 3',
            'Total Q4' => 'Total Q 4',
            'Total -' => 'Total',
            'Grand Total' => 'Grand Total',
        ];
    }
}
