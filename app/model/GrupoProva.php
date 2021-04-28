<?php

class GrupoProva extends TRecord
{
    const TABLENAME  = 'grupo_prova';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $prova;
    private $grupo;

    use SystemChangeLogTrait;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('prova_id');
        parent::addAttribute('grupo_id');
            
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

