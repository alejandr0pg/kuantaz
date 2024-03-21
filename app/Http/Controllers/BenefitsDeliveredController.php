<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\BenefitsDelivered;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Rules\ValidChileanRut;

class BenefitsDeliveredController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            [
                'code' => 200,
                'success' => true,
                'data' => [
                    'beneficios_entregados' => BenefitsDelivered::all()
                ]    
            ]
        );
    }

    public function myBenefits(Request $request)
    {
        $cleanedRut = (new ChileRut)->clean($request->rut);
        list($run, $dv) = explode('-', $cleanedRut);

        $benefitsDeliveredQuery = BenefitsDelivered::where([
            ['run', '=', $run],
            ['dv', '=', $dv],
        ])->get();

        $benefitsDeliveredFormatted = collect();

        collect($benefitsDeliveredQuery->toArray())
            ->groupBy(function (array $item) {
                return Carbon::parse($item['fecha'])->format('Y');
            })
            ->map(function($benefitsByYear, $year) use ($benefitsDeliveredFormatted) {
                $benefitsCollect = collect();
                $total = 0;

                foreach($benefitsByYear as $benefitDelivered) {
                    $_benefit = Benefit::find($benefitDelivered['id_beneficio'])
                                    ->with(['ficha' => fn ($query) => $query->where('publicada', true)])
                                    ->whereRelation('maxAmount', 'monto_maximo', '<=', $benefitDelivered['total'])
                                    ->first();

                    $total += $_benefit->maxAmount->monto_maximo;
                    $benefitsCollect->push($_benefit);
                }

                $benefitsDeliveredFormatted->push([
                    'year' => $year,
                    'num' => count($benefitsCollect),
                    'totalAmount' => Number::currency((int) $total),
                    'beneficios' => $benefitsCollect,
                ]);
            });

        return response()->json(
            [
                'code' => 200,
                'success' => true,
                'data' => [
                    'beneficios' => $benefitsDeliveredFormatted
                ]    
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_beneficio' => 'required|exists:beneficios,id',
                'rut' => [
                    'required', 
                    new ValidChileanRut(new ChileRut),
                    'exists:users,rut'
                ],
                'total' => 'required|numeric',
                'estado' => 'required|numeric',
                'fecha' => 'required|date',
            ]);
            
            $cleanedRut = (new ChileRut)->clean($request->rut);
            list($run, $dv) = explode('-', $cleanedRut);

            $benefitsDelivered = new BenefitsDelivered;
            $benefitsDelivered->id_beneficio = $request->id_beneficio;
            $benefitsDelivered->run = $run;
            $benefitsDelivered->dv = $dv;
            $benefitsDelivered->fecha = $request->fecha;
            $benefitsDelivered->estado = $request->estado;
            $benefitsDelivered->total = $request->total;
            $benefitsDelivered->save();

            return response()->json(
                [
                    'code' => 200,
                    'success' => true,
                    'data' => $benefitsDelivered
                ]
            );
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BenefitsDelivered $benefitsDelivered)
    {
        try { 
            
            $benefitsDelivered->delete();

            return response()->json(
                [
                    'code' => 200,
                    'success' => true
                ]
            );
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }
}
