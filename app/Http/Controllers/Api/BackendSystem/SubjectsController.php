<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\SubjectsRequest;
use App\Models\Subjects;
use App\Http\Traits\GeneralTrait;
use Throwable;

class SubjectsController extends Controller
{
    use GeneralTrait;
    public function store(SubjectsRequest $request)
    {
        $input = $request->all();
        try {
            Subjects::create($input);
            return $this->returnSuccessMessage('Subjects created successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function update(SubjectsRequest $request, $id)
    {
        $input = $request->all();
        try {
            $data = Subjects::findOrFail($id);
            $data->update($input);
            return $this->returnSuccessMessage('Subjects update successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong , Subjects does not exists');
        }
    }

    public function destroy($id)
    {
        try {
            $data = Subjects::findOrFail($id);
            $data->delete();
            return $this->returnError("Subjects delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Subjects does not exists');
        }
    }
}
