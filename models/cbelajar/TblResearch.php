<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_research".
 *
 * @property int $id
 * @property int $idLKK
 * @property int $researchID
 * @property string $desc
 */
class TblResearch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_research';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idLKK', 'researchID'], 'integer'],
            [['desc', 'p_komen'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idLKK' => 'Id Lkk',
            'researchID' => 'Research ID',
            'desc' => 'Desc',
            'p_komen'=> 'Komen Penyelia',
        ];
    }
     public function getR() {
        return $this->hasOne(RefResearch::className(), ['id'=>'researchID']);
    }
}
