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
class QuestaoAlunoView extends TPage
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
        $this->adianti_target_container = 'question_' . $param['id'];
        $this->html = new THtmlRenderer("app/resources/html/panel_question_base_aluno.html");
    }

    public function onLoad($param)
    {
        try
        {
        $this->makeQuestion($param);

        parent::add($this->html);
        
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
        $add_question_action    = new TAction(['QuestaoAlunoView', 'addQuestion'], $param);
        $delete_question_action = new TAction(['QuestaoAlunoView', 'deleteQuestion'], $param);
        
        TTransaction::open('projeto');
        $questao = new Questao($param['id']);
        TTransaction::close();
        
        if($questao->is_multipla_escolha)
        {
            $param['type'] = 'select';
            self::replaceQuestion($param);
        }
        elseif($questao->pergunta != NULL)
        {
            $param['type'] = 'text';
            self::replaceQuestion($param);
        }
        else
        {
            $param['type'] = 'text';
            $text_action   = new TAction(['QuestaoAlunoView', 'replaceQuestion'], $param);
            $param['type'] = 'select';
            $select_action = new TAction(['QuestaoAlunoView', 'replaceQuestion'], $param);
            
            $param['text_action']            = $text_action->serialize();
            $param['select_action']          = $select_action->serialize();
            $param['add_question_action']    = $add_question_action->serialize();
            $param['delete_question_action'] = $delete_question_action->serialize();
            $param['register_state']         = FALSE;
            
            $this->html->enableSection('main', $param);
        }
    }
    
    public static function makeTextQuestion($param)
    {        
        $form = new BootstrapFormBuilder('question_form_' . $param['id']);
        
        $id       = new THidden('id');
        $pergunta = new TText('pergunta');
        $resposta = new TText('resposta');
        
        $pergunta->style = 'font-size: 16px';
        $pergunta->setEditable(FALSE);

        $pergunta->setSize('100%', '11px');
        $resposta->setSize('100%');
        
        $resposta->placeholder = 'Digite a resposta aqui';
        
        $row = $form->addFields([$id]);
        $row = $form->addFields([NULL, $pergunta]);
        $row->layout = ['col-sm-12'];
        $row->class = "question-div-text";
        $row = $form->addFields([NULL, $resposta]);
        $row->layout = ['col-sm-12'];
        $row->class = "question-div-text";
        
        $id->setValue($param['id']);

        TTransaction::open('projeto');
        $questao = new Questao($param['id']);
        $pergunta->setValue($questao->pergunta);
        TTransaction::close();
        
        return $form;
    }

    public static function makeSelectQuestion($param)
    {
        $form = new BootstrapFormBuilder('question_form_' . $param['id']);
        
        $id             = new THidden('id');
        $pergunta = new TText('pergunta');
        
        $id_alternativa = new THidden("id_alternativa[]");
        $descricao      = new TEntry("descricao[]");
        $is_correta     = new TCombo("is_correta[]");
        
        $is_correta->addItems([TRUE => 'Correta', FALSE => 'Incorreta']);
        $is_correta->class = 'tfield';
        $is_correta->setValue(0);
        
        $alternativas = new TCheckGroup('alternativas');
        
        $pergunta->placeholder  = 'Digite a questão aqui';
        $pergunta->style = 'font-size: 16px';
        $pergunta->setEditable(FALSE);
        $pergunta->setSize('100%', '11px');
        
        $descricao->setSize('100%');
        $descricao->placeholder = 'Alternativa';
        
        $row = $form->addFields([$id]);
        $row = $form->addFields([NULL, $pergunta]);
        $row->layout = ['col-sm-12'];
        $row->class = "question-div-text";
        $row = $form->addFields([NULL, $alternativas]);
        $row->layout = ['col-sm-12'];
        $row->class = "prova-form";
        
        $id->setValue($param['id']);

        TTransaction::open('projeto');

        $questao = new Questao($param['id']);
        $questao_alternativas = $questao->getAlternativas();
        $questao_alternativas_ids = array();
        if($questao_alternativas)
        {
            foreach ($questao_alternativas as $key => $alternativa) 
            {
                $questao_alternativas_ids[$alternativa->id] = $alternativa->descricao;
            }
        }

        $alternativas->addItems($questao_alternativas_ids);
        $pergunta->setValue($questao->pergunta);

        TTransaction::close();

        return $form;
    }
    
    public static function replaceQuestion($param)
    {
        if($param['type'] === 'text')
        {
            $form = self::makeTextQuestion($param);
        }
        else
        {
            $form = self::makeSelectQuestion($param);
        }
        
        $replace['id']                     = $param['id'];
        $replace['question']               = $form;
        $question = new THtmlRenderer("app/resources/html/panel_question_aluno.html");
        $question->enableSection('main', $replace);
        
        $question_html = $question->getContents();
        $question_html = str_replace("\'", "'", $question_html);
        $question_html = str_replace("'", "\'", $question_html);
        
        TScript::create("$(\"#question_" . $param['id'] . "\").empty().append('{$question_html}');");
    }

    public static function addQuestion($param)
    {
        TTransaction::open('projeto');
        $question = new Questao();
        $question->prova_id = $param['ref_prova'];
        $question->store();
        TTransaction::close();
        
        //append div to add question
        TScript::create("$('.panel-question-body').append('<div id=\"question_{$question->id}\"></div>');");
        
        // action to load blank question 
        $param_question['register_state'] = 'false';
        $param_question['ref_prova']      = $param['ref_prova'];
        $param_question['id']             = $question->id;
        $action = new TAction(['QuestaoAlunoView', 'onLoad'], $param_question);
        $action = $action->serialize();
        
        //execute action to add blank question
        TScript::create("$(document).ready(function(){ change_page('{$question->id}', '{$action}'); });");
        
        TScript::create("document.getElementById('question_{$question->id}').scrollIntoView();");
        // document.getElementById('myDiv').scrollIntoView();    
    }

    public static function editQuestion($param)
    {        
        TTransaction::open('projeto');
        $question = new Questao($param['key']);
        TTransaction::close();

        TScript::create("$('.panel-question-body').append('<div id=\"question_{$question->id}\"></div>');");

        // action to load blank question 
        $param_question['register_state'] = 'false'; 
        $param_question['ref_prova']      = $question->prova_id;
        $param_question['id']             = $question->id;

        $action = new TAction(['QuestaoAlunoView', 'onLoad'], $param_question);
        $action = $action->serialize();
        
        //execute action to add blank question
        TScript::create("$(document).ready(function(){ change_page('{$question->id}', '{$action}'); });");
        
        TScript::create("document.getElementById('question_{$question->id}').scrollIntoView();");
    }


    public static function deleteQuestion($param)
    {
        try 
        {
            TTransaction::open('projeto');
            
            $question = new Questao($param['id']);
            $question->delete();
                        
            //remove div question
            TScript::create("$('#question_{$param['id']}').remove();");    
            
            TToast::show('success', 'Registro excluido com sucesso');
            
            TTransaction::close();
        }
        catch (Exception $e) // in case of exception
        {
            TToast::show('error', 'Ocorreu um erro ao excluir o registro');
            TTransaction::rollback();
        }
    }

    public static function onSave($param)
    {
        try 
        {
            TTransaction::open('projeto');
            
            if(isset($param['descricao']) AND is_array($param['descricao']))
            {
                if(count($param['descricao']) > 1)
                {
                    $criteria =  new TCriteria();
                    $criteria->add(new TFilter('questao_id', '=', $param['id']));
                    $alternativas_old = Alternativa::getObjects($criteria);
                    foreach($alternativas_old AS $alternativa_old)
                    {
                        $alternativa_old->delete();
                    }

                    foreach($param['descricao'] AS $key => $descricao)
                    {
                        $alternativa = new Alternativa();
                        $alternativa->descricao  =  empty($param['descricao'][$key])  ? 'Alternativa '. $key : $param['descricao'][$key];
                        $alternativa->is_correta =  empty($param['is_correta'][$key]) ? FALSE : $param['is_correta'][$key];
                        $alternativa->questao_id =  $param['id'];
                        $alternativa->store();
                    }
                    $param['is_multipla_escolha'] = TRUE;
                }
                else
                {
                    TToast::show('error', 'Para questoes desse tipo adicione ao menos duas alternativas');
                    return;
                }
            }
            
            $questao = new Questao();
            $questao->id = $param['id'];
            $questao->pergunta = isset($param['pergunta']) ? $param['pergunta'] : 'Questão sem título';
            $questao->resposta = isset($param['resposta']) ? $param['resposta'] : NULL;
            $questao->is_obrigatoria = $param['is_obrigatoria'];
            $questao->peso = $param['peso'];
            $questao->is_multipla_escolha = isset($param['is_multipla_escolha']) ? TRUE : FALSE;
            $questao->minutos_realizacao = isset($param['minutos_realizacao']) ? $param['minutos_realizacao'] : 0;
            $questao->store();

            TToast::show('success', 'Registro salvo com sucesso');
            
            TTransaction::close();
        }
        catch (Exception $e) // in case of exception
        {
            TToast::show('error', 'Ocorreu um erro ao salvar o registro');
            TTransaction::rollback();
        }

    }
    
}
