<?php

namespace App\Http\Controllers;

use App\Models\PendingOrder;
use Illuminate\Http\Request;

class PendingOrderController extends Controller
{
    public function index()
    {
        $pendingOrders = PendingOrder::all();
        return response()->json(['pendingOrders' => $pendingOrders], 200);
    }

    public function create()
    {
        // Si no necesitas devolver una vista, podrías simplemente retornar un mensaje
        return response()->json(['message' => 'Formulario de creación cargado correctamente'], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nameDrink' => 'required|string|max:255',
            'cantidad' => 'required|integer',
        ]);

        PendingOrder::create($request->all());

        return response()->json(['message' => 'Pedido pendiente creado exitosamente'], 201);
    }

    public function show(PendingOrder $pendingOrder)
    {
        return response()->json(['pendingOrder' => $pendingOrder], 200);
    }

    public function edit(PendingOrder $pendingOrder)
    {
        return response()->json(['message' => 'Formulario de edición cargado correctamente', 'pendingOrder' => $pendingOrder], 200);
    }

    public function update(Request $request, PendingOrder $pendingOrder)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nameDrink' => 'required|string|max:255',
            'cantidad' => 'required|integer',
        ]);

        $pendingOrder->update($request->all());

        return response()->json(['message' => 'Pedido pendiente actualizado exitosamente'], 200);
    }

    public function destroy(PendingOrder $pendingOrder)
    {
        $pendingOrder->delete();

        return response()->json(['message' => 'Pedido pendiente eliminado exitosamente'], 200);
    }

    public function getByUserId($user_id)
    {
        // Obtener los pedidos pendientes por el user_id proporcionado
        $pendingOrders = PendingOrder::where('user_id', $user_id)->get();
    
        // Verificar si hay pedidos pendientes para ese usuario
        if ($pendingOrders->isEmpty()) {
            return response()->json(['message' => 'No se encontraron pedidos pendientes para este usuario.'], 404);
        }
    
        return response()->json(['pendingOrders' => $pendingOrders], 200);
    }

}


