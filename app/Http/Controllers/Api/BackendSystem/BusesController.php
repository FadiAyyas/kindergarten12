<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\BusItinerary;
use App\Models\BusChild;
use Throwable;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Backend\BusesRequest;

class BusesController extends Controller
{


    public function showBusItineraries()
    {
        try {
            $details = BusItinerary::all();
            return $this->returnData('details', $details, ' Bus Itineraries and Cost details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }


    public function showBuses($Itinerary_id)
    {
        try {
            $Itinerary = BusItinerary::findOrFail($Itinerary_id);
            $details = $Itinerary->buses();
            return $this->returnData('details', $details, ' Buses details');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }



    public function storeItinerary(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'itinerary' => ['required', 'max:255', 'string'],
                'cost' => ['required', 'numeric', 'min:0']
            ]);
            if ($validator->fails()) {
                return $this->returnError($validator->errors());
            }
            $input = $request->all();
            BusItinerary::create($input);
            return $this->returnSuccessMessage('Itinerary data created successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function updateItinerary(Request $request, $Itinerary_id)
    {
          $input = $request->only('itinerary','cost');
        try {
            $validator = Validator::make($request->all(), [
                'itinerary' => ['required', 'max:255', 'string'],
                'cost' => ['required', 'numeric', 'min:0']
            ]);
            if ($validator->fails()) {
                return $this->returnError($validator->errors());
            }
            $data = BusItinerary::findOrFail($Itinerary_id);
            $data->update($input);
            return $this->returnSuccessMessage('Itinerary update successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong , Itinerary does not exists');
        }
    }



    public function storeBuses(BusesRequest $request, $Itinerary_id)
    {
        try {
            $input = $request->all();
            $input['busItinerary_id'] = $Itinerary_id;
            Bus::create($input);
            return $this->returnSuccessMessage('Buses data created successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function updateBuses(BusesRequest $request, $Bus_id)
    {
        $input = $request->all();
        try {
            $data = Bus::findOrFail($Bus_id);
            $data->update($input);
            return $this->returnSuccessMessage('Bus update successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong , Bus does not exists');
        }
    }


    public function  registeringChildOnBus(Request $request, $Bus_id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'registration_id' => ['required', 'numeric'],
            ]);
            if ($validator->fails()) {
                return $this->returnError($validator->errors());
            }
            $input['registration_id'] = $request->registration_id;
            $input['bus_id'] = $Bus_id;
            BusChild::create($input);
            return $this->returnSuccessMessage('Registering a Child On Bus created successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }


    public function deleteItinerary($Itinerary_id)
    {
        try {
            $data = BusItinerary::findOrFail($Itinerary_id);
            $data->delete();
            return $this->returnError("Bus Itinerary details delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Bus Itinerary details does not exists');
        }
    }


    public function deleteBus($Bus_id)
    {
        try {
            $data = Bus::findOrFail($Bus_id);
            $data->delete();
            return $this->returnError("Bus details delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Bus details does not exists');
        }
    }
}
