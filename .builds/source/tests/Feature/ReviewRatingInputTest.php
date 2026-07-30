<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReviewRatingInputTest extends TestCase
{
    public function test_it_renders_rating_inputs_in_ascending_order(): void
    {
        $createView = file_get_contents(resource_path('views/reviews/create.blade.php'));
        $editView = file_get_contents(resource_path('views/reviews/edit.blade.php'));

        $this->assertStringContainsString('@for ($i = 1; $i <= 5; $i++)', $createView);
        $this->assertStringContainsString('@for($i = 1; $i <= 5; $i++)', $editView);
    }
}
