<?php

class QuestaoUsuarioProva extends TRecord
{
    const TABLENAME  = 'questao_usuario_prova';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $questao;
    private $usuario_prova;

    use SystemChangeLogTrait;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('questao_id');
        parent::addAttribute('usuario_prova_id');
        parent::addAttribute('resposta_usuario');
        parent::addAttribute('peso');
        parent::addAttribute('dt_registro');
            
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
    /**
     * Method set_usuario_prova
     * Sample of usage: $var->usuario_prova = $object;
     * @param $object Instance of UsuarioProva
     */
    public function set_usuario_prova(UsuarioProva $object)
    {
        $this->usuario_prova = $object;
        $this->usuario_prova_id = $object->id;
    }

    /**
     * Method get_usuario_prova
     * Sample of usage: $var->usuario_prova->attribute;
     * @returns UsuarioProva instance
     */
    public function get_usuario_prova()
    {
    
        // loads the associated object
        if (empty($this->usuario_prova))
            $this->usuario_prova = new UsuarioProva($this->usuario_prova_id);
    
        // returns the associated object
        return $this->usuario_prova;
    }

    /**
     * Method getAlternativaRespostaQuestaos
     */
    public function getAlternativaRespostaQuestaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('questao_usuario_prova_id', '=', $this->id));
        return AlternativaRespostaQuestao::getObjects( $criteria );
    }

    public function set_alternativa_resposta_questao_alternativa_to_string($alternativa_resposta_questao_alternativa_to_string)
    {
        if(is_array($alternativa_resposta_questao_alternativa_to_string))
        {
            $values = Alternativa::where('id', 'in', $alternativa_resposta_questao_alternativa_to_string)->getIndexedArray('id', 'id');
            $this->alternativa_resposta_questao_alternativa_to_string = implode(', ', $values);
        }
        else
        {
            $this->alternativa_resposta_questao_alternativa_to_string = $alternativa_resposta_questao_alternativa_to_string;
        }
    }

    public function get_alternativa_resposta_questao_alternativa_to_string()
    {
        if(!empty($this->alternativa_resposta_questao_alternativa_to_string))
        {
            return $this->alternativa_resposta_questao_alternativa_to_string;
        }
    
        $values = AlternativaRespostaQuestao::where('questao_usuario_prova_id', '=', $this->id)->getIndexedArray('alternativa_id','{alternativa->id}');
        return implode(', ', $values);
    }

    public function set_alternativa_resposta_questao_questao_usuario_prova_to_string($alternativa_resposta_questao_questao_usuario_prova_to_string)
    {
        if(is_array($alternativa_resposta_questao_questao_usuario_prova_to_string))
        {
            $values = QuestaoUsuarioProva::where('id', 'in', $alternativa_resposta_questao_questao_usuario_prova_to_string)->getIndexedArray('id', 'id');
            $this->alternativa_resposta_questao_questao_usuario_prova_to_string = implode(', ', $values);
        }
        else
        {
            $this->alternativa_resposta_questao_questao_usuario_prova_to_string = $alternativa_resposta_questao_questao_usuario_prova_to_string;
        }
    }

    public function get_alternativa_resposta_questao_questao_usuario_prova_to_string()
    {
        if(!empty($this->alternativa_resposta_questao_questao_usuario_prova_to_string))
        {
            return $this->alternativa_resposta_questao_questao_usuario_prova_to_string;
        }
    
        $values = AlternativaRespostaQuestao::where('questao_usuario_prova_id', '=', $this->id)->getIndexedArray('questao_usuario_prova_id','{questao_usuario_prova->id}');
        return implode(', ', $values);
    }

    
}

