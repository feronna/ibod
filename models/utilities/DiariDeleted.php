<?php

namespace app\models\utilities;

use Yii;

/**
 * This is the model class for table "utilities.diari_deleted".
 *
 * @property int $id
 * @property string $staf_icno
 * @property string $icno
 * @property string $title
 * @property string $detail
 * @property int $status
 * @property string $create_dt
 * @property string $update_dt
 * @property string $delete_dt
 */
class DiariDeleted extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.diari_deleted';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detail'], 'string'],
            [['status'], 'integer'],
            [['create_dt', 'update_dt', 'delete_dt'], 'safe'],
            [['staf_icno', 'icno'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staf_icno' => 'Staf Icno',
            'icno' => 'Icno',
            'title' => 'Title',
            'detail' => 'Detail',
            'status' => 'Status',
            'create_dt' => 'Create Dt',
            'update_dt' => 'Update Dt',
            'delete_dt' => 'Delete Dt',
        ];
    }
}
