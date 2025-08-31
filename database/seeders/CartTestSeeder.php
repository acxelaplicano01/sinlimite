<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Hash;

class CartTestSeeder extends Seeder
{
    public function run()
    {
        // Crear un usuario de prueba si no existe
        $user = User::firstOrCreate(
            ['email' => 'test@carrito.com'],
            [
                'name' => 'Usuario Test Carrito',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Limpiar carrito existente
        CartItem::where('user_id', $user->id)->delete();

        // Obtener algunos productos
        $products = Product::take(3)->get();

        if ($products->count() > 0) {
            // Agregar productos al carrito
            foreach ($products as $index => $product) {
                CartItem::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $index + 1, // 1, 2, 3 cantidades diferentes
                    'price' => $product->precio,
                    'color' => 'Negro',
                    'size' => 'M',
                ]);
            }

            $this->command->info("Se agregaron {$products->count()} productos al carrito del usuario {$user->email}");
        } else {
            $this->command->warn("No se encontraron productos para agregar al carrito");
        }
    }
}
