<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.tbl_queries".
 *
 * @property int $id
 * @property string $query
 * @property string $module
 * @property string $created_by
 * @property string $created_dt
 */
class TblQueries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.tbl_queries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['query'], 'string'],
            [['created_dt'], 'safe'],
            [['module'], 'string', 'max' => 50],
            [['created_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'query' => 'Query',
            'module' => 'Module',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
        ];
    }
}
