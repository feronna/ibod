<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.permissions".
 *
 * @property int $perm_id
 * @property string $perm_desc
 */
class Tblpermission extends \yii\db\ActiveRecord
{
    public $controller_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perm_desc'], 'required','message'=>'Ruang ini adalah mandatori.'],
            [['perm_desc'], 'string', 'max' => 50],
            [['perm_desc'],'unique','message'=>'Nama permission sudah wujud.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'perm_id' => 'Perm ID',
            'perm_desc' => 'Perm Desc',
        ];
    }
}
