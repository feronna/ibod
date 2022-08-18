<?php

namespace app\models\hronline;

use Yii;

class TblPapAkses extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    public static function tableName()
    {
        return 'hronline.tbl_pap_akses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pap_ja_id', 'status'], 'integer'],
            [['icno'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pap_ja_id' => 'Jenis Akses ID',
            'status' => 'Status',
            'icno' => 'No. KP',
        ];
    }
}
