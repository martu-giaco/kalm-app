<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * Mercado Pago llama a este endpoint server-to-server (sin sesión ni
     * token CSRF de Laravel)
     *
     * @var array<int, string>
     */
    protected $except = [
        'premium/webhook',
    ];
}