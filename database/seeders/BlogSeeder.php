<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [

            // ---------------------------
            // SKINCARE
            // ---------------------------
            [
                'title' => 'Rutina completa para piel grasa',
                'author' => 'Laura Fernández',
                'credentials' => 'Dermatóloga general',
                'image' => 'images/blogs/greasy.jpg',
                'content' => "La piel grasa requiere un enfoque equilibrado que controle el exceso de sebo sin comprometer la hidratación natural de la piel.

Una rutina efectiva comienza con un limpiador suave con ácido salicílico para eliminar impurezas y reducir poros obstruidos. Luego, es fundamental aplicar un tónico equilibrante que ayude a restaurar el pH de la piel.

El uso de un serum con niacinamida puede ayudar a regular la producción de grasa, mientras que una crema hidratante ligera es esencial para evitar el efecto rebote.

Por último, el protector solar oil-free es obligatorio para prevenir daños solares sin aportar brillo adicional.

**Recomendación profesional:** evitar productos agresivos que resequen demasiado la piel, ya que esto puede aumentar la producción de sebo.",
                'description' => 'Rutina ideal para controlar piel grasa sin resecar.',
                'type_id' => 1,
                'tags' => [1, 3, 4],
                'is_premium' => false,
            ],

            [
                'title' => 'Cómo armar una rutina nocturna efectiva',
                'author' => 'Sofía Ramírez',
                'credentials' => 'Cosmetóloga',
                'image' => 'images/blogs/night-routine.jpg',
                'content' => "La rutina nocturna es clave para la regeneración de la piel. Durante la noche, el proceso de renovación celular está en su punto máximo.

Se recomienda comenzar con una doble limpieza: primero un limpiador oleoso para remover maquillaje y luego uno acuoso para limpiar profundamente.

Después, se pueden incorporar activos como retinol o ácidos exfoliantes, siempre de forma gradual para evitar irritaciones.

Finalizar con una crema nutritiva ayuda a sellar la hidratación y potenciar la reparación cutánea.

**Consejo clave:** la constancia es más importante que la cantidad de productos.",
                'description' => 'Guía para aprovechar al máximo tu rutina nocturna.',
                'type_id' => 1,
                'tags' => [1, 4],
                'is_premium' => false,
            ],

            [
                'title' => 'Ingredientes clave para una piel saludable',
                'author' => 'Dr. Martín Vega',
                'credentials' => 'Dermatólogo',
                'image' => 'images/blogs/ingredients.jpg',
                'content' => "Entender los ingredientes es fundamental para elegir productos adecuados.

La vitamina C es un antioxidante potente que ilumina la piel y combate los radicales libres. El ácido hialurónico hidrata profundamente, mientras que la niacinamida ayuda a reducir inflamación y manchas.

Los retinoides son esenciales para tratar signos de envejecimiento, pero deben usarse con precaución.

**Recomendación:** siempre introducir nuevos activos de forma progresiva.",
                'description' => 'Los activos más importantes en skincare.',
                'type_id' => 1,
                'tags' => [3, 4],
                'is_premium' => true,
            ],

            // ---------------------------
            // HAIRCARE
            // ---------------------------
            [
                'title' => 'Rutina completa para cabello seco',
                'author' => 'Carlos Méndez',
                'credentials' => 'Estilista profesional',
                'image' => 'images/blogs/dry-hair.jpg',
                'content' => "El cabello seco necesita hidratación profunda y constancia.

Es recomendable utilizar un shampoo sin sulfatos agresivos, seguido de un acondicionador nutritivo. Las mascarillas deben aplicarse al menos dos veces por semana.

El uso de aceites como argán o coco ayuda a sellar la hidratación y aportar brillo.

**Tip profesional:** evitar herramientas de calor excesivo.",
                'description' => 'Cómo hidratar el cabello seco correctamente.',
                'type_id' => 2,
                'tags' => [1, 3],
                'is_premium' => false,
            ],

            [
                'title' => 'Cómo evitar el frizz en climas húmedos',
                'author' => 'Valentina López',
                'credentials' => 'Tricóloga',
                'image' => 'images/blogs/frizz.jpg',
                'content' => "El frizz es uno de los problemas más comunes en ambientes húmedos.

La clave está en mantener el cabello bien hidratado y utilizar productos anti-frizz que creen una barrera protectora.

Evitar peinar el cabello en seco y utilizar toallas de microfibra puede marcar una gran diferencia.

**Recomendación:** incorporar leave-in conditioners.",
                'description' => 'Control del frizz en ambientes húmedos.',
                'type_id' => 2,
                'tags' => [1],
                'is_premium' => false,
            ],

            [
                'title' => 'Caída del cabello: causas y soluciones',
                'author' => 'Dra. Valentina López',
                'credentials' => 'Tricóloga certificada',
                'image' => 'images/blogs/hair-loss.jpg',
                'content' => "La caída del cabello puede estar relacionada con múltiples factores: estrés, alimentación, genética o cambios hormonales.

Es fundamental identificar la causa para aplicar el tratamiento adecuado.

Suplementos, tratamientos tópicos y cambios en el estilo de vida pueden ayudar significativamente.

**Consejo profesional:** consultar siempre a un especialista.",
                'description' => 'Guía completa sobre caída capilar.',
                'type_id' => 2,
                'tags' => [2, 3],
                'is_premium' => true,
            ],

            // ---------------------------
            // LIFESTYLE / SALUD
            // ---------------------------
            [
                'title' => 'Hábitos diarios para mejorar tu piel',
                'author' => 'Ana Torres',
                'credentials' => 'Nutricionista',
                'image' => 'images/blogs/skin-habits.jpg',
                'content' => "La salud de la piel no depende solo de los productos, sino también de los hábitos diarios.

Dormir bien, mantenerse hidratado y llevar una dieta balanceada son factores clave.

El estrés también impacta directamente en la piel, generando brotes y sensibilidad.

**Recomendación:** adoptar hábitos sostenibles en el tiempo.",
                'description' => 'Hábitos que impactan en tu piel.',
                'type_id' => 3,
                'tags' => [1, 2],
                'is_premium' => false,
            ],

            [
                'title' => 'Relación entre estrés y salud de la piel',
                'author' => 'Dr. Pablo Ruiz',
                'credentials' => 'Psicólogo',
                'image' => 'images/blogs/stress-skin.jpg',
                'content' => "El estrés tiene un impacto directo en la piel, afectando condiciones como acné, psoriasis y dermatitis.

El cortisol elevado puede alterar la barrera cutánea y aumentar la inflamación.

Practicar técnicas de relajación como mindfulness o ejercicio puede mejorar notablemente la piel.

**Clave:** cuidar la salud mental también es cuidar la piel.",
                'description' => 'Cómo el estrés afecta tu piel.',
                'type_id' => 3,
                'tags' => [2, 3],
                'is_premium' => true,
            ],
        ];

        foreach ($blogs as $data) {

            $blog = Blog::create([
                'title' => $data['title'],
                'image' => $data['image'],
                'author' => $data['author'],
                'credentials' => $data['credentials'],
                'content' => $data['content'],
                'description' => $data['description'],
                'type_id' => $data['type_id'],
                'is_premium' => $data['is_premium'],
            ]);

            $blog->tags()->sync($data['tags']);
        }
    }
}
