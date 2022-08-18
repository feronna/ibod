<?php

namespace app\models\kontrak;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "kontrak.tbl_akses".
 *
 * @property int $id
 * @property string $icno
 * @property int $job_category
 * @property string $role
 * @property string $end_date
 */
class TblAkses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_tbl_akses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_category'], 'integer'],
            [['end_date'], 'safe'],
            [['icno'], 'string', 'max' => 14],
            [['role'], 'string', 'max' => 100],
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
            'job_category' => 'Job Category',
            'role' => 'Role',
            'end_date' => 'End Date',
        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
