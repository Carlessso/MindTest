<?php

class GrupoUsuario extends TRecord
{
    const TABLENAME  = 'grupo_usuario';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $usuario;
    private $grupo;

    use SystemChangeLogTrait;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('usuario_id');
        parent::addAttribute('grupo_id');
            
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
     * Method set_grupo
     * Sample of usage: $var->grupo = $object;
     * @param $object Instance of Grupo
     */
    public function set_grupo(Grupo $object)
    {
        $this->grupo = $object;
        $this->grupo_id = $object->id;
    }

    /**
     * Method get_grupo
     * Sample of usage: $var->grupo->attribute;
     * @returns Grupo instance
     */
    public function get_grupo()
    {
    
        // loads the associated object
        if (empty($this->grupo))
            $this->grupo = new Grupo($this->grupo_id);
    
        // returns the associated object
        return $this->grupo;
    }

    
}

