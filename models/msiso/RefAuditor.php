<?php

namespace app\models\msiso;

use Yii;

/**
 * This is the model class for table "utilities.iso_ref_auditor".
 *
 * @property int $id
 * @property string $audit_role
 * @property int $isActive
 */
class RefAuditor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.iso_ref_auditor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isActive'], 'integer'],
            [['audit_role'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'audit_role' => 'Audit Role',
            'isActive' => 'Is Active',
        ];
    }
}
