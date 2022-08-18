<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.ref_pos_lmt".
 *
 * @property int $id
 * @property string $pos_kawalan
 * @property string $pecahan_pos
 * @property string $added_by
 * @property string $updated_by
 * @property string $kampus
 * @property int $active
 */
class RefPosLmt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.ref_pos_lmt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active'], 'integer'],
            [['pos_kawalan'], 'string', 'max' => 50],
            [['pecahan_pos'], 'string', 'max' => 250],
            [['added_by', 'updated_by', 'kampus'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pos_kawalan' => 'Pos Kawalan',
            'pecahan_pos' => 'Pecahan Pos',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
            'kampus' => 'Kampus',
            'active' => 'Active',
        ];
    }
    public function getStatus() {
        if ($this->active == '1') {
            return '<span class="label label-success">Aktif</span>';
        }
 else {
                        return '<span class="label label-warning">Tidak Aktif</span>';

        }
    }
}
