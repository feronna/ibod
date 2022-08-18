<?php

namespace app\models\aduan;

use Yii;

/**
 * This is the model class for table "keselamatan.rpt_ref_status_aduan".
 *
 * @property int $id
 * @property string $details
 */
class RptRefStatusAduan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.rpt_ref_status_aduan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['details'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'details' => Yii::t('app', 'Status Aduan'),
        ];
    }

    public function getStatusAdu()
    {

        $a = " - ";

        if ($this->id == '1') {
            $a = '<span class="label label-primary">' . $this->details . '</span>';
        } elseif ($this->id == '2') {
            $a = '<span class="label label-success">' . $this->details . '</span>';
        } elseif ($this->id == '3') {
            $a = '<span class="label label-info">' . $this->details . '</span>';
        } elseif ($this->id == '4') {
            $a = '<span class="label label-danger">' . $this->details . '</span>';
        } elseif ($this->id == '5') {
            $a = '<span class="label label-warning">' . $this->details . '</span>';
        } elseif ($this->id == '6') {
            $a = '<span class="label label-success">' . $this->details . '</span>';
        } elseif ($this->id == '11') {
            $a = '<span class="label label-danger">' . $this->details . '</span>';
        }

        return $a;
    }
}
