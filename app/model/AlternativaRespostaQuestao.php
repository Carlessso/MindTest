<?php

class AlternativaRespostaQuestao extends TRecord
{
    const TABLENAME  = 'alternativa_resposta_questao';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $alternativa;
    private $questao_usuario_prova;

    use SystemChangeLogTrait;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('alternativa_id');
        parent::addAttribute('questao_usuario_prova_id');
            
    }

    /**
     * Method set_alternativa
     * Sample of usage: $var->alternativa = $object;
     * @param $object Instance of Alternativa
     */
    public function set_alternativa(Alternativa $object)
    {
        $this->alternativa = $object;
        $this->alternativa_id = $object->id;
    }

    /**
     * Method get_alternativa
     * Sample of usage: $var->alternativa->attribute;
     * @returns Alternativa instance
     */
    public function get_alternativa()
    {
    
        // loads the associated object
        if (empty($this->alternativa))
            $this->alternativa = new Alternativa($this->alternativa_id);
    
        // returns the associated object
        return $this->alternativa;
    }
    /**
     * Method set_questao_usuario_prova
     * Sample of usage: $var->questao_usuario_prova = $object;
     * @param $object Instance of QuestaoUsuarioProva
     */
    public function set_questao_usuario_prova(QuestaoUsuarioProva $object)
    {
        $this->questao_usuario_prova = $object;
        $this->questao_usuario_prova_id = $object->id;
    }

    /**
     * Method get_questao_usuario_prova
     * Sample of usage: $var->questao_usuario_prova->attribute;
     * @returns QuestaoUsuarioProva instance
     */
    public function get_questao_usuario_prova()
    {
    
        // loads the associated object
        if (empty($this->questao_usuario_prova))
            $this->questao_usuario_prova = new QuestaoUsuarioProva($this->questao_usuario_prova_id);
    
        // returns the associated object
        return $this->questao_usuario_prova;
    }

    
}

