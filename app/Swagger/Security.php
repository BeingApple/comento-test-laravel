<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\SecurityScheme(
 *     type="http",
 *     in="header",
 *     securityScheme="bearer-key",
 *     scheme="bearer",
 *     name="bearer-key",
 *     bearerFormat="JWT",
 * )
 */
class Security
{
}