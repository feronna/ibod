<?php

namespace app\models\kemudahan;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "utilities.fac_ref_temp_access".
 *
 * @property int $id
 * @property string $icno
 * @property int $isActive
 * @property int $facility
 */
class RefTempAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_temp_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'isActive', 'facility'], 'integer'],
            [['icno'], 'string', 'max' => 12],
            [['id'], 'unique'],
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
            'isActive' => 'Is Active',
            'facility' => 'Facility',
        ];
    }
     public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
