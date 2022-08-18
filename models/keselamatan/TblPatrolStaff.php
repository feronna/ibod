<?php

namespace app\models\keselamatan;

use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "keselamatan.tbl_patrol_staff".
 *
 * @property int $id
 * @property string $icno
 * @property int $patrol_pos_id
 * @property int $unit_id bravo,alpha,scc
 * @property string $ketua_pos
 * @property string $penolong_ketua_pos
 * @property string $month
 * @property string $year
 * @property string $added_by
 * @property string $created_at
 * @property int $isActive
 * @property int $campus_id
 */
class TblPatrolStaff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_patrol_staff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['patrol_pos_id', 'unit_id', 'isActive', 'campus_id'], 'integer'],
            [['year', 'created_at'], 'safe'],
            [['created_at'], 'required'],
            [['icno'], 'string', 'max' => 20],
            [['ketua_pos', 'penolong_ketua_pos', 'added_by'], 'string', 'max' => 12],
            [['month'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'patrol_pos_id' => 'Patrol Pos ID',
            'unit_id' => 'Unit ID',
            'ketua_pos' => 'Ketua Pos',
            'penolong_ketua_pos' => 'Penolong Ketua Pos',
            'month' => 'Month',
            'year' => 'Year',
            'added_by' => 'Added By',
            'created_at' => 'Created At',
            'isActive' => 'Is Active',
            'campus_id' => 'Campus ID',
        ];
    }
    
    public function getStaff() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
