<?php

namespace app\models\msiso;

use Yii;

    // table and modal will be drop, tble might not be useful
/**
 * This is the model class for table "utilities.iso_ref_notify_audit".
 *
 * @property int $id
 * @property string $name
 * @property string $icno
 * @property string $audit_role
 * @property int $parent_id
 */
class Refnotifyaudit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.iso_ref_notify_audit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['icno', 'year'], 'string', 'max' => 12],
            [['audit_role', 'dept'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icno' => 'Icno',
            'audit_role' => 'Audil Role',
            'parent_id' => 'Parent ID',
            'year' => 'Year',
            'dept' => 'Dept',
        ];
    }

    public function getMsiso() {
        return $this->hasOne(Msiso::className(), ['icno' => 'icno']);
    }

    public function getDeptAudit() {
        return $this->hasOne(NotifyAudit::className(), ['id' => 'parent_id']);
    }    
}
