<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_tbl_perakuan_panel".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $date
 */
class TblPerakuanPanel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_perakuan_panel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date','access'], 'safe'],
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
            'date' => 'Date',
        ];
    }
}
