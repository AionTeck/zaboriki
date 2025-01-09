<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OAT;

#[OAT\Info(
    version: '1.0.0',
    title: 'Fences API'
)]
#[OAT\SecurityScheme(
    securityScheme: 'BearerAuth',
    type: 'http',
    scheme: 'bearer'
)]
#[OAT\Server(
    url: '/api/v1',
    description: 'Main API Server'
)]
class BaseController extends Controller
{

}
