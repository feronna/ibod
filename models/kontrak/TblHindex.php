<?php

namespace app\models\kontrak;

use Yii;

/**
 * This is the model class for table "kontrak.tbl_hindex".
 *
 * @property int $id
 * @property string $icno
 * @property int $scopus_hindex
 * @property string $scopus_citation
 * @property int $googlescholar_hindex
 * @property string $googlescholar_citation
 */
class TblHindex extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_tbl_hindex';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['scopus_hindex', 'googlescholar_hindex', 'scopus_citation', 'googlescholar_citation'], 'integer'],
            [['icno'], 'string', 'max' => 14],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'scopus_hindex' => 'Scopus Hindex',
            'scopus_citation' => 'Scopus Citation',
            'googlescholar_hindex' => 'Googlescholar Hindex',
            'googlescholar_citation' => 'Googlescholar Citation',
        ];
    }
}
