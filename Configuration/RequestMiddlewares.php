<?php

use Accesstive\Accesstive\Middleware\AccesstiveScriptMiddleware;

return [
    'frontend' => [
        'accesstive/script-injection' => [
            'target' => AccesstiveScriptMiddleware::class,
            'after' => [
                'typo3/cms-frontend/tsfe',
            ]
        ],
    ],
]; 