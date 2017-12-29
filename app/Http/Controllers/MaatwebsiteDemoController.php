<?php

namespace App\Http\Controllers;

use App\LocationPreferences;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\TeacherQualification;
use App\SubjectPreferences;
use App\TuitionCategories;
use App\InstitutePreferences;
use Illuminate\Support\Facades\Hash;

class MaatwebsiteDemoController extends Controller
{
    public function importExcel()
    {
        if(Input::hasFile('import_file')){
            $path = Input::file('import_file')->getRealPath();
            $teachers = Excel::selectSheets('Tutors')->load($path,function ($reader){})->get();
            $qualifications = Excel::selectSheets('Qualification')->load($path,function ($reader){})->get();
            $subjects = Excel::selectSheets('Subject_Preferences')->load($path,function ($reader){})->get();
            $grades = Excel::selectSheets('Grade_Subjects')->load($path,function ($reader){})->get();
            $institutes = Excel::selectSheets('Institute_Preferrence')->load($path,function ($reader){})->get();
            $locations = Excel::selectSheets('Location_Preferences')->load($path,function ($reader){})->get();

            if(!empty($teachers) && $teachers->count()){

                foreach ($teachers as $key => $value) {

                    //check if teacher exist for given registeration number
                   $teacher_exist  = Teacher::where('registeration_no','=',$value->registeration_no)->first();
                   $user_exist  = User::where('email','=',$value->email)->first();
                    //if teacher not registered
                   if(empty($teacher_exist->id)&&empty($user_exist->id)){

                       //create user
                       $user = new User();
                       $user->name = $value->fullname;
                       $user->email = $value->email;
                       $user->password = Hash::make('TutorsIQ@555666');
                       $user->confirmed = 1;
                       $user->confirmation_code = '';
                       $user->save();
                        //create teacher
                       $teacher = new Teacher();
                       $teacher->user_id = $user->id;
                       $teacher->teacher_band_id = $value->teacher_band_id;
                       $teacher->marital_status_id = $value->marital_status_id;
                       $teacher->gender_id = $value->gender_id;
                       $teacher->firstname = '';
                       $teacher->lastname = '';
                       $teacher->fullname = $value->fullname;
                       $teacher->father_name = $value->father_name;
                       $teacher->expected_minimum_fee = $value->expected_minimum_fee;
                       $teacher->expected_max_fee = $value->expected_max_fee;
                       $teacher->religion = $value->religion;
                       $teacher->added_by = $value->added_by;
                       $teacher->strength = $value->strength;
                       $teacher->past_experience = $value->past_experience;
                       $teacher->admin_remarks = $value->admin_remarks;
                       $teacher->about_us = $value->about_us;
                       $teacher->cnic_number = $value->cnic_number;
                       $teacher->cnic_front_image = $value->cnic_front_image;
                       $teacher->cnic_back_image = $value->cnic_back_image;
                       $teacher->email = $value->email;
                       $teacher->password = '12345';
                       $teacher->dob = date('Y-m-d',strtotime($value->email));
                       $teacher->landline = $value->landline;
                       $teacher->mobile1 = $value->mobile1;
                       $teacher->personal_contactno2 = $value->personal_contactno2;
                       $teacher->mobile2 = '';
                       $teacher->guardian_contact_no = $value->guardian_contact_no;
                       $teacher->emergency_contact_no = $value->emergency_contact_no;
                       $teacher->address_line1 = $value->address_line1;
                       $teacher->address_line2 = $value->address_line2;
                       $teacher->city = $value->city;
                       $teacher->province = $value->province;
                       $teacher->zip_code = $value->zip_code;
                       $teacher->country = $value->country;
                       $teacher->address_line1_p = $value->address_line1_p;
                       $teacher->address_line2_p = $value->address_line2_p;
                       $teacher->province_p = $value->province_p;
                       $teacher->city_p = $value->city_p;
                       $teacher->zip_code_p = $value->zip_code_p;
                       $teacher->country_p = $value->country_p;
                       $teacher->other_detail = $value->other_detail;
                       $teacher->is_active = $value->is_active;
                       $teacher->is_approved = $value->is_approved;
                       $teacher->suitable_timings = $value->suitable_timings;
                       $teacher->experience = $value->experience;
                       $teacher->age = $value->age;
                       $teacher->reference_for_rent = $value->reference_for_rent;
                       $teacher->reference_gurantor = $value->reference_gurantor;
                       $teacher->livingin = $value->livingin;
                       $teacher->visited = $value->visited;
                       $teacher->accept = $value->accept;
                       $teacher->teacher_photo = $value->teacher_photo;
                       $teacher->electricity_bill = $value->electricity_bill;
                       $teacher->terms = $value->terms;
                       $teacher->created_by = 'admin';
                       $teacher->updated_by = 'admin';
                       $teacher->registeration_no = $value->registeration_no;
                       $teacher->save();
                       $teacherId = $teacher->id;
                       $teacher_reg_no = $value->registeration_no;

                       foreach ($qualifications as $key => $value ){

                           if($teacher_reg_no == $value->registeration_no){

                               $teacher_qualification = new TeacherQualification();
                               $teacher_qualification->teacher_id = $teacherId;
                               $teacher_qualification->qualification_name = $value->qualification_name;
                               $teacher_qualification->passing_year = $value->passing_year;
                               $teacher_qualification->institution = $value->institution;
                               $teacher_qualification->grade = $value->grade;
                               $teacher_qualification->degree_document = $value->degree_document;
                               $teacher_qualification->highest_degree = $value->highest_degree;
                               $teacher_qualification->elective_subjects = $value->elective_subjects;
                               $teacher_qualification->status = $value->status;
                               $teacher_qualification->higher_degree = $value->higher_degree;
                               $teacher_qualification->save();

                           }

                       }

                       foreach ($subjects as $key => $value){

                           if($teacher_reg_no == $value->registeration_no){

                               $subject = new SubjectPreferences();
                               $subject->teacher_id = $teacherId;
                               $subject->class_subject_mapping_id = $value->class_subject_mapping_id;
                               $subject->save();

                           }

                       }

                       foreach ($grades as $key => $value){

                           if($teacher_reg_no == $value->registeration_no){

                               $category = new TuitionCategories();
                               $category->teacher_id = $teacherId;
                               $category->tuition_category_id = $value->tuition_category_id;
                               $category->save();

                           }

                       }

                       foreach ($institutes as $key => $value){

                           if($teacher_reg_no == $value->registeration_no){

                               $p_inst = new InstitutePreferences();
                               $p_inst->teacher_id = $teacherId;
                               $p_inst->institute_id = $value->institute_id;
                               $p_inst->save();

                           }

                       }

                       foreach ($locations as $key => $value){

                           if($teacher_reg_no == $value->registeration_no){

                               $location = new LocationPreferences();
                               $location->teacher_id = $teacherId;
                               $location->location_id = $value->location_id;
                               $location->zoneid = $value->zoneid;
                               $location->save();

                           }

                       }


                   }


                }
            }
        }
        return redirect()->back()->with('msg','Teachers imported successfully!');
    }
}
