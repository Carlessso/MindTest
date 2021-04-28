<?php

class Grupo extends TRecord
{
    const TABLENAME  = 'grupo';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    use SystemChangeLogTrait;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('descricao');
            
    }

    /**
     * Method getGrupoProvas
     */
    public function getGrupoProvas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('grupo_id', '=', $this->id));
        return GrupoProva::getObjects( $criteria );
    }
    /**
     * Method getGrupoUsuarios
     */
    public function getGrupoUsuarios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('grupo_id', '=', $this->id));
        return GrupoUsuario::getObjects( $criteria );
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
    
        $values = GrupoProva::where('grupo_id', '=', $this->id)->getIndexedArray('prova_id','{prova->id}');
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
    
        $values = GrupoProva::where('grupo_id', '=', $this->id)->getIndexedArray('grupo_id','{grupo->id}');
        return implode(', ', $values);
    }

    public function set_grupo_usuario_usuario_to_string($grupo_usuario_usuario_to_string)
    {
        if(is_array($grupo_usuario_usuario_to_string))
        {
            $values = Usuario::where('id', 'in', $grupo_usuario_usuario_to_string)->getIndexedArray('id', 'id');
            $this->grupo_usuario_usuario_to_string = implode(', ', $values);
        }
        else
        {
            $this->grupo_usuario_usuario_to_string = $grupo_usuario_usuario_to_string;
        }
    }

    public function get_grupo_usuario_usuario_to_string()
    {
        if(!empty($this->grupo_usuario_usuario_to_string))
        {
            return $this->grupo_usuario_usuario_to_string;
        }
    
        $values = GrupoUsuario::where('grupo_id', '=', $this->id)->getIndexedArray('usuario_id','{usuario->id}');
        return implode(', ', $values);
    }

    public function set_grupo_usuario_grupo_to_string($grupo_usuario_grupo_to_string)
    {
        if(is_array($grupo_usuario_grupo_to_string))
        {
            $values = Grupo::where('id', 'in', $grupo_usuario_grupo_to_string)->getIndexedArray('id', 'id');
            $this->grupo_usuario_grupo_to_string = implode(', ', $values);
        }
        else
        {
            $this->grupo_usuario_grupo_to_string = $grupo_usuario_grupo_to_string;
        }
    }

    public function get_grupo_usuario_grupo_to_string()
    {
        if(!empty($this->grupo_usuario_grupo_to_string))
        {
            return $this->grupo_usuario_grupo_to_string;
        }
    
        $values = GrupoUsuario::where('grupo_id', '=', $this->id)->getIndexedArray('grupo_id','{grupo->id}');
        return implode(', ', $values);
    }

    
}

