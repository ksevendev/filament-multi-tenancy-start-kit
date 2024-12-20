<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Table Header
    |--------------------------------------------------------------------------
    */

    'table.heading' => 'Histórico de operações',

    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.user_name'  => 'Usuário',
    'column.event'      => 'Evento',
    'column.created_at' => 'Criado em',
    'column.old_values' => 'De',
    'column.new_values' => 'Para',
    'column.changes'    => 'Alterações',
    'column.ip_address' => 'IP',

    /*
    |--------------------------------------------------------------------------
    | Table Actions
    |--------------------------------------------------------------------------
    */

    'action.restore' => 'Restaurar',

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    'notification.restored'  => 'Restaurado com sucesso',
    'notification.unchanged' => 'Nenhuma alteração foi feita',

    'events' => [
        'created'  => 'Criado',
        'updated'  => 'Atualizado',
        'deleted'  => 'Deletado',
        'restored' => 'Restaurado',
    ],

];
