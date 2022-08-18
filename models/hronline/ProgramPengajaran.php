<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.programpengajaran".
 *
 * @property int $id
 * @property string $KodProgram
 * @property string $NamaProgram
 * @property string $NamaProgram_bi
 * @property int $DeptId
 * @property int $campus_id
 * @property string $jabatan_fpsk
 * @property int $fieldmm
 */
class ProgramPengajaran extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.programpengajaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DeptId', 'campus_id', 'fieldmm'], 'integer'],
            [['KodProgram'], 'string', 'max' => 6],
            [['NamaProgram', 'NamaProgram_bi', 'jabatan_fpsk'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'KodProgram' => 'Kod Program',
            'NamaProgram' => 'Nama Program',
            'NamaProgram_bi' => 'Nama Program Bi',
            'DeptId' => 'Dept ID',
            'campus_id' => 'Campus ID',
            'jabatan_fpsk' => 'Jabatan Fpsk',
            'fieldmm' => 'Fieldmm',
        ];
    }
}
