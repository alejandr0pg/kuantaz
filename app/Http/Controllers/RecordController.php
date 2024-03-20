<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
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
                    'fichas' => Record::all()
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
                'nombre' => 'required|unique:ficha',
                'url' => 'required'
            ]);
        
            $record = Record::create($validatedData);

            return response()->json(
                [
                    'code' => 200,
                    'success' => true,
                    'data' => $record
                ]
            );
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Record $record)
    {
        try { 
            $validatedData = $request->validate([
                'nombre' => 'required|unique:ficha',
                'url' => 'required'
            ]);
        
            $record->update($validatedData);

            return response()->json(
                [
                    'code' => 200,
                    'success' => true,
                    'data' => $record
                ]
            );
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        try { 
            
            $record->delete();

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
