<?php

namespace App\Http\Controllers;

use App\Models\Eletrodomestico;
use Illuminate\Http\Request;
use Validator;

class EletrodomesticoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Eletrodomestico::with('marca')->paginate(15);

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
                'nome' => 'required',
                'descricao' => 'required',
                'tensao' => 'required|integer|numeric|min:3',
                'id_marca' => 'required',
            ],
            [
                'nome.required' => 'O campo Nome é obrigatório.',
                'descricao.required' => 'O campo Descrição é obrigatório.',
                'tensão.required' => 'O campo Tensão é obrigatório.',
                'id_marca.required' => 'O campo Marca é obrigatório. '
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Erro de validação",
                'error' => $validator->errors()
            ], 500);
        }

        $list = Eletrodomestico::create($input);

        return response()->json([
            'status' => true,
            'message' => "Eletrodomésticos criado com sucesso!",
            'list' => $list
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $list = Eletrodomestico::findOrFail($id);
        return response()->json([
            'list' => $list,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Eletrodomestico $eletrodomestico)
    {
        $input = $request->all();

        $validator = Validator::make(
            $input,
            [
                'nome' => 'required',
                'descricao' => 'required',
                'tensao' => 'required|integer|numeric|min:3',
                'id_marca' => 'required',
            ],
            [
                'nome.required' => 'O campo Nome é obrigatório.',
                'descricao.required' => 'O campo Descrição é obrigatório.',
                'tensão.required' => 'O campo Tensão é obrigatório.',
                'id_marca.required' => 'O campo Marca é obrigatório. '
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Erro de validação",
                'error' => $validator->errors()
            ], 500);
        }

        $eletrodomestico->update($input);

        return response()->json([
            'status' => true,
            'message' => "Eletrodomésticos atualizado com sucesso!",
            'list' => $eletrodomestico
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Eletrodomestico $eletrodomestico)
    {
        $eletrodomestico->delete();

        return response()->json([
            'status' => true,
            'message' => "Eletrodomésticos excluído com sucesso!",
        ], 200);
    }
}
