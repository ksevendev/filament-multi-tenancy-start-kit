<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Password Reset Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */

    'reset'     => 'Sua senha foi redefinida!',
    'sent'      => 'Enviamos um link para redefinir sua senha!',
    'throttled' => 'Aguarde antes de tentar novamente.',
    'token'     => 'Este token de redefinição de senha é inválido.',
    'user'      => 'Não encontramos um usuário com este endereço de e-mail.',
    'password'  => 'As senhas devem ter pelo menos seis caracteres e corresponder à confirmação.',
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_resets',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],
    'password_timeout'                               => 10800,
    'email'                                          => 'E-mail',
    'password'                                       => 'Senha',
    'remember_me'                                    => 'Lembrar-me',
    'forgot_your_password'                           => 'Esqueceu sua senha?',
    'reset_password'                                 => 'Redefinir senha',
    'send_password_reset_link'                       => 'Enviar link de redefinição de senha',
    'confirm_password'                               => 'Confirmar senha',
    'please_confirm_your_password_before_continuing' => 'Por favor, confirme sua senha antes de continuar.',
    'change_password'                                => 'Alterar senha',
    'current_password'                               => 'Senha atual',
    'new_password'                                   => 'Nova senha',
    'new_password_confirmation'                      => 'Confirmação de nova senha',
    'update_password'                                => 'Atualizar senha',
    'verify_email'                                   => 'Verifique seu endereço de e-mail',
    'verification_link_sent'                         => 'Um novo link de verificação foi enviado para o endereço de e-mail fornecido durante o registro.',
    'check_your_email'                               => 'Antes de prosseguir, verifique seu e-mail para obter um link de verificação.',
    'if_you_did_not_receive_the_email'               => 'Se você não recebeu o e-mail',
    'click_here_to_request_another'                  => 'clique aqui para solicitar outro',
    'register'                                       => 'Registrar',

];
