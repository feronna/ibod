<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_tbl_query_apc".
 *
 * @property int $id
 * @property string $apc_query
 * @property string $query_dt
 */
class TblQueryApc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_tbl_query_apc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apc_query'], 'string'],
            [['query_dt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'apc_query' => 'Apc Query',
            'query_dt' => 'Query Dt',
        ];
    }
}
