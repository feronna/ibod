<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "{{%myidp.tbl_adminjfpiu}}".
 *
 * @property string $staffID
 * @property string $date_added
 * @property string $added_by
 * @property int $staff_dept_on_added
 */
class AdminJfpiu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_tbl_adminjfpiu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staffID'], 'required'],
            [['date_added'], 'safe'],
            [['staff_dept_on_added', 'level'], 'integer'],
            [['staffID', 'added_by'], 'string', 'max' => 12],
            [['staffID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'staffID' => 'Staff ID',
            'date_added' => 'Date Added',
            'added_by' => 'Added By',
            'staff_dept_on_added' => 'Staff Dept On Added',
            'level' => 'Tahap Akses',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staffID'] );
    }
}
