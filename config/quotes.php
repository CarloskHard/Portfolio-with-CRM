<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Versiones públicas de presupuesto
    |--------------------------------------------------------------------------
    |
    | Cada entrada se publica en /presupuesto/{slug}
    | Ejemplo: /presupuesto/cliente-acme
    |
    */
    'versions' => [
        'general' => [
            'title' => 'Propuesta de desarrollo web',
            'client_name' => 'Cliente potencial',
            'updated_at' => '2026-05-06',
            'currency' => 'EUR',
            'notes' => [
                'Precios orientativos, sujetos a alcance final.',
                '50% al inicio y 50% a la entrega.',
                'Incluye soporte correctivo durante 30 dias.',
            ],
            'items' => [
                [
                    'name' => 'Landing page profesional',
                    'description' => 'Diseno responsive, formulario de contacto y SEO tecnico basico.',
                    'price' => 650,
                ],
                [
                    'name' => 'Panel administrable',
                    'description' => 'CRUD para gestionar contenido y textos sin tocar codigo.',
                    'price' => 1100,
                ],
                [
                    'name' => 'Integracion de analitica',
                    'description' => 'Eventos clave, conversiones y dashboard de seguimiento.',
                    'price' => 250,
                ],
            ],
        ],
    ],
];
