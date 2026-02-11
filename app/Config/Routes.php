<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/ocr', 'OcrController::index');
$routes->post('/ocr/upload', 'OcrController::upload');
$routes->get('/ocr/result/(:num)', 'OcrController::result/$1');

