<?php

class QuestaoUsuarioProvaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'projeto';
    private static $activeRecord = 'QuestaoUsuarioProva';
    private static $primaryKey = 'id';
    private static $formName = 'form_QuestaoUsuarioProva';

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
        $this->form->setFormTitle("Cadastro de questao usuario prova");


        $id = new TEntry('id');
        $questao_id = new TDBCombo('questao_id', 'projeto', 'Questao', 'id', '{id}','id asc'  );
        $usuario_prova_id = new TDBCombo('usuario_prova_id', 'projeto', 'UsuarioProva', 'id', '{id}','id asc'  );
        $resposta_usuario = new TEntry('resposta_usuario');
        $peso = new TNumeric('peso', '3', ',', '.' );
        $dt_registro = new TDateTime('dt_registro');

        $questao_id->addValidation("Questao id", new TRequiredValidator()); 
        $usuario_prova_id->addValidation("Usuario prova id", new TRequiredValidator()); 
        $peso->addValidation("Peso", new TRequiredValidator()); 
        $dt_registro->addValidation("Dt registro", new TRequiredValidator()); 

        $id->setEditable(false);
        $peso->setMaxLength(13);
        $dt_registro->setMask('dd/mm/yyyy hh:ii');
        $dt_registro->setValue('1');
        $dt_registro->setDatabaseMask('yyyy-mm-dd hh:ii');

        $id->setSize(100);
        $peso->setSize('100%');
        $dt_registro->setSize(150);
        $questao_id->setSize('100%');
        $usuario_prova_id->setSize('100%');
        $resposta_usuario->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Questao id:", '#ff0000', '14px', null)],[$questao_id]);
        $row3 = $this->form->addFields([new TLabel("Usuario prova id:", '#ff0000', '14px', null)],[$usuario_prova_id]);
        $row4 = $this->form->addFields([new TLabel("Resposta usuario:", null, '14px', null)],[$resposta_usuario]);
        $row5 = $this->form->addFields([new TLabel("Peso:", '#ff0000', '14px', null)],[$peso]);
        $row6 = $this->form->addFields([new TLabel("Dt registro:", '#ff0000', '14px', null)],[$dt_registro]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['QuestaoUsuarioProvaHeaderList', 'onShow']), 'fas:arrow-left #000000');

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

            $object = new QuestaoUsuarioProva(); // create an empty object 

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
            TApplication::loadPage('QuestaoUsuarioProvaHeaderList', 'onShow', $loadPageParam); 

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

                $object = new QuestaoUsuarioProva($key); // instantiates the Active Record 

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

