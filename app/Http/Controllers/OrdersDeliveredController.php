<?php

namespace App\Http\Controllers;

use App\Models\OrdersDelivered;
use App\Models\OrderItems;
use App\Models\PendingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class OrdersDeliveredController extends Controller
{
    public function store(Request $request){
    try {
        // Registra los datos recibidos para depuración
        Log::info(json_encode($request->all()));  // Convierte el array a JSON antes de registrar

        // Validar que la estructura de los datos sea un array de objetos
        $request->validate([
            '*.id' => 'required|integer',
            '*.items' => 'required|array',
            '*.items.*.nameDrink' => 'required|string',
            '*.items.*.cantidad' => 'required|integer',
        ]);

        // Recorrer cada pedido en el array recibido
        foreach ($request->all() as $orderData) {
            foreach ($orderData['items'] as $item) {
                // Crear un nuevo pedido en OrdersDelivered
                $orderDelivered = OrdersDelivered::create([
                    'user_id' => $orderData['id'],
                    'nameDrink' => $item['nameDrink'],  // Asegúrate de usar el nombre correcto
                    'cantidad' => $item['cantidad'],
                ]);
            }
                

            // Eliminar los pedidos pendientes del usuario en PendingOrder
            PendingOrder::where('user_id', $orderData['id'])->delete();
        }

        return response()->json(['message' => 'Pedidos entregados creados y pedidos pendientes eliminados exitosamente'], 201);

    } catch (\Exception $e) {
        // Captura y responde con el error
        return response()->json(['error' => $e->getMessage()], 422);
    }
}
public function getByUserId($user_id)
{
    try {
        // Obtener los pedidos entregados filtrados por user_id
        $ordersDelivered = OrdersDelivered::where('user_id', $user_id)->with('items')->get();

        // Verificar si hay pedidos entregados para ese usuario
        if ($ordersDelivered->isEmpty()) {
            return response()->json(['message' => 'No se encontraron pedidos entregados para este usuario.'], 404);
        }

        return response()->json($ordersDelivered, 200);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
