<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use Illuminate\Http\Request;

class BenefitController extends Controller
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
                    'beneficios' => Benefit::all()
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
                'nombre' => 'required|unique:beneficios',
                'id_ficha' => 'required|exists:ficha,id',
                'fecha' => 'required|date'
            ]);
        
            $benefit = Benefit::create($validatedData);

            return response()->json(
                [
                    'code' => 200,
                    'success' => true,
                    'data' => $benefit
                ]
            );
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Benefit $benefit)
    {
        try { 
            $validatedData = $request->validate([
                'nombre' => 'required|unique:beneficios',
                'id_ficha' => 'required',
                'fecha' => 'required|date'
            ]);
        
            $benefit->update($validatedData);

            return response()->json(
                [
                    'code' => 200,
                    'success' => true,
                    'data' => $benefit
                ]
            );
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Benefit $benefit)
    {
        try { 
            
            $benefit->delete();

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
