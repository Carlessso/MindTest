<?php
/**
 * LoginForm
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Guilherme Cegolini
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class ProvaFormView extends TPage
{
    protected $form; // form
    protected $form_title; // form_title
    private $html;
    private $id;

    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct($param)
    {
        parent::__construct();

        $this->html = new THtmlRenderer('app/resources/html/folder_one.html');
        
        $form       = $this->makeFormularioProva($param);
        $form_title = $this->makeFormulario($param);
        
        $this->html->enableSection('main', array('form_title' => $form_title, 'form' => $form));
        
        parent::add($this->html);
    }
    
    public function makeFormulario($param)
    {
        $form = new TForm('prova_form_title');
        
        $pergunta = new TEntry('nome');
        $resposta = new TEntry('descricao');

        $pergunta->class = 'panel-title';
        $resposta->class = 'panel-subtitle';
        
        $pergunta->setSize('100%');
        $resposta->setSize('100%');
        
        $pergunta->setValue('Título do formulário');
        $resposta->setValue('Descrição');
        
        $row = $form->add($pergunta);
        $row = $form->add($resposta);

        return $form;
    }

    public function makeFormularioProva($param)
    {
        $this->form = new BootstrapFormBuilder('teste');

        $id             = new THidden('id');
        $dt_inicio      = new TDate('dt_inicio');
        $hr_inicio      = new TTime('hr_inicio');
        $dt_fim         = new TDate('dt_fim');
        $hr_fim         = new TTime('hr_fim');
        $dias           = new TCombo('dias');
        $horas          = new TCombo('horas');
        $minutos        = new TCombo('minutos');
        $modelo         = new TRadioGroup('is_ordenada');
        $ordem          = new TRadioGroup('is_formulario_livre');
        $cor_primaria   = new TColor('cor_primaria');
        $cor_secundaria = new TColor('cor_secundaria');

        $dt_inicio->setSize('100%');
        $hr_inicio->setSize('100%');
        $dt_fim->setSize('100%');
        $hr_fim->setSize('100%');
        $dias->setSize('100%');
        $horas->setSize('100%');
        $minutos->setSize('100%');
        $modelo->setSize('100%');
        $ordem->setSize('100%');
        $cor_primaria->setSize('100%');
        $cor_secundaria->setSize('100%');

        $id->setValue($param['id']);

        $dias->setValue(0);
        $horas->setValue(0);
        $minutos->setValue(0);

        $modelo->addItems(['0' => 'Questões livres', '1' => 'Sequencial']);
        $modelo->setLayout('horizontal');
        $modelo->setValue('0');
        $modelo->setUseButton();
        $modelo->setProperty('class', 'teta');
        
        $ordem->addItems(['0' => 'Ordenado', '1' => 'Aleatório']);
        $ordem->setLayout('horizontal');
        $ordem->setValue('0');
        $ordem->setUseButton();

        $dias->addItems(ProvaComboService::getDias());
        $horas->addItems(ProvaComboService::getHoras());
        $minutos->addItems(ProvaComboService::getMinutos());

        $row = $this->form->addFields([NULL, $id]);
        
        $row         = $this->form->addFields(
            [new TLabel('Data de inicio', NULL, NULL, NULL, '100%'), $dt_inicio],
            [new TLabel('Horário de inicio', NULL, NULL, NULL, '100%'), $hr_inicio],
            [new TLabel('Data de fim', NULL, NULL, NULL, '100%'), $dt_fim],
            [new TLabel('Horário de fim', NULL, NULL, NULL, '100%'), $hr_fim]
        );
        $row->layout = ['col-md-3 col-lg-2','col-md-3 col-lg-2','col-md-3 col-lg-2','col-md-3 col-lg-2' ];
        
        $row         = $this->form->addFields(
            [new TLabel('Duração', NULL, NULL, NULL, '100%'), $dias],
            [new TLabel('NULL', '#15202b', NULL, NULL, '100%'), $horas],
            [new TLabel('NULL', '#15202b', NULL, NULL, '100%'), $minutos]
        );
        $row->layout = ['col-md-3 col-lg-2','col-md-3 col-lg-2','col-md-3 col-lg-2'];
        
        $row         = $this->form->addFields(
            [new TLabel('Modelo do formulário', NULL, NULL, NULL, '100%'), $modelo],
            [new TLabel('Ordem das questões', NULL, NULL, NULL, '100%'), $ordem],
            [new TLabel('Cor primária', NULL, NULL, NULL, '100%'), $cor_primaria],
            [new TLabel('Cor secundária', NULL, NULL, NULL, '100%'), $cor_secundaria]
        );
        
        $row->layout = ['col-md-3 col-lg-2','col-md-3 col-lg-2','col-md-3 col-lg-2','col-md-3 col-lg-2' ];

        $btn_onsearch = $this->form->addAction('Salvar', new TAction(['ProvaFormView', 'onSave']), NULL);
        $btn_onsearch->addStyleClass('btn-primary');
        
        return $this->form;
    }

    public static function onSave($param)
    {
        TTransaction::open('projeto');
        
        $minutos = 0;
        $minutos += $param['dias'] * 1440;
        $minutos += $param['horas'] * 60;
        $minutos += $param['minutos'];

        if($param['dt_inicio'])
        {
            $inicio = $param['dt_inicio'] . ' ' . $param['hr_inicio'];
        }
        if($param['dt_fim'])
        {
            $fim    = $param['dt_fim'] . ' ' . $param['hr_fim'];
        }

        $prova                      = new Prova($param['id']);
        $prova->nome                = $prova->nome ?? 'Título do formulário';
        $prova->usuario_responsavel = 1;
        $prova->minutos_realizacao  = $minutos;
        $prova->inicio              = $inicio;
        $prova->fim                 = $fim;
        $prova->cor_primaria        = $param['cor_primaria'];
        $prova->cor_secundaria      = $param['cor_secundaria'];
        $prova->is_publica          = FALSE;
        $prova->is_ordenada         = $param['is_ordenada'];
        $prova->is_formulario_livre = $param['is_formulario_livre'];

        $prova->store();
        
        $form = TForm::getFormByName('prova_form_title');

        var_dump($form);

        TTransaction::close();
        
        TScript::create("__adianti_post_data('prova_form_title', 'class=ProvaFormView&method=onSaveTitle&static=1&id={$prova->id}');");  
    }
    
    public static function onSaveTitle($param)
    {
        TTransaction::open('projeto');
        
        $prova            = new Prova($param['id']);
        $prova->nome      = $param['nome'];
        $prova->descricao = $param['descricao'];

        var_dump($prova);
        $prova->store();

        TTransaction::close();
    }
    
    public function onEdit($param)   
    {
        TTransaction::open('projeto');
        
        $prova = new Prova($param['key']);
        
        if(empty($prova))
        {
            throw new Exception("Error Processing Request", 1);
        }
        
        $inicio = new DateTime($prova->inicio);
        $fim = new DateTime($prova->fim);
        
        $prova->dias                = floor((($prova->minutos_realizacao)%86400)/1440);
        $prova->horas               = floor((($prova->minutos_realizacao)%1440)/60);
        $prova->minutos             = ($prova->minutos_realizacao)%60;
        $prova->dt_inicio           = $inicio->format('Y-m-d');
        $prova->hr_inicio           = $inicio->format('h:i');
        $prova->dt_fim              = $fim->format('Y-m-d');
        $prova->hr_fim              = $fim->format('h:i');
        $prova->is_ordenada         = $prova->is_ordenada ? 0 : 1; 
        $prova->is_formulario_livre = $prova->is_formulario_livre ? 0 : 1;
        
        $this->form->setData($prova);
        
        TTransaction::close();
    }
    
    public function onView($param)
    {
        TTransaction::open('projeto');
    
        if($this->id == NULL)
        {
            $prova = new Prova();
            $prova->nome                = 'Título';
            $prova->descricao           = 'Descrição';
            $prova->cor_primaria        = '#63CCFF';
            $prova->cor_secundaria      = '#15202B';
            $prova->usuario_responsavel = 1;
            $prova->store();
        }
        else
        {
            $prova = new Prova($this->id);
        }
    
        TTransaction::close();
    
    
        QuestaoFormView::addQuestion(['ref_prova' => $prova->id]);
    }
}
