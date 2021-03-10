<?php

class Resposta extends TRecord
{
    const TABLENAME  = 'resposta';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $questao;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('questao_id');
        parent::addAttribute('resposta');
            
    }

    /**
     * Method set_questao
     * Sample of usage: $var->questao = $object;
     * @param $object Instance of Questao
     */
    public function set_questao(Questao $object)
    {
        $this->questao = $object;
        $this->questao_id = $object->id;
    }

    /**
     * Method get_questao
     * Sample of usage: $var->questao->attribute;
     * @returns Questao instance
     */
    public function get_questao()
    {
    
        // loads the associated object
        if (empty($this->questao))
            $this->questao = new Questao($this->questao_id);
    
        // returns the associated object
        return $this->questao;
    }

    
}

