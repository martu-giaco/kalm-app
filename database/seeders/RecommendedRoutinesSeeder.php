<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RecommendedRoutine;
use App\Models\Product;
use App\Models\ProductCategory;

class RecommendedRoutinesSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar rutinas recomendadas existentes
        RecommendedRoutine::truncate();

        // ============================================
        // RUTINAS PARA PIEL (piel)
        // ============================================

        // PIEL SECA
        RecommendedRoutine::create([
            'test_key' => 'piel',
            'result_key' => 'seco',
            'name' => 'Rutina para piel Seca',
            'description' => 'Una rutina diseñada específicamente para mantener tu piel hidratada y protegida',
            'frequency' => 'diaria',
            'time_of_day' => 'Mañana y Noche',
            'steps' => json_encode([
                'Paso 1: Limpieza → Remueve suciedad dejando la piel lista para absorber los productos',
                'Paso 2: Tratamiento → Aporta activos concentrados que hidratan en profundidad',
                'Paso 3: Hidratante → Mantiene la humedad y refuerza la barrera natural',
                'Paso 4: Protección → Sella la humedad y protege contra agentes externos (solo día)',
            ]),
            'products' => json_encode($this->getProductsByCategories(['Limpiadores', 'Hidratantes', 'Sérums', 'Protectores Solares'])),
        ]);

        // PIEL GRASA
        RecommendedRoutine::create([
            'test_key' => 'piel',
            'result_key' => 'graso',
            'name' => 'Rutina para piel Grasa',
            'description' => 'Una rutina para controlar el exceso de sebo y mantener tu piel balanceada',
            'frequency' => 'diaria',
            'time_of_day' => 'Mañana y Noche',
            'steps' => json_encode([
                'Paso 1: Limpieza → Remueve suciedad y exceso de grasa profundamente',
                'Paso 2: Exfoliación → Elimina células muertas (2-3 veces a la semana)',
                'Paso 3: Tratamiento → Activos que regulan la producción de sebo',
                'Paso 4: Hidratante ligera → Hidratación sin añadir más grasa',
            ]),
            'products' => json_encode($this->getProductsByCategories(['Limpiadores', 'Exfoliantes', 'Sérums', 'Protectores Solares'])),
        ]);

        // PIEL MIXTA
        RecommendedRoutine::create([
            'test_key' => 'piel',
            'result_key' => 'mixto',
            'name' => 'Rutina para piel Mixta',
            'description' => 'Una rutina equilibrada para zonas grasas y secas',
            'frequency' => 'diaria',
            'time_of_day' => 'Mañana y Noche',
            'steps' => json_encode([
                'Paso 1: Limpieza → Limpia sin resecar las zonas secas',
                'Paso 2: Tratamiento → Activos adaptados para equilibrar ambas zonas',
                'Paso 3: Hidratante → Hidratación equilibrada',
                'Paso 4: Protección → Protege sin dejar residuo pesado',
            ]),
            'products' => json_encode($this->getProductsByCategories(['Limpiadores', 'Hidratantes', 'Sérums', 'Protectores Solares'])),
        ]);

        // PIEL NORMAL
        RecommendedRoutine::create([
            'test_key' => 'piel',
            'result_key' => 'normal',
            'name' => 'Rutina para piel Normal',
            'description' => 'Una rutina de mantenimiento para mantener tu piel saludable',
            'frequency' => 'diaria',
            'time_of_day' => 'Mañana y Noche',
            'steps' => json_encode([
                'Paso 1: Limpieza → Remueve suciedad suavemente',
                'Paso 2: Tratamiento → Activos preventivos y revitalizantes',
                'Paso 3: Hidratante → Mantén la hidratación natural de tu piel',
                'Paso 4: Protección → Protege contra rayos UV (solo día)',
            ]),
            'products' => json_encode($this->getProductsByCategories(['Limpiadores', 'Hidratantes', 'Sérums', 'Protectores Solares'])),
        ]);

        // PIEL SENSIBLE
        RecommendedRoutine::create([
            'test_key' => 'piel',
            'result_key' => 'sensible',
            'name' => 'Rutina para piel Sensible',
            'description' => 'Una rutina suave con productos hipoalergénicos',
            'frequency' => 'diaria',
            'time_of_day' => 'Mañana y Noche',
            'steps' => json_encode([
                'Paso 1: Limpieza → Limpiador suave sin irritantes',
                'Paso 2: Tónico → Calma e hidrata sin alcohol',
                'Paso 3: Serum → Activos calmantes y protectores',
                'Paso 4: Humectante → Hidratación sin irritantes',
            ]),
            'products' => json_encode($this->getProductsByCategories(['Limpiadores', 'Hidratantes', 'Sérums'])),
        ]);

        // ============================================
        // RUTINAS PARA CABELLO (cabello)
        // ============================================

        // CABELLO SECO
        RecommendedRoutine::create([
            'test_key' => 'cabello',
            'result_key' => 'seco',
            'name' => 'Rutina para cabello Seco',
            'description' => 'Una rutina para restaurar la hidratación y el brillo de tu cabello',
            'frequency' => 'diaria',
            'time_of_day' => 'lavado',
            'steps' => json_encode([
                'Paso 1: Lavado → Champú suave e hidratante',
                'Paso 2: Acondicionado → Acondicionador profundo',
                'Paso 3: Tratamiento → Mascarilla o serum semanal',
            ]),
            'products' => json_encode($this->getProductsByCategories(['Shampoo', 'Acondicionador', 'Tratamientos'])),
        ]);

        // CABELLO GRASO
        RecommendedRoutine::create([
            'test_key' => 'cabello',
            'result_key' => 'graso',
            'name' => 'Rutina para cabello Graso',
            'description' => 'Una rutina para controlar el exceso de grasa',
            'frequency' => 'diaria',
            'time_of_day' => 'lavado',
            'steps' => json_encode([
                'Paso 1: Lavado → Champú específico para cabello graso',
                'Paso 2: Acondicionado → Acondicionador ligero solo en puntas',
                'Paso 3: Tratamiento → Exfoliante de cuero cabelludo semanal',
            ]),
            'products' => json_encode($this->getProductsByCategories(['Shampoo', 'Acondicionador'])),
        ]);

        // CABELLO NORMAL
        RecommendedRoutine::create([
            'test_key' => 'cabello',
            'result_key' => 'normal',
            'name' => 'Rutina para cabello Normal',
            'description' => 'Una rutina de mantenimiento para tu cabello',
            'frequency' => 'diaria',
            'time_of_day' => 'lavado',
            'steps' => json_encode([
                'Paso 1: Lavado → Champú suave y nutritivo',
                'Paso 2: Acondicionado → Acondicionador equilibrado',
                'Paso 3: Tratamiento → Mascarilla nutritiva semanal',
            ]),
            'products' => json_encode($this->getProductsByCategories(['Shampoo', 'Acondicionador', 'Tratamientos'])),
        ]);

        // CABELLO MIXTO
        RecommendedRoutine::create([
            'test_key' => 'cabello',
            'result_key' => 'mixto',
            'name' => 'Rutina para cabello Mixto',
            'description' => 'Una rutina para equilibrar raíces grasas y puntas secas',
            'frequency' => 'diaria',
            'time_of_day' => 'lavado',
            'steps' => json_encode([
                'Paso 1: Lavado → Champú equilibrado',
                'Paso 2: Acondicionado → En puntas solamente',
                'Paso 3: Tratamiento → Mascarilla estratégica',
            ]),
            'products' => json_encode($this->getProductsByCategories(['Shampoo', 'Acondicionador'])),
        ]);

        // CABELLO SENSIBLE
        RecommendedRoutine::create([
            'test_key' => 'cabello',
            'result_key' => 'sensible',
            'name' => 'Rutina para cabello Sensible',
            'description' => 'Una rutina suave para cuidar tu cuero cabelludo sensible',
            'frequency' => 'diaria',
            'time_of_day' => 'lavado',
            'steps' => json_encode([
                'Paso 1: Lavado → Champú hipoalergénico sin sulfatos',
                'Paso 2: Acondicionado → Acondicionador suave',
                'Paso 3: Cuidado → Tonificante calmante semanal',
            ]),
            'products' => json_encode($this->getProductsByCategories(['Shampoo', 'Acondicionador'])),
        ]);

        echo "\n✅ Rutinas recomendadas creadas exitosamente!\n";
    }

    /**
     * Obtiene IDs de productos por categorías
     */
    private function getProductsByCategories(array $categoryNames): array
    {
        $productIds = [];

        foreach ($categoryNames as $categoryName) {
            $category = ProductCategory::where('name', $categoryName)->first();

            if ($category) {
                $products = Product::where('category_id', $category->id)
                    ->limit(2) // Máximo 2 productos por categoría
                    ->pluck('id')
                    ->toArray();

                $productIds = array_merge($productIds, $products);
            }
        }

        return $productIds;
    }
}

