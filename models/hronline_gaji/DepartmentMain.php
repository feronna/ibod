<?php

namespace app\models\hronline_gaji;

use Yii;

/**
 * This is the model class for table "hronline_gaji.department_main".
 *
 * @property string $dm_dept_code
 * @property string $dm_address1
 * @property string $dm_address2
 * @property string $dm_address3
 * @property string $dm_branch_code
 * @property string $dm_category
 * @property string $dm_city
 * @property string $dm_cmpy_code
 * @property string $dm_costctr_charge
 * @property string $dm_country_code
 * @property string $dm_dept_desc
 * @property string $dm_dept_desc_alt
 * @property string $dm_dept_desc_short
 * @property string $dm_director
 * @property string $dm_div
 * @property string $dm_end_date
 * @property string $dm_enter_by
 * @property string $dm_enter_date
 * @property string $dm_faculty_type
 * @property string $dm_hod_title
 * @property string $dm_level
 * @property string $dm_parent_dept_code
 * @property int $dm_dept_group
 * @property string $dm_postcode
 * @property string $dm_rank
 * @property string $dm_record_owner
 * @property string $dm_ref_no
 * @property string $dm_start_date
 * @property string $dm_state_code
 * @property string $dm_status
 * @property string $dm_type
 * @property string $dm_update_by
 * @property string $dm_update_date
 * @property string $dm_autonomy
 * @property string $dm_transfer_manage_by
 * @property string $dm_email_addr
 * @property string $dm_phone_no
 * @property string $dm_fax_no
 * @property string $dm_old_code
 */
class DepartmentMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_department_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dm_dept_code', 'dm_cmpy_code'], 'required'],
            [['dm_enter_date', 'dm_update_date'], 'safe'],
            [['dm_level'], 'number'],
            [['dm_dept_group'], 'integer'],
            [['dm_dept_code', 'dm_branch_code', 'dm_cmpy_code', 'dm_costctr_charge', 'dm_country_code', 'dm_div', 'dm_end_date', 'dm_parent_dept_code', 'dm_rank', 'dm_record_owner', 'dm_start_date', 'dm_state_code', 'dm_transfer_manage_by', 'dm_old_code'], 'string', 'max' => 10],
            [['dm_address1', 'dm_address2', 'dm_address3', 'dm_dept_desc', 'dm_dept_desc_alt', 'dm_ref_no'], 'string', 'max' => 255],
            [['dm_category', 'dm_faculty_type', 'dm_type'], 'string', 'max' => 60],
            [['dm_city', 'dm_hod_title'], 'string', 'max' => 100],
            [['dm_dept_desc_short', 'dm_phone_no', 'dm_fax_no'], 'string', 'max' => 50],
            [['dm_director', 'dm_enter_by', 'dm_update_by'], 'string', 'max' => 30],
            [['dm_postcode', 'dm_status'], 'string', 'max' => 20],
            [['dm_autonomy'], 'string', 'max' => 1],
            [['dm_email_addr'], 'string', 'max' => 150],
            [['dm_dept_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dm_dept_code' => 'Dm Dept Code',
            'dm_address1' => 'Dm Address1',
            'dm_address2' => 'Dm Address2',
            'dm_address3' => 'Dm Address3',
            'dm_branch_code' => 'Dm Branch Code',
            'dm_category' => 'Dm Category',
            'dm_city' => 'Dm City',
            'dm_cmpy_code' => 'Dm Cmpy Code',
            'dm_costctr_charge' => 'Dm Costctr Charge',
            'dm_country_code' => 'Dm Country Code',
            'dm_dept_desc' => 'Dm Dept Desc',
            'dm_dept_desc_alt' => 'Dm Dept Desc Alt',
            'dm_dept_desc_short' => 'Dm Dept Desc Short',
            'dm_director' => 'Dm Director',
            'dm_div' => 'Dm Div',
            'dm_end_date' => 'Dm End Date',
            'dm_enter_by' => 'Dm Enter By',
            'dm_enter_date' => 'Dm Enter Date',
            'dm_faculty_type' => 'Dm Faculty Type',
            'dm_hod_title' => 'Dm Hod Title',
            'dm_level' => 'Dm Level',
            'dm_parent_dept_code' => 'Dm Parent Dept Code',
            'dm_dept_group' => 'Dm Dept Group',
            'dm_postcode' => 'Dm Postcode',
            'dm_rank' => 'Dm Rank',
            'dm_record_owner' => 'Dm Record Owner',
            'dm_ref_no' => 'Dm Ref No',
            'dm_start_date' => 'Dm Start Date',
            'dm_state_code' => 'Dm State Code',
            'dm_status' => 'Dm Status',
            'dm_type' => 'Dm Type',
            'dm_update_by' => 'Dm Update By',
            'dm_update_date' => 'Dm Update Date',
            'dm_autonomy' => 'Dm Autonomy',
            'dm_transfer_manage_by' => 'Dm Transfer Manage By',
            'dm_email_addr' => 'Dm Email Addr',
            'dm_phone_no' => 'Dm Phone No',
            'dm_fax_no' => 'Dm Fax No',
            'dm_old_code' => 'Dm Old Code',
        ];
    }
}
