<?php

// Here are our configurable values which also import values from ENV variables
return [
    'deploy' => env('DEPLOY', 'local'),
    'debug' => env('DEBUG', true),
];