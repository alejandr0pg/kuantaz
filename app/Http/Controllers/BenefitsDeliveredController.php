<?php

namespace App\Http\Controllers;

use App\Models\BenefitsDelivered;
use Closure;
use Illuminate\Http\Request;
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
        $benefits = $request->user()->benefits();

        return response()->json(
            [
                'code' => 200,
                'success' => true,
                'data' => [
                    'beneficios' => $benefits
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
            $validatedData = $request->validate([
                'id_beneficio' => 'required|exists:beneficios,id',
                'rut' => [
                    'required', 
                    new ValidChileanRut(new ChileRut),
                    'exists:users,rut'
                ],
                'total' => 'required|numeric',
                'estado' => 'required|boolean',
                'fecha' => 'required|date',
            ]);
        
            $benefitsDelivered = BenefitsDelivered::create($validatedData);

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
