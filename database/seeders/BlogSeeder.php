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
                'content' => <<<MD
Después de una jornada cargada de ritmo y pantallas, con mil pensamientos cruzando la mente y la piel pidiendo una pausa, lo último que apetece es enfrentarse a una rutina facial interminable. A veces solo quieres soltarlo todo, recogerte el pelo, enfundarte en tu pijama favorito y dejar que el día se derrita lentamente.

La verdadera belleza está en la calma. No hace falta una rutina complicada para cuidarte; lo importante es el momento, no los pasos. Por eso, te invitamos a apostar por rituales nocturnos sencillos, efectivos y sensoriales: productos que nutren sin abrumar, texturas que invitan al descanso y ese gesto final que marca el mejor cierre posible —un sueño reparador.

¿No sabes por dónde empezar? Para eso estamos: esta es la rutina de noche ideal para mimar tu piel y terminar el día como se merece.

## Por qué cuidar tu piel por la noche importa

Es simple: mientras duermes, la piel activa de forma natural su proceso de reparación para revertir el daño acumulado durante el día. Ahora imagina potenciar ese mecanismo con los ingredientes perfectos para nutrirla y regenerarla. Además, durante la noche tu piel es más receptiva a los productos tópicos, ya que su barrera es más permeable y la absorción mejora.

### Pero… ¿cuándo?
A menudo pensamos que la rutina de noche empieza justo antes de dormir, pero no tiene por qué ser así. ¿Quién no ha sentido alguna vez que las horas se escapan justo antes de apagar la luz? Tu rutina nocturna puede empezar tan pronto como la noche comienza.

El regulador del ciclo sueño-vigilia, la melatonina, se libera al caer la tarde, activando el modo descanso y reparación de la piel. Esto significa que puedes disfrutar de tu ritual de skincare nocturno en cualquier momento después del atardecer: al salir de la ducha, después de entrenar o al volver de un café con amigas. Escoge tu momento favorito y disfrútalo.

## Ingredientes clave para una rutina nocturna de skincare

### Melatonina
La melatonina es un potente antioxidante que estimula las defensas naturales de la piel mientras duermes. Ayuda a combatir los radicales libres y favorece la reparación del daño oxidativo.

Incluir melatonina en tu rutina nocturna potencia la regeneración y mejora la luminosidad al despertar.

## Retinal
Tres veces más potente que el retinol, este ingrediente antiaging estimula la renovación de la piel para redefinir su textura y minimizar las arrugas. Aunque no es tan conocido como su amigo el retinol, el retinal se convierte en su forma activa más rápido, lo que hace que el camino hacia una piel rejuvenecida vaya en la dirección correcta.

Bakuchiol
De origen vegetal y con una larga historia en la medicina tradicional oriental, el bakuchiol se ha ganado un lugar destacado en la cosmética moderna por sus propiedades rejuvenecedoras.

Apto para todo tipo de pieles, incluso las más sensibles, este compuesto ayuda a mejorar la firmeza, suavizar la textura y reducir la apariencia de líneas de expresión. Un aliado perfecto para quienes buscan una alternativa 100% de origen natural del retinol.

La rutina de noche perfecta para levantarse con buena cara
MD,
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
