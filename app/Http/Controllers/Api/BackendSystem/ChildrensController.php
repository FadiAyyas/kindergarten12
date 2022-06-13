<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\ParentCh;
use App\Models\Registration;
use Throwable;
use App\Http\Traits\GeneralTrait;
use App\Http\Requests\Backend\ChildrensRequest;
use App\Http\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class ChildrensController extends Controller
{
    use GeneralTrait, ImageUploadTrait;

    //show childrens
    public function index()
    {
        try {
            $details = Children::with('registration')->get();
            return $this->returnData('details', $details, ' Childrens details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    //Registration childrens
    public function store(ChildrensRequest $request, $parent_id)
    {
        $data =json_decode($request->getContent(),true);
        return $this->returnData('details', $data, 'Father Childrens details ');

        try {
            $parent = ParentCh::findOrFail($parent_id);
            if ($request->childrens) {
                foreach ($request->childrens as $child) {
                    $Parentchild = new Children;
                    $Parentchild->childName = $child['childName'];
                    $Parentchild->birthDate = $child['birthDate'];
                    $Parentchild->gender = $child['gender'];
                    $Parentchild->childAddress = $child['childAddress'];
                    $Parentchild->medicalNotes = $child['medicalNotes'];
                    $Parentchild->ChildImage = $this->uploadImage($child['childName'], $child['ChildImage'], 'Childrens/images/');

                    $chilsRegistration = new Registration;
                    $chilsRegistration->class_id = $child['class_id'];
                    $chilsRegistration->season_year_id = $child['season_year_id'];
                    $chilsRegistration->registrationDate = now();

                    DB::transaction(function () use ($parent, $chilsRegistration, $Parentchild) {
                        $parent->childrens()->save($Parentchild);
                        $Parentchild->registration()->save($chilsRegistration);
                    });
                }
            } else
                return $this->returnError('Something was wrong, please try again late');

            return $this->returnSuccessMessage('Childrens created successfully ');
        } catch (Throwable $e) {
            return $this->returnError($e);
        }
    }
    //edit childrens
    public function update(ChildrensRequest $request, $child_id)
    {
        try {
            $input = $request->only('childName', 'birthDate', 'gender', 'childAddress', 'medicalNotes');
            $Child = Children::findOrFail($child_id);
            if ($request->ChildImage) {
                $this->imageDelete($Child->ChildImage);
                $input['ChildImage'] = $this->uploadImage($input['childName'], $input['ChildImage'], 'Childrens/images/');
            }

            $Child->update($input);
            return $this->returnSuccessMessage('Childrens updated successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function ShowFathersChildrensDetails($parent_id)
    {
        try {
            $details = Children::all()->where('parent_id', $parent_id);
            return $this->returnData('details', $details, 'Father Childrens details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function showChildDetails($child_id)
    {
        try {
            $details = Children::findOrFail($child_id);
            return $this->returnData('details', $details, 'child details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    //Show the absence of a child
    public function showChildAbsence($child_id)
    {
        try {
            $registration = Registration::latest('id')->where('child_id', $child_id)->first();
            $details = $registration->childAbsence;

            return $this->returnData('details', $details, 'Child Absence details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }


    //Show child reviews
    public function showChildEvaluations($child_id)
    {
        try {
            $registration = Registration::latest('id')->where('child_id', $child_id)->first();
            $details = $registration->childEvaluation;

            return $this->returnData('details', $details, 'Child Absence details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    //search child details
    public function searchChild(Request $request)
    {
    }

    //delete child details
    public function destroy($child_id)
    {
        try {
            $data = Children::findOrFail($child_id);
            $this->imageDelete($data->ChildImage);
            $data->delete();
            return $this->returnError("Children details delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Children details does not exists');
        }
    }
}
