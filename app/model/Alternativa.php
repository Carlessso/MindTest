<?php

class Alternativa extends TRecord
{
    const TABLENAME  = 'alternativa';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $questao;

    use SystemChangeLogTrait;


    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('questao_id');
        parent::addAttribute('descricao');
        parent::addAttribute('is_correta');
            
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
     * Method getAlternativaRespostaQuestaos
     */
    public function getAlternativaRespostaQuestaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('alternativa_id', '=', $this->id));
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
    
        $values = AlternativaRespostaQuestao::where('alternativa_id', '=', $this->id)->getIndexedArray('alternativa_id','{alternativa->id}');
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
    
        $values = AlternativaRespostaQuestao::where('alternativa_id', '=', $this->id)->getIndexedArray('questao_usuario_prova_id','{questao_usuario_prova->id}');
        return implode(', ', $values);
    }

    
}

