<?php

class Prova extends TRecord
{
    const TABLENAME  = 'prova';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $fk_usuario_responsavel;

    use SystemChangeLogTrait;


    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('descricao');
        parent::addAttribute('minutos_realizacao');
        parent::addAttribute('cor_primaria');
        parent::addAttribute('cor_secundaria');
        parent::addAttribute('usuario_responsavel');
        parent::addAttribute('is_publica');
        parent::addAttribute('inicio');
        parent::addAttribute('fim');            
        parent::addAttribute('is_ordenada');            
        parent::addAttribute('is_formulario_livre');            
    }

    /**
     * Method set_usuario
     * Sample of usage: $var->usuario = $object;
     * @param $object Instance of Usuario
     */
    public function set_fk_usuario_responsavel(Usuario $object)
    {
        $this->fk_usuario_responsavel = $object;
        $this->usuario_responsavel = $object->id;
    }

    /**
     * Method get_fk_usuario_responsavel
     * Sample of usage: $var->fk_usuario_responsavel->attribute;
     * @returns Usuario instance
     */
    public function get_fk_usuario_responsavel()
    {
    
        // loads the associated object
        if (empty($this->fk_usuario_responsavel))
            $this->fk_usuario_responsavel = new Usuario($this->usuario_responsavel);
    
        // returns the associated object
        return $this->fk_usuario_responsavel;
    }

    /**
     * Method getGrupoProvas
     */
    public function getGrupoProvas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('prova_id', '=', $this->id));
        return GrupoProva::getObjects( $criteria );
    }
    /**
     * Method getUsuarioProvas
     */
    public function getUsuarioProvas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('prova_id', '=', $this->id));
        return UsuarioProva::getObjects( $criteria );
    }
    /**
     * Method getQuestaos
     */
    public function getQuestaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('prova_id', '=', $this->id));
        return Questao::getObjects( $criteria );
    }

    public function set_grupo_prova_prova_to_string($grupo_prova_prova_to_string)
    {
        if(is_array($grupo_prova_prova_to_string))
        {
            $values = Prova::where('id', 'in', $grupo_prova_prova_to_string)->getIndexedArray('id', 'id');
            $this->grupo_prova_prova_to_string = implode(', ', $values);
        }
        else
        {
            $this->grupo_prova_prova_to_string = $grupo_prova_prova_to_string;
        }
    }

    public function get_grupo_prova_prova_to_string()
    {
        if(!empty($this->grupo_prova_prova_to_string))
        {
            return $this->grupo_prova_prova_to_string;
        }
    
        $values = GrupoProva::where('prova_id', '=', $this->id)->getIndexedArray('prova_id','{prova->id}');
        return implode(', ', $values);
    }

    public function set_grupo_prova_grupo_to_string($grupo_prova_grupo_to_string)
    {
        if(is_array($grupo_prova_grupo_to_string))
        {
            $values = Grupo::where('id', 'in', $grupo_prova_grupo_to_string)->getIndexedArray('id', 'id');
            $this->grupo_prova_grupo_to_string = implode(', ', $values);
        }
        else
        {
            $this->grupo_prova_grupo_to_string = $grupo_prova_grupo_to_string;
        }
    }

    public function get_grupo_prova_grupo_to_string()
    {
        if(!empty($this->grupo_prova_grupo_to_string))
        {
            return $this->grupo_prova_grupo_to_string;
        }
    
        $values = GrupoProva::where('prova_id', '=', $this->id)->getIndexedArray('grupo_id','{grupo->id}');
        return implode(', ', $values);
    }

    public function set_usuario_prova_usuario_to_string($usuario_prova_usuario_to_string)
    {
        if(is_array($usuario_prova_usuario_to_string))
        {
            $values = Usuario::where('id', 'in', $usuario_prova_usuario_to_string)->getIndexedArray('id', 'id');
            $this->usuario_prova_usuario_to_string = implode(', ', $values);
        }
        else
        {
            $this->usuario_prova_usuario_to_string = $usuario_prova_usuario_to_string;
        }
    }

    public function get_usuario_prova_usuario_to_string()
    {
        if(!empty($this->usuario_prova_usuario_to_string))
        {
            return $this->usuario_prova_usuario_to_string;
        }
    
        $values = UsuarioProva::where('prova_id', '=', $this->id)->getIndexedArray('usuario_id','{usuario->id}');
        return implode(', ', $values);
    }

    public function set_usuario_prova_prova_to_string($usuario_prova_prova_to_string)
    {
        if(is_array($usuario_prova_prova_to_string))
        {
            $values = Prova::where('id', 'in', $usuario_prova_prova_to_string)->getIndexedArray('id', 'id');
            $this->usuario_prova_prova_to_string = implode(', ', $values);
        }
        else
        {
            $this->usuario_prova_prova_to_string = $usuario_prova_prova_to_string;
        }
    }

    public function get_usuario_prova_prova_to_string()
    {
        if(!empty($this->usuario_prova_prova_to_string))
        {
            return $this->usuario_prova_prova_to_string;
        }
    
        $values = UsuarioProva::where('prova_id', '=', $this->id)->getIndexedArray('prova_id','{prova->id}');
        return implode(', ', $values);
    }

    public function set_questao_prova_to_string($questao_prova_to_string)
    {
        if(is_array($questao_prova_to_string))
        {
            $values = Prova::where('id', 'in', $questao_prova_to_string)->getIndexedArray('id', 'id');
            $this->questao_prova_to_string = implode(', ', $values);
        }
        else
        {
            $this->questao_prova_to_string = $questao_prova_to_string;
        }
    }

    public function get_questao_prova_to_string()
    {
        if(!empty($this->questao_prova_to_string))
        {
            return $this->questao_prova_to_string;
        }
    
        $values = Questao::where('prova_id', '=', $this->id)->getIndexedArray('prova_id','{prova->id}');
        return implode(', ', $values);
    }

    public function delete()
    {
        $questoes = $this->getQuestaos();
        foreach ($questoes as $key => $questao) {
            $questao->delete();
        }

        parent::delete();
    }
    

}

