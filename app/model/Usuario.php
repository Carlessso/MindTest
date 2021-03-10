<?php

class Usuario extends TRecord
{
    const TABLENAME  = 'usuario';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('email');
        parent::addAttribute('senha');
        parent::addAttribute('is_professor');
            
    }

    /**
     * Method getProvas
     */
    public function getProvas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('usuario_responsavel', '=', $this->id));
        return Prova::getObjects( $criteria );
    }
    /**
     * Method getGrupoUsuarios
     */
    public function getGrupoUsuarios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('usuario_id', '=', $this->id));
        return GrupoUsuario::getObjects( $criteria );
    }
    /**
     * Method getUsuarioProvas
     */
    public function getUsuarioProvas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('usuario_id', '=', $this->id));
        return UsuarioProva::getObjects( $criteria );
    }

    public function set_prova_fk_usuario_responsavel_to_string($prova_fk_usuario_responsavel_to_string)
    {
        if(is_array($prova_fk_usuario_responsavel_to_string))
        {
            $values = Usuario::where('id', 'in', $prova_fk_usuario_responsavel_to_string)->getIndexedArray('id', 'id');
            $this->prova_fk_usuario_responsavel_to_string = implode(', ', $values);
        }
        else
        {
            $this->prova_fk_usuario_responsavel_to_string = $prova_fk_usuario_responsavel_to_string;
        }
    }

    public function get_prova_fk_usuario_responsavel_to_string()
    {
        if(!empty($this->prova_fk_usuario_responsavel_to_string))
        {
            return $this->prova_fk_usuario_responsavel_to_string;
        }
    
        $values = Prova::where('usuario_responsavel', '=', $this->id)->getIndexedArray('usuario_responsavel','{fk_usuario_responsavel->id}');
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
    
        $values = GrupoUsuario::where('usuario_id', '=', $this->id)->getIndexedArray('usuario_id','{usuario->id}');
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
    
        $values = GrupoUsuario::where('usuario_id', '=', $this->id)->getIndexedArray('grupo_id','{grupo->id}');
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
    
        $values = UsuarioProva::where('usuario_id', '=', $this->id)->getIndexedArray('usuario_id','{usuario->id}');
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
    
        $values = UsuarioProva::where('usuario_id', '=', $this->id)->getIndexedArray('prova_id','{prova->id}');
        return implode(', ', $values);
    }

    
}

