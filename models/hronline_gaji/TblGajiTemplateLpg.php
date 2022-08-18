<?php

namespace app\models\hronline_gaji;

use Yii;

/**
 * This is the model class for table "hrm.gaji_template_lpg_kew8".
 *
 * @property int $id
 * @property int $jenis_lpg_id ref id:lpgCd
 * @property int $elaun_id ref id:elaunname
 * @property string $create_by ref ICNO
 * @property string $create_dt
 * @property string $update_by ref ICNO
 * @property string $update_dt
 * @property int $status 1 : active || 0 : inactive
 */
class TblGajiTemplateLpg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_template_lpg_kew8';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['elaun_id'], 'required'],
            [['jenis_lpg_id', 'elaun_id', 'status'], 'integer'],
            [['create_dt', 'update_dt'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 15],
            ['elaun_id', 'unique', 'targetAttribute' => ['elaun_id', 'jenis_lpg_id'], 'message' => 'Entry already exists'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_lpg_id' => 'Jenis Lpg ID',
            'elaun_id' => 'Elaun ID',
            'create_by' => 'Create By',
            'create_dt' => 'Create Dt',
            'update_by' => 'Update By',
            'update_dt' => 'Update Dt',
            'status' => 'Status',
        ];
    }

    public function getLpgType()
    {
        return $this->hasOne(\app\models\gaji\RefRocReason::className(), ['RR_REASON_CODE' => 'jenis_lpg_id']);
    }

    public function getLpgElaun()
    {
        return $this->hasOne(\app\models\gaji\RefElaunName::className(), ['id' => 'elaun_id']);
    }

    public function getCreator()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'create_by']);
    }

    public function getEditor()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'update_by']);
    }

    public function getElaunList($lpg_id){
        return self::find()->select(['elaun_id'])->where(['jenis_lpg_id'=>$lpg_id])->asArray()->all();
    }
}
