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
    private $html;


    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct($param)
    {
        parent::__construct();

        $this->html = new THtmlRenderer('app/resources/html/folder_one.html');
        
        $form = $this->makeFormularioProva();
        
        $this->html->enableSection('main', array('form' => $form));
        
        parent::add($this->html);
    }
    
    public function makeFormularioProva()
    {
        $form = new BootstrapFormBuilder('teste');

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

        $row         = $form->addFields(
            [new TLabel('Data de inicio', NULL, NULL, NULL, '100%'), $dt_inicio],
            [new TLabel('Horário de inicio', NULL, NULL, NULL, '100%'), $hr_inicio],
            [new TLabel('Data de fim', NULL, NULL, NULL, '100%'), $dt_fim],
            [new TLabel('Horário de fim', NULL, NULL, NULL, '100%'), $hr_fim]
        );
        $row->layout = ['col-sm-2','col-sm-2','col-sm-2','col-sm-2' ];

        $row         = $form->addFields(
            [new TLabel('Duração', NULL, NULL, NULL, '100%'), $dias],
            [new TLabel('NULL', '#15202b', NULL, NULL, '100%'), $horas],
            [new TLabel('NULL', '#15202b', NULL, NULL, '100%'), $minutos]
        );
        $row->layout = ['col-sm-2','col-sm-2','col-sm-2'];

        $row         = $form->addFields(
            [new TLabel('Modelo do formulário', NULL, NULL, NULL, '100%'), $modelo],
            [new TLabel('Ordem das questões', NULL, NULL, NULL, '100%'), $ordem],
            [new TLabel('Cor primária', NULL, NULL, NULL, '100%'), $cor_primaria],
            [new TLabel('Cor secundária', NULL, NULL, NULL, '100%'), $cor_secundaria]
        );
        $row->layout = ['col-sm-2','col-sm-2','col-sm-2','col-sm-2'];
        
        return $form;
    }

    /**
     *
     */
    public function onView($param)
    {
        QuestaoFormView::addQuestion(NULL);
    }
    
}
