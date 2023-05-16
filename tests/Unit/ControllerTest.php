<?php

namespace Tests\Unit;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    /**
     * Test best-days-to-work required fields and response.
     */
    public function testBestDaysToWorkRequired(): void
    {
        $this->json('GET', 'api/best-days-to-work', ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['message', 'errors']);
    }

    public function testBestDaysToWorkSuccess(): void
    {
        $this->json('GET', 'api/best-days-to-work?year=2023&hours=32', ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonIsArray();
    }
}
