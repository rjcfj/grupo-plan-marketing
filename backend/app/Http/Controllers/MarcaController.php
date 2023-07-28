<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Validator;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $id = $request->input('id', null);
        $nome = $request->input('nome', null);

        $list = Marca::paginate(15);

        if ($id) {
            $list = Marca::where('id', $id)->paginate(15);
        }

        if ($nome) {
            $list = Marca::where('nome', 'like', "%$nome%")->paginate(15);
        }

        return response()->json([
            'status' => true,
            'list' => $list
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make(
            $input,
            [
                'nome' => 'required'
            ],
            [
                'nome.required' => 'O campo Nome é obrigatório.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Erro de validação",
                'error' => $validator->errors()
            ], 500);
        }

        $Waste = Marca::create($input);

        return response()->json([
            'status' => true,
            'message' => "Marca criado com sucesso!",
            'Waste' => $Waste
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $list = Marca::findOrFail($id);
        return response()->json([
            'list' => $list,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marca $marca)
    {
        $input = $request->all();

        $validator = Validator::make(
            $input,
            [
                'nome' => 'required'
            ],
            [
                'nome.required' => 'O campo Nome é obrigatório.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Erro de validação",
                'error' => $validator->errors()
            ], 500);
        }

        $marca->update($input);

        return response()->json([
            'status' => true,
            'message' => "Marca atualizado com sucesso!",
            'list' => $marca
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marca $marca)
    {
        $marca->delete();

        return response()->json([
            'status' => true,
            'message' => "Marca excluído com sucesso!",
        ], 200);
    }
}
