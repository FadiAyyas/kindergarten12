<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use App\Models\KGClass;
use App\Models\Level;
use App\Http\Traits\GeneralTrait;
use App\Http\Requests\Backend\ClassRequest;
use Throwable;

class ClassController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        try {
            $classes = KGClass::with('level')->get();
            return $this->returnData('Classes', $classes, ' Classes details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }
    public function store(ClassRequest $request)
    {

        try {
            $Level = Level::findOrFail($request->level_id);
            $class = new KGClass();
            $class->class_name = $request->class_name;
            $class->maxCapacity = $request->maxCapacity;
            $Level = $Level->classes()->save($class);
            return $this->returnSuccessMessage('class created successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function update(ClassRequest $request, $id)
    {
        $input = $request->all();
        try {
            $data = KGClass::findOrFail($id);
            $data->update($input);
            return $this->returnSuccessMessage('Level update successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong');
        }
    }

    public function destroy($id)
    {
        try {
            $data = KGClass::findOrFail($id);
            $data->delete();
            return $this->returnError("Level delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Level does not exists');
        }
    }
}
