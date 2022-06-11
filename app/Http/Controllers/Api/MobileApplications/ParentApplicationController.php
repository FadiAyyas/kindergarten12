<?php

namespace App\Http\Controllers\Api\MobileApplications;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileApplications\parentChildAbcenceRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\Activity;
use App\Models\Children;
use App\Models\Gallery;
use App\Models\KgContact;
use Illuminate\Support\Facades\auth;
use App\Models\ParentChildAbsence;
use App\Models\Registration;
use Throwable;

class ParentApplicationController extends Controller
{
    use GeneralTrait;
    public function getChildren()
    {
    }

    public function getKgContact()
    {
        try {
            $contacts = KgContact::all();
            return $this->returnData('KgContact', $contacts, ' Kindergaten Contacts info ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function getActivitiesInfo()
    {
        try {
            $details = Activity::all();
            return $this->returnData('Activities', $details, ' Activity details ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
    public function getKgImages()
    {
        try {
            $images = Gallery::all();
            return $this->returnData('images', $images, ' Kg images ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
    public function abcenseRecording(parentChildAbcenceRequest $request)
    {
        $registration = Registration::latest('id')->where('child_id', $request->child_id)->first();
        try {
            ParentChildAbsence::create([
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
                'reason' => $request->reason,
                'registration_id' => $registration->id,
            ]);
            return $this->returnSuccessMessage('تم تسجيل طلب غياب بنجاح');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
}
