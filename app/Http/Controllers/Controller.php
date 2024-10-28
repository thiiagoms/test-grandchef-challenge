<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'AiQFome GrandChef API System Documentation',
    description: 'API Documentation for GrandChef system',
    contact: new OA\Contact(name: 'Thiago', email: 'thiiagoms@proton.me'),
    license: new OA\License(
        name: 'Apache 2.0',
        url: 'http://www.apache.org/licenses/LICENSE-2.0.html'
    )
)]
abstract class Controller {}
