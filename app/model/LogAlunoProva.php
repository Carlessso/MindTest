<?php

class LogAlunoProva extends TRecord
{
    const TABLENAME  = 'log_aluno_prova';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    use SystemChangeLogTrait;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
        parent::addAttribute('usuario_id');
        parent::addAttribute('data_operacao');
        parent::addAttribute('prova_id');
    }

}

