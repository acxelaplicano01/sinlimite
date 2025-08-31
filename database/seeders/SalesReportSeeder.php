<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios y productos existentes
        $user = \App\Models\User::where('email', 'test@example.com')->first();
        $products = \App\Models\Product::all();

        if (!$user || $products->count() < 2) {
            echo "No hay suficientes usuarios o productos. Ejecuta primero TestOrderSeeder.\n";
            return;
        }

        $statuses = ['pending', 'confirmed', 'paid', 'shipped', 'delivered'];
        
        // Crear pedidos de los últimos 30 días
        for ($i = 30; $i >= 0; $i--) {
            $date = now()->subDays($i);
            
            // Crear entre 1-5 pedidos por día (más en días recientes)
            $ordersPerDay = $i > 20 ? rand(1, 2) : rand(2, 5);
            
            for ($j = 0; $j < $ordersPerDay; $j++) {
                $product1 = $products->random();
                $product2 = $products->random();
                
                $quantity1 = rand(1, 3);
                $quantity2 = rand(1, 2);
                
                $totalAmount = ($product1->precio * $quantity1) + ($product2->precio * $quantity2);
                
                $order = \App\Models\Order::create([
                    'user_id' => $user->id,
                    'order_number' => \App\Models\Order::generateOrderNumber(),
                    'status' => $statuses[array_rand($statuses)],
                    'total_amount' => $totalAmount,
                    'tax_amount' => 0,
                    'shipping_amount' => 0,
                    'shipping_address' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'address' => 'Dirección de Prueba ' . rand(100, 999),
                        'city' => 'Ciudad Ejemplo',
                        'country' => 'País Ejemplo',
                        'zip' => '12345'
                    ],
                    'payment_method' => rand(0, 1) ? 'credit_card' : 'paypal',
                    'payment_status' => in_array($order->status ?? 'pending', ['paid', 'shipped', 'delivered']) ? 'paid' : 'pending',
                    'created_at' => $date->setTime(rand(9, 20), rand(0, 59), rand(0, 59)),
                    'updated_at' => $date->setTime(rand(9, 20), rand(0, 59), rand(0, 59)),
                ]);

                // Actualizar timestamps según el estado
                if (in_array($order->status, ['confirmed', 'paid', 'shipped', 'delivered'])) {
                    $order->update(['confirmed_at' => $order->created_at->addMinutes(rand(30, 120))]);
                }
                if (in_array($order->status, ['paid', 'shipped', 'delivered'])) {
                    $order->update(['paid_at' => $order->confirmed_at->addHours(rand(1, 24))]);
                }
                if (in_array($order->status, ['shipped', 'delivered'])) {
                    $order->update(['shipped_at' => $order->paid_at->addDays(rand(1, 3))]);
                }
                if ($order->status === 'delivered') {
                    $order->update(['delivered_at' => $order->shipped_at->addDays(rand(1, 7))]);
                }

                // Crear items del pedido
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product1->id,
                    'quantity' => $quantity1,
                    'unit_price' => $product1->precio,
                    'total_price' => $product1->precio * $quantity1,
                    'color' => ['Azul', 'Rojo', 'Negro', 'Blanco'][array_rand(['Azul', 'Rojo', 'Negro', 'Blanco'])],
                    'size' => ['S', 'M', 'L', 'XL'][array_rand(['S', 'M', 'L', 'XL'])],
                    'product_snapshot' => [
                        'nombre' => $product1->nombre,
                        'descripcion' => $product1->descripcion,
                        'imagen' => $product1->imagen,
                        'categoria' => $product1->categoria,
                    ]
                ]);

                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product2->id,
                    'quantity' => $quantity2,
                    'unit_price' => $product2->precio,
                    'total_price' => $product2->precio * $quantity2,
                    'color' => ['Verde', 'Amarillo', 'Gris', 'Rosa'][array_rand(['Verde', 'Amarillo', 'Gris', 'Rosa'])],
                    'size' => ['38', '39', '40', '41', '42'][array_rand(['38', '39', '40', '41', '42'])],
                    'product_snapshot' => [
                        'nombre' => $product2->nombre,
                        'descripcion' => $product2->descripcion,
                        'imagen' => $product2->imagen,
                        'categoria' => $product2->categoria,
                    ]
                ]);
            }
        }

        echo "Datos de ventas generados exitosamente para los últimos 30 días.\n";
        echo "Total de pedidos creados: " . \App\Models\Order::count() . "\n";
        echo "Total de items vendidos: " . \App\Models\OrderItem::sum('quantity') . "\n";
        echo "Ingresos totales: $" . number_format(\App\Models\Order::where('status', '!=', 'cancelled')->sum('total_amount'), 2) . "\n";
    }
}
