<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.t_emou06_kpi".
 *
 * @property int $kpi_id
 * @property int $id_memorandum
 * @property string $order_no
 * @property string $kpi_desc
 * @property int $quantity_target
 * @property string $quantity_achieve
 */
class TblMemorandumKpi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.t_emou06_kpi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_memorandum', 'order_no', 'kpi_desc', 'quantity_target'], 'required'],
            [['id_memorandum', 'quantity_target'], 'integer'],
            [['order_no'], 'string', 'max' => 3],
            [['kpi_desc'], 'string', 'max' => 255],
            [['quantity_achieve'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kpi_id' => 'Kpi ID',
            'id_memorandum' => 'Id Memorandum',
            'order_no' => 'Order No',
            'kpi_desc' => 'Kpi Desc',
            'quantity_target' => 'Quantity Target',
            'quantity_achieve' => 'Quantity Achieve',
        ];
    }
}
