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
class ProvasAlunoView extends TPage
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

        $this->html = new THtmlRenderer('app/resources/html/prova_aluno.html');
        
        $this->form_title = $this->makeFormularioTitle($param);
        
        $this->html->enableSection('main', array('form_title' => $this->form_title));
        
        parent::add($this->html);
    }
    
    public function makeFormularioTitle($param)
    {
        $this->form_title = new TForm('prova_form_title');
        
        $pergunta = new TEntry('nome');
        $resposta = new TEntry('descricao');

        $pergunta->class = 'panel-title';
        $resposta->class = 'panel-subtitle';
        
        $pergunta->setSize('100%');
        $resposta->setSize('100%');

        // $pergunta->setEditable(FALSE);
        // $resposta->setEditable(FALSE);
        
        $pergunta->setValue('Título do formulário');
        $resposta->setValue('Descrição');
        
        $this->form_title->setFields([$pergunta, $resposta]);
        $this->form_title->add($pergunta);
        $this->form_title->add($resposta);

        return $this->form_title;
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
        
        $object            = new StdClass();
        $object->nome      = $prova->nome;
        $object->descricao = $prova->descricao;

        $this->form_title->setData($object);

        $questoes = Questao::where('prova_id', '=', $param['key'])->orderBy('id', 'asc')->load();
        
        foreach ($questoes as $questao) 
        {
            QuestaoAlunoView::editQuestion(['key' => $questao->id]);
        }
        
        TTransaction::close();
    }
    
    public function onView($param)
    {
        TTransaction::open('projeto');

        $prova                      = new Prova();
        $prova->nome                = 'Título';
        $prova->descricao           = 'Descrição';
        $prova->cor_primaria        = '#63CCFF';
        $prova->cor_secundaria      = '#15202B';
        $prova->usuario_responsavel = 1;
        $prova->store();

        $questao            = new Questao();
        $questao->prova_id = $prova->id;
        $questao->store();

        TTransaction::close();

        TApplication::loadPage('ProvaFormView', 'onEdit', ['key' => $prova->id]); 
    }
}
