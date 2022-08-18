
        if (!empty($model)) {
            $bio = Tblprcobiodata::findOne(['ICNO' => $id]);
            // var_dump($bio);
            // die;
            return $this->render('utama', [
                'model' => $model,
                'bio' => $bio,
            ]);
        }
        throw new NotFoundHttpException('ICNO not Exist!');
    }

    switch ($tbl_lbs = Tbllantikanbelumselesai::findOne(['Staff_Id' => $ID])->profil_gaji) {
                case '0':
                    $staff_salary = new TblStaffSalary();
                    break;

                default:
                    $staff_salary = TblStaffSalary::findOne(['id' => $tbl_lbs]);
                    break;
            }
            //$staff_salary->jenisKwsp->ET_DESC;

            return $this->render('profilegaji', [
                'ICNO' => $biodata->ICNO,
                'staff_salary' => $staff_salary,
                'ID' => $ID,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }