<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.tbl_shortcut".
 *
 * @property int $id
 * @property string $role
 * @property string $access
 * @property string $url
 * @property string $name
 */
class TblShortcut extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.tbl_shortcut';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role'], 'string', 'max' => 10],
            [['url', 'name'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'access' => 'Access',
            'url' => 'Url',
            'name' => 'Name',
        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'access']);
    }
}
