<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;

class UserOrderHistorySeeder extends Seeder
{
    public function run()
    {
        // Obtener el usuario de prueba
        $user = User::where('email', 'test@carrito.com')->first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Usuario Test Carrito',
                'email' => 'test@carrito.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
        }

        // Obtener algunos productos
        $products = Product::take(5)->get();

        if ($products->count() < 3) {
            $this->command->warn("Se necesitan al menos 3 productos para crear el historial de pedidos");
            return;
        }

        // Crear diferentes tipos de pedidos
        $orderData = [
            [
                'status' => 'delivered',
                'payment_method' => 'transferencia',
                'created_at' => now()->subDays(15),
                'total_amount' => 150.00,
                'products' => [$products[0], $products[1]]
            ],
            [
                'status' => 'pending',
                'payment_method' => 'pago_movil',
                'created_at' => now()->subDays(5),
                'total_amount' => 89.99,
                'products' => [$products[1]]
            ],
            [
                'status' => 'cancelled',
                'payment_method' => 'efectivo',
                'created_at' => now()->subDays(8),
                'total_amount' => 200.00,
                'products' => [$products[2], $products[3]]
            ],
            [
                'status' => 'confirmed',
                'payment_method' => 'transferencia',
                'created_at' => now()->subDays(2),
                'total_amount' => 75.50,
                'products' => [$products[0]]
            ],
            [
                'status' => 'shipped',
                'payment_method' => 'pago_movil',
                'created_at' => now()->subDays(3),
                'total_amount' => 125.75,
                'products' => [$products[3], $products[4]]
            ]
        ];

        foreach ($orderData as $orderInfo) {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'status' => $orderInfo['status'],
                'total_amount' => $orderInfo['total_amount'],
                'tax_amount' => 0,
                'shipping_amount' => 0,
                'shipping_address' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'address' => 'Av. Principal #123, Edificio Torre Azul, Piso 5, Apt 5B',
                    'city' => 'Caracas',
                    'country' => 'Venezuela',
                    'zip' => '1010'
                ],
                'payment_method' => $orderInfo['payment_method'],
                'payment_status' => $orderInfo['status'] === 'delivered' ? 'paid' : 'pending',
                'created_at' => $orderInfo['created_at'],
                'updated_at' => $orderInfo['created_at'],
            ]);

            // Crear items del pedido
            foreach ($orderInfo['products'] as $index => $product) {
                $quantity = rand(1, 3);
                $unitPrice = $product->precio;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $quantity * $unitPrice,
                    'color' => ['Negro', 'Blanco', 'Azul', 'Rojo'][rand(0, 3)],
                    'size' => ['S', 'M', 'L', 'XL'][rand(0, 3)],
                    'product_snapshot' => [
                        'nombre' => $product->nombre,
                        'descripcion' => $product->descripcion,
                        'imagen' => $product->imagen,
                        'categoria' => $product->categoria,
                    ]
                ]);
            }

            $this->command->info("Pedido #{$order->order_number} creado con estado: {$order->status}");
        }

        $this->command->info("Se crearon " . count($orderData) . " pedidos de ejemplo para el usuario {$user->email}");
    }
}
