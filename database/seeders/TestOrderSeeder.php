<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un usuario de prueba si no existe
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Usuario de Prueba', 'password' => bcrypt('password')]
        );

        // Verificar que hay productos
        $products = \App\Models\Product::take(2)->get();

        if ($products->count() >= 2) {
            $product1 = $products->first();
            $product2 = $products->last();

            // Crear un pedido de ejemplo con estado pending
            $order1 = \App\Models\Order::create([
                'user_id' => $user->id,
                'order_number' => \App\Models\Order::generateOrderNumber(),
                'status' => 'pending',
                'total_amount' => ($product1->precio * 2) + $product2->precio,
                'tax_amount' => 0,
                'shipping_amount' => 0,
                'shipping_address' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'address' => 'Calle de Prueba 123',
                    'city' => 'Ciudad de Prueba',
                    'country' => 'País de Prueba',
                    'zip' => '12345'
                ],
                'payment_method' => null,
                'payment_status' => 'pending',
            ]);

            // Crear items para el pedido
            \App\Models\OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $product1->id,
                'quantity' => 2,
                'unit_price' => $product1->precio,
                'total_price' => $product1->precio * 2,
                'color' => 'Azul',
                'size' => 'M',
                'product_snapshot' => [
                    'nombre' => $product1->nombre,
                    'descripcion' => $product1->descripcion,
                    'imagen' => $product1->imagen,
                    'categoria' => $product1->categoria,
                ]
            ]);

            \App\Models\OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $product2->id,
                'quantity' => 1,
                'unit_price' => $product2->precio,
                'total_price' => $product2->precio,
                'color' => 'Negro',
                'size' => '40',
                'product_snapshot' => [
                    'nombre' => $product2->nombre,
                    'descripcion' => $product2->descripcion,
                    'imagen' => $product2->imagen,
                    'categoria' => $product2->categoria,
                ]
            ]);

            // Crear otro pedido confirmado
            $order2 = \App\Models\Order::create([
                'user_id' => $user->id,
                'order_number' => \App\Models\Order::generateOrderNumber(),
                'status' => 'confirmed',
                'total_amount' => $product1->precio,
                'tax_amount' => 0,
                'shipping_amount' => 0,
                'shipping_address' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'address' => 'Calle de Prueba 456',
                    'city' => 'Ciudad de Prueba',
                    'country' => 'País de Prueba',
                    'zip' => '12345'
                ],
                'payment_method' => null,
                'payment_status' => 'pending',
                'confirmed_at' => now()->subHours(2),
            ]);

            \App\Models\OrderItem::create([
                'order_id' => $order2->id,
                'product_id' => $product1->id,
                'quantity' => 1,
                'unit_price' => $product1->precio,
                'total_price' => $product1->precio,
                'color' => 'Blanco',
                'size' => 'L',
                'product_snapshot' => [
                    'nombre' => $product1->nombre,
                    'descripcion' => $product1->descripcion,
                    'imagen' => $product1->imagen,
                    'categoria' => $product1->categoria,
                ]
            ]);

            echo "Pedidos de prueba creados exitosamente:\n";
            echo "- Pedido #{$order1->order_number} (pendiente)\n";
            echo "- Pedido #{$order2->order_number} (confirmado)\n";
            echo "Usuario: {$user->email}\n";
        } else {
            echo "No hay suficientes productos en la base de datos.\n";
        }
    }
}
