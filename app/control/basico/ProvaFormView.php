<?php
/**
 * LoginForm
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class ProvaFormView extends TPage
{
    protected $form; // form
    private $html;


    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct($param)
    {
        parent::__construct();
        
        TScript::create("$('body').addClass('ls-closed');");
        TScript::create("$('section').removeClass('content');");
        TScript::create("$('div').removeClass('container-fluid');");
        TScript::create("$('body').css('background-color', '#ffffff');");
        TScript::create("$('.navbar').css('display', 'none');");

        $this->html = new THtmlRenderer('app/resources/html/folder_one.html');

        $this->form = new BootstrapFormBuilder('teste', 'Status da ação');
        $this->makeFormularioProva();

        $this->html->enableSection('main', array('form' => $this->form));

        parent::add($this->html);
    }

    public function makeFormularioProva()
    {
        $dt_inicio      = new TDate('dt_inicio');
        $hr_inicio      = new TTime('hr_inicio');
        $dt_fim         = new TDate('dt_fim');
        $hr_fim         = new TTime('hr_fim');
        $dias           = new TCombo('dias');
        $horas          = new TCombo('horas');
        $minutos        = new TCombo('minutos');
        $modelo         = new TRadioGroup('modelo');
        $ordem          = new TRadioGroup('ordem');
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

        $dias->setLabel('dias');
        $horas->setTip('dias');
        $minutos->placeholder = 'dias';

        $modelo->addItems(['0' => 'Questões livres', '1' => 'Sequencial']);
        $modelo->setLayout('horizontal');
        $modelo->setValue('0');
        $modelo->setUseButton();
        $modelo->setProperty('class', 'teta');
        
        $ordem->addItems(['0' => 'Ordenado', '1' => 'Aleatório']);
        $ordem->setLayout('horizontal');
        $ordem->setValue('0');
        $ordem->setUseButton();

        $dias->addItems([1 => 'teste', 2 => 'teste']);

        $row         = $this->form->addFields(
            [new TLabel('Data de inicio', NULL, NULL, NULL, '100%'), $dt_inicio],
            [new TLabel('Horário de inicio', NULL, NULL, NULL, '100%'), $hr_inicio],
            [new TLabel('Data de fim', NULL, NULL, NULL, '100%'), $dt_fim],
            [new TLabel('Horário de fim', NULL, NULL, NULL, '100%'), $hr_fim]
        );
        $row->layout = ['col-sm-2','col-sm-2','col-sm-2','col-sm-2' ];

        $row         = $this->form->addFields(
            [new TLabel('Duração', NULL, NULL, NULL, '100%'), $dias],
            [new TLabel(' ', NULL, NULL, NULL, '100%'), $horas],
            [new TLabel(' ', NULL, NULL, NULL, '100%'), $minutos]
        );
        $row->layout = ['col-sm-2','col-sm-2','col-sm-2'];

        $row         = $this->form->addFields(
            [new TLabel('Modelo do formulário', NULL, NULL, NULL, '100%'), $modelo],
            [new TLabel('Ordem das questões', NULL, NULL, NULL, '100%'), $ordem],
            [new TLabel('Cor primária', NULL, NULL, NULL, '100%'), $cor_primaria],
            [new TLabel('Cor secundária', NULL, NULL, NULL, '100%'), $cor_secundaria]
        );
        $row->layout = ['col-sm-2','col-sm-2','col-sm-2','col-sm-2'];
    }

    /**
     *
     */
    public function onView($param)
    {
    }
    
}
