<?php

namespace app\models\w_letter;

use Yii;

/**
 * This is the model class for table "hrm.wl_ref_kategori_jabatan".
 *
 * @property int $id
 * @property string $name
 * @property string $kategori
 * @property int $DeptId
 */
class RefKategoriJabatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.wl_ref_kategori_jabatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DeptId'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['kategori'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'kategori' => 'Kategori',
            'DeptId' => 'Dept ID',
        ];
    }
}
