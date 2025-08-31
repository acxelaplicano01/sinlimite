<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Bordados
            [
                'nombre' => 'Camiseta con Bordado Personalizado',
                'categoria' => 'Bordados',
                'precio' => 29.99,
                'descripcion' => 'Camiseta de alta calidad con bordado personalizado. Perfecta para eventos, equipos deportivos o uso personal. Bordado con hilos de primera calidad.',
                'color' => 'negro,blanco,azul,rojo',
                'talla' => 'S,M,L,XL',
                'reviews' => 5,
                'linkfacebook' => 'https://facebook.com/sinlimite',
                'imagen' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop'
            ],
            [
                'nombre' => 'Gorra Bordada Logo Empresa',
                'categoria' => 'Bordados',
                'precio' => 19.99,
                'descripcion' => 'Gorra de calidad premium con bordado personalizado del logo de tu empresa. Ideal para uniformes corporativos o promocionales.',
                'color' => 'negro,blanco,azul marino',
                'talla' => 'Único',
                'reviews' => 4,
                'linkfacebook' => 'https://facebook.com/sinlimite',
                'imagen' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=400&h=400&fit=crop'
            ],
            
            // Serigrafía
            [
                'nombre' => 'Playera Serigrafiada Diseño Creativo',
                'categoria' => 'Serigrafía',
                'precio' => 24.99,
                'descripcion' => 'Playera con impresión serigráfica de alta calidad. Diseños vibrantes y duraderos, perfectos para eventos, bandas o promociones.',
                'color' => 'negro,blanco,gris',
                'talla' => 'S,M,L,XL,XXL',
                'reviews' => 5,
                'linkfacebook' => 'https://facebook.com/sinlimite',
                'imagen' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=400&h=400&fit=crop'
            ],
            [
                'nombre' => 'Bolsa Eco Serigrafiada',
                'categoria' => 'Serigrafía',
                'precio' => 12.99,
                'descripcion' => 'Bolsa ecológica de tela con serigrafía personalizada. Resistente y reutilizable, ideal para promocionar tu marca de manera sostenible.',
                'color' => 'beige,verde,azul',
                'talla' => 'Único',
                'reviews' => 4,
                'linkfacebook' => 'https://facebook.com/sinlimite',
                'imagen' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=400&fit=crop'
            ],

            // Personalizados
            [
                'nombre' => 'Sudadera Personalizada Nombre',
                'categoria' => 'Personalizados',
                'precio' => 49.99,
                'descripcion' => 'Sudadera con capucha totalmente personalizable. Añade nombres, números, frases o diseños únicos. Calidad premium y comodidad garantizada.',
                'color' => 'gris,negro,azul marino',
                'talla' => 'S,M,L,XL,XXL',
                'reviews' => 5,
                'linkfacebook' => 'https://facebook.com/sinlimite',
                'imagen' => 'https://images.unsplash.com/photo-1556821840-3a9fac4de423?w=400&h=400&fit=crop'
            ],
            [
                'nombre' => 'Jersey Deportivo Personalizado',
                'categoria' => 'Personalizados',
                'precio' => 89.99,
                'descripcion' => 'Jersey deportivo totalmente personalizable para equipos. Incluye nombre, número y logo del equipo. Material técnico transpirable.',
                'color' => 'rojo,azul,verde,amarillo',
                'talla' => 'S,M,L,XL',
                'reviews' => 5,
                'linkfacebook' => 'https://facebook.com/sinlimite',
                'imagen' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=400&fit=crop'
            ],

            // Sublimación
            [
                'nombre' => 'Taza Sublimada Foto Personal',
                'categoria' => 'Sublimación',
                'precio' => 14.99,
                'descripcion' => 'Taza de cerámica con sublimación de alta definición. Imprime tu foto favorita, logo o diseño con colores vibrantes y durabilidad garantizada.',
                'color' => 'blanco,negro',
                'talla' => '11oz,15oz',
                'reviews' => 4,
                'linkfacebook' => 'https://facebook.com/sinlimite',
                'imagen' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=400&h=400&fit=crop'
            ],
            [
                'nombre' => 'Playera Sublimada Full Color',
                'categoria' => 'Sublimación',
                'precio' => 34.99,
                'descripcion' => 'Playera con sublimación total a color. Impresión de alta definición que cubre toda la prenda. Ideal para diseños complejos y fotografías.',
                'color' => 'blanco base',
                'talla' => 'S,M,L,XL',
                'reviews' => 5,
                'linkfacebook' => 'https://facebook.com/sinlimite',
                'imagen' => 'https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=400&h=400&fit=crop'
            ],

            // Promocionales
            [
                'nombre' => 'Kit Promocional Empresa',
                'categoria' => 'Promocionales',
                'precio' => 39.99,
                'descripcion' => 'Kit promocional completo con taza, bolígrafo, llavero y libreta. Todo personalizado con el logo de tu empresa. Perfecto para eventos corporativos.',
                'color' => 'azul corporativo,rojo,negro',
                'talla' => 'Kit completo',
                'reviews' => 4,
                'linkfacebook' => 'https://facebook.com/sinlimite',
                'imagen' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=400&fit=crop'
            ],
            [
                'nombre' => 'USB Personalizado Metal',
                'categoria' => 'Promocionales',
                'precio' => 24.99,
                'descripcion' => 'USB de metal con grabado láser personalizado. Capacidad de 16GB, diseño elegante y duradero. Ideal para regalos corporativos premium.',
                'color' => 'plateado,dorado,negro',
                'talla' => '16GB,32GB',
                'reviews' => 5,
                'linkfacebook' => 'https://facebook.com/sinlimite',
                'imagen' => 'https://images.unsplash.com/photo-1515169067868-5387ec356754?w=400&h=400&fit=crop'
            ],

            // Regalos personalizados
            [
                'nombre' => 'Marco Foto Grabado Personalizado',
                'categoria' => 'Regalos personalizados',
                'precio' => 29.99,
                'descripcion' => 'Marco para fotos de madera con grabado láser personalizado. Perfecto para bodas, aniversarios o regalos especiales. Incluye mensaje personalizado.',
                'color' => 'madera natural,negro,blanco',
                'talla' => '10x15cm,15x20cm',
                'reviews' => 5,
                'linkfacebook' => 'https://facebook.com/sinlimite',
                'imagen' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=400&fit=crop'
            ],
            [
                'nombre' => 'Almohada Personalizada Foto',
                'categoria' => 'Regalos personalizados',
                'precio' => 19.99,
                'descripcion' => 'Almohada suave con impresión personalizada de tu foto favorita. Regalo perfecto para parejas, familias o mascotas. Funda lavable incluida.',
                'color' => 'blanco base',
                'talla' => '40x40cm,50x50cm',
                'reviews' => 4,
                'linkfacebook' => 'https://facebook.com/sinlimite',
                'imagen' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=400&fit=crop'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
