<?php

namespace app\models\msiso;
use app\models\hronline\Tblprcobiodata;
use app\models\msiso\msiso;

use Yii;

/**
 * This is the model class for table "utilities.iso_ref_auditor_dept".
 *
 * @property int $id
 * @property string $icno
 * @property string $dept
 * @property string $year
 * @property string $updated_by
 * @property string $updated_dt
 * @property string $catatan
 * @property int $isActive
 */
class RefAuditorDept extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.iso_ref_auditor_dept';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'dept'], 'required', 'message' => 'Ruang ini adalah mandatori'],  
            [['updated_dt'], 'safe'],
            [['catatan'], 'string'],
            [['isActive', 'deptId'], 'integer'],
            [['icno', 'year', 'updated_by'], 'string', 'max' => 12],
            [['dept'], 'string', 'max' => 150],
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
            'dept' => 'Dept',
            'year' => 'Year',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Dt',
            'catatan' => 'Catatan',
            'isActive' => 'Is Active',
            'deptId' => 'Department Id',
        ];
    }

    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getAuditor() {
        return $this->hasOne(Msiso::className(), ['icno' => 'icno']);
    }
    public function getNotify() {
        return $this->hasOne(NotifyAudit::className(), ['dept' => 'dept']);
    }
}
