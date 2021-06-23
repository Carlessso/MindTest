<?php

class Questao extends TRecord
{
    const TABLENAME  = 'questao';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    private $prova;
    
    use SystemChangeLogTrait;
    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pergunta');
        parent::addAttribute('resposta');
        parent::addAttribute('is_multipla_escolha');
        parent::addAttribute('prova_id');
        parent::addAttribute('minutos_realizacao');
        parent::addAttribute('peso');
        parent::addAttribute('is_obrigatoria');
            
    }

    /**
     * Method set_prova
     * Sample of usage: $var->prova = $object;
     * @param $object Instance of Prova
     */
    public function set_prova(Prova $object)
    {
        $this->prova = $object;
        $this->prova_id = $object->id;
    }

    /**
     * Method get_prova
     * Sample of usage: $var->prova->attribute;
     * @returns Prova instance
     */
    public function get_prova()
    {
    
        // loads the associated object
        if (empty($this->prova))
            $this->prova = new Prova($this->prova_id);
    
        // returns the associated object
        return $this->prova;
    }

    /**
     * Method getRespostas
     */
    public function getRespostas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('questao_id', '=', $this->id));
        return Resposta::getObjects( $criteria );
    }
    /**
     * Method getAlternativas
     */
    public function getAlternativas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('questao_id', '=', $this->id));
        return Alternativa::getObjects( $criteria );
    }
    /**
     * Method getQuestaoUsuarioProvas
     */
    public function getQuestaoUsuarioProvas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('questao_id', '=', $this->id));
        return QuestaoUsuarioProva::getObjects( $criteria );
    }

    public function set_resposta_questao_to_string($resposta_questao_to_string)
    {
        if(is_array($resposta_questao_to_string))
        {
            $values = Questao::where('id', 'in', $resposta_questao_to_string)->getIndexedArray('id', 'id');
            $this->resposta_questao_to_string = implode(', ', $values);
        }
        else
        {
            $this->resposta_questao_to_string = $resposta_questao_to_string;
        }
    }

    public function get_resposta_questao_to_string()
    {
        if(!empty($this->resposta_questao_to_string))
        {
            return $this->resposta_questao_to_string;
        }
    
        $values = Resposta::where('questao_id', '=', $this->id)->getIndexedArray('questao_id','{questao->id}');
        return implode(', ', $values);
    }

    public function set_alternativa_questao_to_string($alternativa_questao_to_string)
    {
        if(is_array($alternativa_questao_to_string))
        {
            $values = Questao::where('id', 'in', $alternativa_questao_to_string)->getIndexedArray('id', 'id');
            $this->alternativa_questao_to_string = implode(', ', $values);
        }
        else
        {
            $this->alternativa_questao_to_string = $alternativa_questao_to_string;
        }
    }

    public function get_alternativa_questao_to_string()
    {
        if(!empty($this->alternativa_questao_to_string))
        {
            return $this->alternativa_questao_to_string;
        }
    
        $values = Alternativa::where('questao_id', '=', $this->id)->getIndexedArray('questao_id','{questao->id}');
        return implode(', ', $values);
    }

    public function set_questao_usuario_prova_questao_to_string($questao_usuario_prova_questao_to_string)
    {
        if(is_array($questao_usuario_prova_questao_to_string))
        {
            $values = Questao::where('id', 'in', $questao_usuario_prova_questao_to_string)->getIndexedArray('id', 'id');
            $this->questao_usuario_prova_questao_to_string = implode(', ', $values);
        }
        else
        {
            $this->questao_usuario_prova_questao_to_string = $questao_usuario_prova_questao_to_string;
        }
    }

    public function get_questao_usuario_prova_questao_to_string()
    {
        if(!empty($this->questao_usuario_prova_questao_to_string))
        {
            return $this->questao_usuario_prova_questao_to_string;
        }
    
        $values = QuestaoUsuarioProva::where('questao_id', '=', $this->id)->getIndexedArray('questao_id','{questao->id}');
        return implode(', ', $values);
    }

    public function set_questao_usuario_prova_usuario_prova_to_string($questao_usuario_prova_usuario_prova_to_string)
    {
        if(is_array($questao_usuario_prova_usuario_prova_to_string))
        {
            $values = UsuarioProva::where('id', 'in', $questao_usuario_prova_usuario_prova_to_string)->getIndexedArray('id', 'id');
            $this->questao_usuario_prova_usuario_prova_to_string = implode(', ', $values);
        }
        else
        {
            $this->questao_usuario_prova_usuario_prova_to_string = $questao_usuario_prova_usuario_prova_to_string;
        }
    }

    public function get_questao_usuario_prova_usuario_prova_to_string()
    {
        if(!empty($this->questao_usuario_prova_usuario_prova_to_string))
        {
            return $this->questao_usuario_prova_usuario_prova_to_string;
        }
    
        $values = QuestaoUsuarioProva::where('questao_id', '=', $this->id)->getIndexedArray('usuario_prova_id','{usuario_prova->id}');
        return implode(', ', $values);
    }

    public function delete($id = NULL)
    {
        $alternativas = $this->getAlternativas();
        foreach ($alternativas as $key => $alternativa) {
            $alternativa->delete();
        }

        parent::delete();
    }
    
}

