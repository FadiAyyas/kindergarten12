<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use App\Models\ParentCh;
use App\Models\ParentPhoneNumbers;
use Throwable;
use App\Http\Traits\GeneralTrait;
use App\Http\Requests\Backend\ParentsRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{

    use GeneralTrait;
    public function index()
    {
        try {
            $paresnts = ParentCh::with('phone_numbers')->get();
            return $this->returnData('paresnts', $paresnts, ' Paresnts details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function store(ParentsRequest $request)
    {
        try {
            $Parent = new ParentCh;
            $Parent->fatherName = $request->fatherName;
            $Parent->motherName = $request->motherName;
            $Parent->fatherLastName = $request->fatherLastName;
            $Parent->email = $request->email;
            $Parent->password = Hash::make($request->password);
            $Parent->save();
            /*
            foreach ($request->phoneNumbers as $phoneNumber) {
                $Phone = new ParentPhoneNumbers;
                $Phone->type = $phoneNumber['type'];
                $Phone->phoneNumber = $phoneNumber['phoneNumber'];
                $Parent->phone_numbers()->save($Phone);
            }
            */
            
            $input = $request->only('phoneNumbers');

            if ($request->phoneNumbers) {
                return $this->returnData('Parent Id', $request->phoneNumbers, ' Paresnts details created successfully');
            }

            if ($input['phoneNumbers']) {
                return $this->returnData('Parent Id', true, ' Paresnts details created successfully');
            }

            return $this->returnData('Parent Id', $request->phoneNumbers, ' Paresnts details created successfully');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }



    public function updateParentDetails(ParentsRequest $request, $parent_id)
    {
        $input = $request->only('fatherName', 'motherName', 'fatherLastName');
        try {
            $data = ParentCh::findOrFail($parent_id);
            $data->update($input);
            return $this->returnSuccessMessage('Parents update successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong , Contact does not exists');
        }
    }


    public function updateParentContactsDetails(Request $request, $phone_id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => ['required', 'string'],
                'phoneNumber' => ['required', 'numeric', 'max:16', 'min:6']
            ]);
            if ($validator->fails()) {
                return $this->returnError($validator->errors());
            } else {
                $input = $request->only('type', 'phoneNumber');
                $data = ParentPhoneNumbers::findOrFail($phone_id);
                $data->update($input);
                return $this->returnSuccessMessage('Parent Contact changed successfully ');
            }
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }


    public function changeParentPassword(Request $request, $parent_id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8'
        ]);
        if ($validator->fails()) {
            return $this->returnError($validator->errors());
        } else {
            $data = ParentCh::findOrFail($parent_id);
            $data->password = Hash::make($request->password);
            $data->save();
            return $this->returnSuccessMessage('Parent Password  changed successfully ');
        }
    }

    public function destroy($parent_id)
    {
        try {
            $data = ParentCh::findOrFail($parent_id);
            $data->delete();
            return $this->returnError("parents details delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('parents details does not exists');
        }
    }
}
