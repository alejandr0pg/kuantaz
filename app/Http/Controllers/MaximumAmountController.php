<?php

namespace App\Http\Controllers;

use App\Models\MaximumAmount;
use Illuminate\Http\Request;

class MaximumAmountController extends Controller
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
                    'montos_maximos' => MaximumAmount::all()
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
                'id_beneficio' => 'required|exists:beneficios,id|unique:montos_maximos',
                'monto_minimo' => 'required|numeric',
                'monto_maximo' => 'required|numeric'
            ]);
        
            $maximunAmount = MaximumAmount::create($validatedData);

            return response()->json(
                [
                    'code' => 200,
                    'success' => true,
                    'data' => $maximunAmount
                ]
            );
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaximumAmount $maximunAmount)
    {
        try { 
            $validatedData = $request->validate([
                'id_beneficio' => 'required|exists:beneficios,id|unique:montos_maximos',
                'monto_minimo' => 'required|numeric',
                'monto_maximo' => 'required|numeric'
            ]);
        
            $maximunAmount->update($validatedData);

            return response()->json(
                [
                    'code' => 200,
                    'success' => true,
                    'data' => $maximunAmount
                ]
            );
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaximumAmount $maximunAmount)
    {
        try { 
            
            $maximunAmount->delete();

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
