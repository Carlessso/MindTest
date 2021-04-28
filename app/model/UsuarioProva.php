<?php

class UsuarioProva extends TRecord
{
    const TABLENAME  = 'usuario_prova';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $usuario;
    private $prova;

    use SystemChangeLogTrait;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('usuario_id');
        parent::addAttribute('prova_id');
        parent::addAttribute('inicio');
        parent::addAttribute('fim');
            
    }

    /**
     * Method set_usuario
     * Sample of usage: $var->usuario = $object;
     * @param $object Instance of Usuario
     */
    public function set_usuario(Usuario $object)
    {
        $this->usuario = $object;
        $this->usuario_id = $object->id;
    }

    /**
     * Method get_usuario
     * Sample of usage: $var->usuario->attribute;
     * @returns Usuario instance
     */
    public function get_usuario()
    {
    
        // loads the associated object
        if (empty($this->usuario))
            $this->usuario = new Usuario($this->usuario_id);
    
        // returns the associated object
        return $this->usuario;
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
     * Method getQuestaoUsuarioProvas
     */
    public function getQuestaoUsuarioProvas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('usuario_prova_id', '=', $this->id));
        return QuestaoUsuarioProva::getObjects( $criteria );
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
    
        $values = QuestaoUsuarioProva::where('usuario_prova_id', '=', $this->id)->getIndexedArray('questao_id','{questao->id}');
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
    
        $values = QuestaoUsuarioProva::where('usuario_prova_id', '=', $this->id)->getIndexedArray('usuario_prova_id','{usuario_prova->id}');
        return implode(', ', $values);
    }

    
}

