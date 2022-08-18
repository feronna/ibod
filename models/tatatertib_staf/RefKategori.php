<?php

namespace app\models\tatatertib_staf;

use Yii;

/**
 * This is the model class for table "tatatertib_staf.ref_kategori".
 *
 * @property int $id
 * @property string $kategori_nm
 */
class RefKategori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tertib_ref_kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori_nm'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kategori_nm' => 'Kategori Nm',
        ];
    }
}
