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
class PanelQuestionFormView extends TPage
{
    protected $form; // form
    private $html;

    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct($param = NULL)
    {
        parent::__construct();
        $this->adianti_target_container = 'panel-question-body';
        $this->html = new THtmlRenderer("app/resources/html/panel_question.html");
    }

    public function onLoad($param)
    {
        try
        {
        
        $this->addQuestion($param);
        
        // $question_text->enableSection('main', $replace);
        // $question_text_html = $question_text->getContents();

        parent::add($this->html);

        // $this->html->enableSection('main', array('form' => $form, 'question' => $div));
        
        // $div = new TElement('div');
        // $div->add($question_html);
        
    }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
            SystemErrorLog::write($e);
        }
        
    }
    
    public function makeQuestion($param)
    {
        if(FALSE)
        {
            //make select question
        }
        elseif(FALSE)
        {
            //make text questio
        }
        else
        {
            $text_action   = new TAction(['QuestaoFormView', 'replaceTextQuestion'], $param);
            $select_action = new TAction(['QuestaoFormView', 'replaceSelectQuestion'], $param);
            $param['text_action'] = $text_action->serialize();
            $param['select_action'] = $select_action->serialize();
            $param['register_state'] = FALSE;

            $this->html->enableSection('main', $param);
        }

    }

    public static function addQuestion($param)
    {
        TTransaction::open('projeto');
        $question = new Questao();
        $question->prova_id = 1;
        $question->store();
        TTransaction::close();
        
        TScript::create("$('.panel-question-body').append('<div id=\"question_{$question->id}\"></div>');");
        
        $param['register_state'] = 'false';
        $param['filter']         = (isset($param['filter']) AND $param['filter']) ? $param['filter'] : 'subgrupo';
        $param['id'] = $question->id;

        $action = new TAction(['QuestaoFormView', 'onLoad'], $param);
        $action = $action->serialize();

        TScript::create("$(document).ready(function(){ change_page('{$question->id}', '{$action}'); });");
    }
    
    public static function makeTextQuestion()
    {
        $form = new BootstrapFormBuilder('teste');

        $pergunta = new TText('pergunta');
        $resposta = new TText('resposta');

        $pergunta->style = 'font-size: 16px';

        $pergunta->setSize('100%', '11px');
        $resposta->setSize('100%');

        $pergunta->placeholder = 'Digite a questão aqui';
        $resposta->placeholder = 'Resposta';

        $row = $form->addFields([NULL, $pergunta]);
        $row->layout = ['col-sm-12'];
        $row = $form->addFields([NULL, $resposta]);
        $row->layout = ['col-sm-12'];
        
        return $form;
    }

    public static function makeFormTextQuestion()
    {
        $form = new BootstrapFormBuilder('teste');

        $tempo_realizacao = new TCombo('tempo_realizacao');
        $peso             = new TCombo('peso');
        $obrigatoria      = new TRadioGroup('obrigatoria');

        $tempo_realizacao->setSize('100%');
        $peso->setSize('100%');
        $obrigatoria->setSize('100%');

        $peso->setValue(0);        
        $peso->addItems(ProvaComboService::getPontuacao());

        $obrigatoria->addItems(['0' => 'Sim', '1' => 'Não']);
        $obrigatoria->setLayout('horizontal');
        $obrigatoria->setValue('1');
        $obrigatoria->setUseButton();
        
        $row         = $form->addFields(
            [NULL, NULL],
            [new TLabel('Peso', NULL, NULL, NULL, '100%'), $peso],
            [new TLabel('Obrigatória?', NULL, NULL, NULL, '100%'), $obrigatoria],
        );
        $row->layout = ['col-sm-4','col-sm-4','col-sm-4'];
        
        return $form;    
    }

    public static function replaceTextQuestion($param)
    {
        $form_text = self::makeTextQuestion();
        $config_text = self::makeFormTextQuestion();
        
        $replace['question'] = $form_text;
        $replace['question_form'] = $config_text;

        $question_text = new THtmlRenderer("app/resources/html/panel_question_text.html");
        $question_text->enableSection('main', $replace);
        $question_text_html = $question_text->getContents();

        TScript::create("$(\"#question_" . $param['id'] . "\").empty().append('{$question_text_html}');");
    }

    public static function makeSelectQuestion()
    {
        $form = new BootstrapFormBuilder('teste');

        $pergunta = new TText('pergunta');
        
        // $alternativas = new TFieldList('alternativas');
        // $alternativas->enableSorting();
        // $alternativas->width = '100%';
        // $alternativas->name  = "atributos";
        
        $resposta = new TEntry("resposta[]");

        // $alternativas->addField('', $resposta);

        // // $alternativas->setCloneFunction('clone_previous_row_with_default_values(this)');
        // $alternativas->addHeader();
        // $alternativas->addCloneAction();

        $alternativas = new TFieldList('alternativas');
        $alternativas->width = '100%';
        $alternativas->class .= 'prova-form';
        $alternativas->addField( 'Adicione as alternativas',  $resposta, ['width' => '100%']);
        
        // $alternativas->addButtonAction(new TAction(['ProvaFormView', 'onView']), "fa:save blue", "Correta");

        // $alternativas->enableSorting();
        
        $form->addField($resposta);
        
        $alternativas->addHeader();
        $alternativas->addDetail( new stdClass );
        $alternativas->addCloneAction();

        $pergunta->style = 'font-size: 16px';

        $pergunta->setSize('100%', '11px');
        $resposta->setSize('100%');

        $pergunta->placeholder = 'Digite a questão aqui';
        $resposta->placeholder = 'Resposta';

        $row = $form->addFields([NULL, $pergunta]);
        $row->layout = ['col-sm-12'];
        $row = $form->addFields([NULL, $alternativas]);
        $row->layout = ['col-sm-12'];
        $row->class  = 'prova-form';
        
        return $form;
    }

    public static function makeFormSelectQuestion()
    {
        $form = new BootstrapFormBuilder('teste');

        $tempo_realizacao = new TCombo('tempo_realizacao');
        $peso             = new TCombo('peso');
        $obrigatoria      = new TRadioGroup('obrigatoria');

        $tempo_realizacao->setSize('100%');
        $peso->setSize('100%');
        $obrigatoria->setSize('100%');

        $peso->setValue(0);        
        $peso->addItems(ProvaComboService::getPontuacao());

        $obrigatoria->addItems(['0' => 'Sim', '1' => 'Não']);
        $obrigatoria->setLayout('horizontal');
        $obrigatoria->setValue('1');
        $obrigatoria->setUseButton();
        
        $row         = $form->addFields(
            [NULL, NULL],
            [new TLabel('Peso', NULL, NULL, NULL, '100%'), $peso],
            [new TLabel('Obrigatória?', NULL, NULL, NULL, '100%'), $obrigatoria],
        );
        $row->layout = ['col-sm-4','col-sm-4','col-sm-4'];
        
        return $form;    
    }

    public static function replaceSelectQuestion($param)
    {
        $form_text = self::makeSelectQuestion();
        $config_text = self::makeFormSelectQuestion();
        
        $replace['question']      = $form_text;
        $replace['question_form'] = $config_text;

        $question_text = new THtmlRenderer("app/resources/html/panel_question_text.html");
        $question_text->enableSection('main', $replace);
        $question_text_html = $question_text->getContents();

        TScript::create("$(\"#question_" . $param['id'] . "\").empty().append('{$question_text_html}');");
    }
    
}
