<?php

class ProvaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'projeto';
    private static $activeRecord = 'Prova';
    private static $primaryKey = 'id';
    private static $formName = 'form_Prova';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro de prova");


        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $sucinto = new TEntry('sucinto');
        $minutos_realizacao = new TEntry('minutos_realizacao');
        $cor_primaria = new TEntry('cor_primaria');
        $cor_secundaria = new TEntry('cor_secundaria');
        $usuario_responsavel = new TDBCombo('usuario_responsavel', 'projeto', 'Usuario', 'id', '{id}','id asc'  );
        $is_publica = new TRadioGroup('is_publica');
        $inicio = new TDateTime('inicio');
        $fim = new TDateTime('fim');

        $nome->addValidation("Nome", new TRequiredValidator()); 
        $sucinto->addValidation("Sucinto", new TRequiredValidator()); 
        $cor_primaria->addValidation("Cor primaria", new TRequiredValidator()); 
        $cor_secundaria->addValidation("Cor secundaria", new TRequiredValidator()); 
        $usuario_responsavel->addValidation("Usuario responsavel", new TRequiredValidator()); 
        $is_publica->addValidation("Is publica", new TRequiredValidator()); 
        $inicio->addValidation("Inicio", new TRequiredValidator()); 
        $fim->addValidation("Fim", new TRequiredValidator()); 

        $id->setEditable(false);
        $is_publica->addItems(['1'=>'Sim','2'=>'Não']);
        $is_publica->setLayout('vertical');
        $is_publica->setBooleanMode();

        $inicio->setValue('1');
        $is_publica->setValue('1');

        $fim->setMask('dd/mm/yyyy hh:ii');
        $inicio->setMask('dd/mm/yyyy hh:ii');

        $fim->setDatabaseMask('yyyy-mm-dd hh:ii');
        $inicio->setDatabaseMask('yyyy-mm-dd hh:ii');

        $id->setSize(100);
        $fim->setSize(150);
        $inicio->setSize(150);
        $nome->setSize('100%');
        $is_publica->setSize(80);
        $sucinto->setSize('100%');
        $cor_primaria->setSize('100%');
        $cor_secundaria->setSize('100%');
        $minutos_realizacao->setSize('100%');
        $usuario_responsavel->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Nome:", '#ff0000', '14px', null)],[$nome]);
        $row3 = $this->form->addFields([new TLabel("Sucinto:", '#ff0000', '14px', null)],[$sucinto]);
        $row4 = $this->form->addFields([new TLabel("Minutos realizacao:", null, '14px', null)],[$minutos_realizacao]);
        $row5 = $this->form->addFields([new TLabel("Cor primaria:", '#ff0000', '14px', null)],[$cor_primaria]);
        $row6 = $this->form->addFields([new TLabel("Cor secundaria:", '#ff0000', '14px', null)],[$cor_secundaria]);
        $row7 = $this->form->addFields([new TLabel("Usuario responsavel:", '#ff0000', '14px', null)],[$usuario_responsavel]);
        $row8 = $this->form->addFields([new TLabel("Is publica:", '#ff0000', '14px', null)],[$is_publica]);
        $row9 = $this->form->addFields([new TLabel("Inicio:", '#ff0000', '14px', null)],[$inicio]);
        $row10 = $this->form->addFields([new TLabel("Fim:", '#ff0000', '14px', null)],[$fim]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ProvaHeaderList', 'onShow']), 'fas:arrow-left #000000');

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Prova(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('ProvaHeaderList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();"); 
        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Prova($key); // instantiates the Active Record 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

}

