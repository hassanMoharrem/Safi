<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Base\BaseController;
use App\Models\DessertStation;
use App\Models\UpdatePhase;
use Illuminate\Http\Request;

class UpdatePhaseController extends BaseController
{
    public function index($id)
    {
        $lang = request()->header('Accept-Language') ?? 'en';
        $station = DessertStation::query()->where('id', $id)->where('user_id', auth()->id())->first();

        if (!$station) {
            return response()->json([
                'status' => 404,
                'message' => $lang == 'ar' ? 'ليس لديك صلاحية لإنشاء مرحلة لنظام التحلية' : 'Dessert station not found for the authenticated user.',
                'success' => false
            ], 404);
        }

        $data = UpdatePhase::where('station_id', $station->id)->get();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => $lang == 'ar' ? 'لا يوجد مرحلة لنظام التحلية' :'No update phases found for the dessert station.',
                'success' => false
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => $lang == 'ar' ? 'نجاح العملية' :'Success',
            'success' => true,
            'data' => $data
        ]);

    }
    public function show($id)
    {
        $lang = request()->header('Accept-Language') ?? 'en';
        $model = UpdatePhase::class;
        $updateSt = UpdatePhase::query()->find($id);

        if (!$updateSt) {
            return response()->json([
                'status' => 404,
                'message' => $lang == 'ar' ? 'المرحلة غير موجودة .' : 'Update phase not found.',
                'success' => false
            ], 404);
        }

        $station = DessertStation::query()
            ->where('id', $updateSt->station_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$station) {
            return response()->json([
                'status' => 403,
                'message' => $lang == 'ar' ? 'ليس لديك صلاحية لمشاهدت هذه المرحلة' :'You are not authorized to view this update phase.',
                'success' => false
            ], 403);
        }

        return parent::showBase($id, $model);
    }
    public function store(Request $request)
    {
        $lang = $request->header('Accept-Language') ?? 'en';
        $model = UpdatePhase::class;
        $params = $request->all();
        $rules = [
            'last_date'=>'required|date',
            'time'=>'required|numeric|min:1',
            'next_date'=>'required|date',
            'station_id'=>'required|exists:dessert_stations,id'
        ];
        $station = DessertStation::query()->where('id',$request->station_id)->where('user_id', auth()->id())->first();
        $update_ = UpdatePhase::query()->where('station_id',$request->station_id)->count();
        if ($station && ($station->phase > $update_)){
            return parent::storeBase($model, $params, $rules,$lang); // TODO: Change the autogenerated stub
        }elseif ($station->phase <= $update_){
            return response()->json([
                'status' => 403,
                'message' => $lang == 'ar' ? 'ليس لديك صلاحية لإنشاء مرحلة للنظام' :'You do not have permission to create another Update Phase',
                'success' => false
            ], 403);
        }else{
            return response()->json([
                'status' => 403,
                'message' => $lang == 'ar' ? 'ليس لديك صلاحية لرؤية مرحلة للنظام' :'You are not authorized to view this update phase.',
                'success' => false
            ], 403);
        }

    }
    public function update($id)
    {
        $lang = request()->header('Accept-Language') ?? 'en';
        $model = UpdatePhase::class;
        $params = \request()->all();
        $updateSt = UpdatePhase::query()->where('id',$id)->first();
        if ($updateSt){
            $station = DessertStation::query()->where('id',$params['station_id'])->where('user_id', auth()->id())->first();
            if ($station){
                $params['user_id'] = auth()->id();
                $rules = [
                    'last_date'=>'required|date',
                    'time'=>'required|numeric|min:1',
                    'next_date'=>'required|date',
                    'station_id'=>'required|exists:dessert_stations,id'
                ];
                return parent::updateBase($id, $model, $params, $rules , $lang); // TODO: Change the autogenerated stub
            }else{
                return response()->json([
                    'status' => 403,
                    'message' => $lang == 'ar' ? 'ليس لديك صلاحية لمشاهدة مرحلة النظام' :'You are not authorized to view this update phase.',
                    'success' => false
                ], 403);
            }
        }else{
            return response()->json([
                'status' => 404,
                'message' => $lang == 'ar' ? 'المرحلة غير موجودة' :'Update phase not found.',
                'success' => false
            ], 404);
        }

    }
    public function destroy($id)
    {
        $lang = request()->header('Accept-Language') ?? 'en';
        $model = UpdatePhase::class;
        $updateSt = UpdatePhase::query()->where('id',$id)->first();
        if ($updateSt){
            $station = DessertStation::query()->where('id',$updateSt->station_id)->where('user_id', auth()->id())->first();
            if ($station){
                return parent::destroyBase($id, $model,$lang); // TODO: Change the autogenerated stub
            }else{
                return response()->json([
                    'status' => 403,
                    'message' => $lang == 'ar' ? 'ليس لديك صلاحية لمشاهدة مرحلة النظام' :'You are not authorized to view this update phase.',
                    'success' => false
                ], 403);
            }
        }else{
            return response()->json([
                'status' => 404,
                'message' => $lang == 'ar' ? 'المرحلة غير موجودة' :'Update phase not found.',
                'success' => false
            ], 404);
        }


    }
}
