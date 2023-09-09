<?php

namespace App\Util;

/**
 * Message Class
 */
class Message
{
    public const NOT_EQUAL_PASSWORD = 'As senhas não são iguais';

    public const USER_REGISTER_ERROR = 'O e-mail ou senha informados são inválidos';
    public const USER_REGISTERED = 'Usuário registrado com sucesso';

    public const OBJECTIVE_SAVE_ERROR = 'Ocorreu um problema ao atualizar o objetivo';
    public const OBJECTIVE_SAVED = 'Objetivo salvo com sucesso';
    public const OBJECTIVE_EDITED = 'Objetivo editado com sucesso';
    public const OBJECTIVE_REMOVED = 'Objetivo removido com sucesso';
    public const OBJECTIVE_CONSTRAINT = 'Não é possível remover um objetivo com resultados chave vinculados';

    public const KEY_RESULT_SAVE_ERROR = 'Ocorreu um problema ao atualizar o resultado chave';
    public const KEY_RESULT_SAVED = 'Resultado chave com sucesso';
    public const KEY_RESULT_EDITED = 'Resultado chave editado com sucesso';
    public const KEY_RESULT_REMOVED = 'Resultado chave removido com sucesso';
}