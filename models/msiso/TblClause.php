<?php

namespace app\models\msiso;

use Yii;

/**
 * This is the model class for table "utilities.iso_tbl_clause".
 *
 * @property int $id
 * @property string $clause
 * @property string $clause_order
 * @property string $clause_name
 * @property string $clause_details
 * @property string $created_by
 * @property string $created_dt
 * @property int $status
 * @property int $parent_clause
 */
class TblClause extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.iso_tbl_clause';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clause_details'], 'string'],
            [['created_dt'], 'safe'],
            [['status', 'parent_id'], 'integer'],
            [['clause', 'clause_order', 'parent_clause'], 'string', 'max' => 15],
            [['clause_title'], 'string', 'max' => 250],
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
            'clause' => 'Clause',
            'clause_order' => 'Clause Order',
            'clause_title' => 'Clause Title',
            'clause_details' => 'Clause Details',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'status' => 'Status',
            'parent_clause' => 'Parent Clause',
            'parent_id' => 'Parent ID',
        ];
    }
    public function getClauseName(){
        return $this->clause_order .' - '.$this->clause_title;
    }

}
