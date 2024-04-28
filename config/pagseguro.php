<?php

/**
 *
 * ATENCAO
 *
 * Adicionar nas notificações do PAGSEGURO o endpoint  {APP_URL}/api/inscricao/atualiza/status
 *
 * Para que os status dos pagamentos sejam atualizados automaticamente.
 *
 */
return [
    'url'           => 'https://ws.pagseguro.uol.com.br/v2', //https://ws.sandbox.pagseguro.uol.com.br/v2
    'email'         => env('PAGSEGURO_EMAIL', ''),
    'token'         => env('PAGSEGURO_TOKEN', ''),
    'redirect_to'   => 'https://andigraf.com.br/premio-jcc/'
];
