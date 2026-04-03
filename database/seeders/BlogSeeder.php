<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------
        // BLOGS GRATUITOS
        // ---------------------------

        $blog1 = Blog::create([
            'title' => 'Rutina básica de limpieza facial',
            'image' => 'https://via.placeholder.com/600x400?text=Skincare+Free+1',
            'author' => 'Laura Fernández',
            'credentials' => 'Dermatóloga general',
            'content' => 'Descubre cómo limpiar tu rostro de manera efectiva en 5 minutos.',
            'description' => 'Una rutina básica para mantener tu piel limpia y saludable.',
            'type_id' => 1,
            'is_premium' => false,
        ]);
        $blog1->tags()->sync([1]);



        $blog2 = Blog::create([
            'title' => 'Tips rápidos para cabello brillante',
            'image' => 'https://via.placeholder.com/600x400?text=Haircare+Free+1',
            'author' => 'Carlos Méndez',
            'credentials' => 'Estilista profesional',
            'content' => 'Aprende cómo darle brillo a tu cabello con productos caseros simples.',
            'description' => 'Consejos para mantener tu cabello saludable y brillante.',
            'type_id' => 2,
            'is_premium' => false,
        ]);
        $blog2->tags()->sync([1]);



        $blog3 = Blog::create([
            'title' => 'Protección solar diaria',
            'image' => 'https://via.placeholder.com/600x400?text=Skincare+Free+2',
            'author' => 'Sofía Ramírez',
            'credentials' => 'Cosmetóloga',
            'content' => 'No olvides aplicar protector solar cada mañana, incluso si estás en interiores.',
            'description' => 'Importancia de la protección solar en tu rutina diaria.',
            'type_id' => 1,
            'is_premium' => false,
        ]);
        $blog3->tags()->sync([1]);



        // ---------------------------
        // BLOGS PREMIUM
        // ---------------------------

        $blog4 = Blog::create([
            'title' => 'Guía completa para una piel saludable',
            'image' => 'https://via.placeholder.com/600x400?text=Skincare+Premium+1',
            'author' => 'Dr. Alejandro Torres',
            'credentials' => 'Dermatólogo certificado',
            'content' => "Mantener una piel saludable requiere una rutina diaria combinando limpieza, hidratación y protección solar.
Se recomienda usar limpiadores suaves por la mañana y noche, aplicar un serum con antioxidantes y finalizar con protector solar de amplio espectro.
**Recomendación oficial de profesionales:** evita productos con alcohol excesivo y realiza exfoliación química una vez por semana para prevenir irritaciones.",
            'description' => 'Una guía completa para mantener tu piel saludable.',
            'type_id' => 1,
            'is_premium' => true,
        ]);
        $blog4->tags()->sync([1, 3]);



        $blog5 = Blog::create([
            'title' => 'Cómo prevenir la caída del cabello',
            'image' => 'https://via.placeholder.com/600x400?text=Haircare+Premium+1',
            'author' => 'Dra. Valentina López',
            'credentials' => 'Tricóloga certificada',
            'content' => "La caída del cabello puede prevenirse con una alimentación rica en proteínas, hierro y biotina.
Es importante utilizar champús suaves, evitar peinados muy apretados y limitar el uso de herramientas de calor.
**Recomendación oficial de profesionales:** consulta a un especialista si notas pérdida excesiva; un tratamiento personalizado puede ser necesario.",
            'description' => 'Consejos para prevenir la caída del cabello.',
            'type_id' => 2,
            'is_premium' => true,
        ]);
        $blog5->tags()->sync([2, 3]);



        $blog6 = Blog::create([
            'title' => 'Rutina antiedad para piel madura',
            'image' => 'https://via.placeholder.com/600x400?text=Skincare+Premium+2',
            'author' => 'Dr. Martín Vega',
            'credentials' => 'Dermatólogo especializado en envejecimiento',
            'content' => "Para piel madura, se recomienda una rutina enfocada en hidratación profunda y estimulación de colágeno.
Incluye limpieza suave, aplicación de retinoides nocturnos y antioxidantes durante el día.
**Recomendación oficial de profesionales:** combina tratamientos tópicos con protección solar diaria.",
            'description' => 'Rutina antiedad para piel madura.',
            'type_id' => 1,
            'is_premium' => true,
        ]);
        $blog6->tags()->sync([1, 3, 4]);



        $blog7 = Blog::create([
            'title' => 'Tratamientos profesionales para cabello seco',
            'image' => 'https://via.placeholder.com/600x400?text=Haircare+Premium+2',
            'author' => 'Carlos Méndez',
            'credentials' => 'Estilista profesional',
            'content' => "El cabello seco requiere nutrición profunda con mascarillas hidratantes y aceites naturales.
Se recomienda aplicar mascarilla 2-3 veces por semana y usar acondicionador diario.
**Recomendación oficial de profesionales:** evita lavados con agua muy caliente.",
            'description' => 'Tratamientos profesionales para cabello seco.',
            'type_id' => 2,
            'is_premium' => true,
        ]);
        $blog7->tags()->sync([1, 3]);
    }
}
