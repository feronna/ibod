<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "tblprrecognition".
 *
 * @property int $id
 * @property string $staff_id
 * @property string $recogNm
 * @property string $recogTo
 * @property string $conferBody
 * @property string $recogLvl
 * @property string $inventionTitle
 * @property string $event
 * @property string $date
 * @property string $link
 * @property string $remark
 * @property string $recogCat
 */
class Tblrecognition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblprrecognition';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['remark'], 'string'],
            [['staff_id'], 'string', 'max' => 15],
            [['recogNm', 'conferBody', 'inventionTitle', 'event', 'link'], 'string', 'max' => 255],
            [['recogTo', 'recogLvl'], 'string', 'max' => 50],
            [['recogCat'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'recogNm' => 'Recog Nm',
            'recogTo' => 'Recog To',
            'conferBody' => 'Confer Body',
            'recogLvl' => 'Recog Lvl',
            'inventionTitle' => 'Invention Title',
            'event' => 'Event',
            'date' => 'Date',
            'link' => 'Link',
            'remark' => 'Remark',
            'recogCat' => 'Recog Cat',
        ];
    }
}
