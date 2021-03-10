<?php

class QuestaoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'projeto';
    private static $activeRecord = 'Questao';
    private static $primaryKey = 'id';
    private static $formName = 'form_Questao';

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
        $this->form->setFormTitle("Cadastro de questao");


        $id = new TEntry('id');
        $pergunta = new TEntry('pergunta');
        $is_multipla_escolha = new TRadioGroup('is_multipla_escolha');
        $prova_id = new TDBCombo('prova_id', 'projeto', 'Prova', 'id', '{id}','id asc'  );
        $minutos_realizacao = new TEntry('minutos_realizacao');
        $peso = new TNumeric('peso', '3', ',', '.' );
        $is_obrigatoria = new TRadioGroup('is_obrigatoria');

        $pergunta->addValidation("Pergunta", new TRequiredValidator()); 
        $is_multipla_escolha->addValidation("Is multipla escolha", new TRequiredValidator()); 
        $prova_id->addValidation("Prova id", new TRequiredValidator()); 
        $peso->addValidation("Peso", new TRequiredValidator()); 
        $is_obrigatoria->addValidation("Is obrigatoria", new TRequiredValidator()); 

        $peso->setMaxLength(13);
        $id->setEditable(false);

        $is_obrigatoria->addItems(['1'=>'Sim','2'=>'Não']);
        $is_multipla_escolha->addItems(['1'=>'Sim','2'=>'Não']);

        $is_obrigatoria->setLayout('vertical');
        $is_multipla_escolha->setLayout('vertical');

        $is_obrigatoria->setValue('1');
        $is_multipla_escolha->setValue('1');

        $is_obrigatoria->setBooleanMode();
        $is_multipla_escolha->setBooleanMode();

        $id->setSize(100);
        $peso->setSize('100%');
        $pergunta->setSize('100%');
        $prova_id->setSize('100%');
        $is_obrigatoria->setSize(80);
        $is_multipla_escolha->setSize(80);
        $minutos_realizacao->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Pergunta:", '#ff0000', '14px', null)],[$pergunta]);
        $row3 = $this->form->addFields([new TLabel("Is multipla escolha:", '#ff0000', '14px', null)],[$is_multipla_escolha]);
        $row4 = $this->form->addFields([new TLabel("Prova id:", '#ff0000', '14px', null)],[$prova_id]);
        $row5 = $this->form->addFields([new TLabel("Minutos realizacao:", null, '14px', null)],[$minutos_realizacao]);
        $row6 = $this->form->addFields([new TLabel("Peso:", '#ff0000', '14px', null)],[$peso]);
        $row7 = $this->form->addFields([new TLabel("Is obrigatoria:", '#ff0000', '14px', null)],[$is_obrigatoria]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['QuestaoHeaderList', 'onShow']), 'fas:arrow-left #000000');

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

            $object = new Questao(); // create an empty object 

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
            TApplication::loadPage('QuestaoHeaderList', 'onShow', $loadPageParam); 

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

                $object = new Questao($key); // instantiates the Active Record 

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

