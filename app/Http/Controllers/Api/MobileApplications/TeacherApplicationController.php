<?php

namespace App\Http\Controllers\Api\MobileApplications;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileApplications\teacherChildAbsenceRequest;
use App\Models\Children;
use App\Models\Employee;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use App\Models\ChildAbsence;
use App\Models\Season_year;
use Throwable;

class TeacherApplicationController extends Controller
{
    use GeneralTrait;
    public function getClassChildren()
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $class_id = Employee::join("teacher_classes", "teacher_classes.employee_id", "=", "employees.id")
                ->join("Kgclasses", "Kgclasses.id", "=", "teacher_classes.class_id")
                ->where('employees.id', 3)
                ->get('Kgclasses.id')->first();
            $children = Registration::join("childrens", "childrens.id", "=", "registrations.child_id")
                ->where('class_id', $class_id->id)
                ->where('season_year_id', $season_year->id)
                ->get(['childrens.id', 'childrens.childName', 'childrens.ChildImage']);

            return $this->returnData('children', $children, ' children ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function childAbsence(teacherChildAbsenceRequest $request)
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $registration = Registration::where('child_id', $request->child_id)
                ->where('season_year_id', $season_year->id)
                ->first();

            $absence = ChildAbsence::where('registration_id', $registration->id)
                ->where('date', $request->date)
                ->first();

            if ($absence == null && $request->exist == false) {
                childAbsence::create([
                    'registration_id' => $registration->id,
                    'date' => $request->date
                ]);
            }
            if ($absence != null && $request->exist == true) {
                $absence->delete();
            }
            if ($request->exist == false) {
                return $this->returnSuccessMessage('تم تسجيل غياب بنجاح');
            } else {
                return $this->returnSuccessMessage('تم الغاء تسجيل الغياب بنجاح');
            }
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
}
