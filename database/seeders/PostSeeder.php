<?php

namespace Database\Seeders;

use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = json_decode(file_get_contents(database_path('seeders/data/posts.json')), true);

        foreach ($posts as $postData) {
            // Crear post
            $post = Post::create([
                'id' => $postData['id'],
                'titulo' => $postData['titulo'],
                'descripcion' => $postData['descripcion'],
                'imagen' => $postData['imagen'], // Guardar como uuid.jpg
                'user_id' => $postData['user_id'],
            ]);

            // Insertar comentarios
            if (!empty($postData['comentarios'])) {
                foreach ($postData['comentarios'] as $comentarioData) {
                    Comentario::create([
                        'post_id' => $post->id,
                        'user_id' => $comentarioData['user_id'],
                        'comentario' => $comentarioData['comentario'],
                    ]);
                }
            }
        }
    }
}
