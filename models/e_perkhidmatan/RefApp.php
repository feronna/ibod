<?php

namespace app\models\e_perkhidmatan;

use Yii;

/**
 * This is the model class for table "{{%utilities.evc_ref_application_type}}".
 *
 * @property int $id
 * @property string $type
 * @property int $active_status
 */
class RefApp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%keselamatan.utils_ref_application_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active_status'], 'integer'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'active_status' => 'Active Status',
        ];
    }

    public function getPtype()
    {

        $a = " - ";

        if ($this->id == '1') {
            $a = '<span class="label label-primary">' . $this->type . '</span>';
        } elseif ($this->id == '2') {
            $a = '<span class="label label-success">' . $this->type . '</span>';
        } elseif ($this->id == '3') {
            $a = '<span class="label label-danger">' . $this->type . '</span>';
        } elseif ($this->id == '4') {
            $a = '<span class="label label-default">' . $this->type . '</span>';
        } elseif ($this->id == '5') {
            $a = '<span class="label label-warning">' . $this->type . '</span>';
        }

        return $a;
    }
}
