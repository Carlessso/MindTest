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
class ProvaControleProfessorView extends TPage
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

        $this->html = new THtmlRenderer('app/resources/html/prova_professor.html');
        
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

        $usuario_prova = new UsuarioProva($param['key']);

        $prova = $usuario_prova->prova;

        TSession::setValue('prova_id', $prova->id);

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

        $questoes = Questao::where('prova_id', '=', $prova->id)->orderBy('id', 'asc')->load();
        
        foreach ($questoes as $questao) 
        {        
            $questoes_usuario = QuestaoUsuarioProva::where('usuario_prova_id', '=', $usuario_prova->id)->where('questao_id', '=', $questao->id)->load();

            foreach($questoes_usuario as $questao_usuario)
            {
                if (!empty($questao_usuario->resposta_usuario)) //buscar questao responder
                {
                    QuestaoAlunoView::editQuestion(['key' => $questao->id, 'value' => $questao_usuario->resposta_usuario]);
                }
                else//questao marcar
                {
                    QuestaoAlunoView::editQuestion(['key' => $questao->id, 'value' => AlternativaRespostaQuestao::where('questao_usuario_prova_id', '=', $questao_usuario->id)->load()]);
                }
            }
        }

        TTransaction::close();
    }

    public static function onSaveRespostas($data)
    {
        try 
        {
            TTransaction::open('projeto');
            
            $usuario_prova = new UsuarioProva();
            
            $usuario_prova->usuario_id = TSession::getValue('userid');
            $usuario_prova->prova_id   = TSession::getValue('prova_id');
            $usuario_prova->inicio     = date('Y-m-d H:i:s');
            $usuario_prova->fim        = date('Y-m-d H:i:s');

            $usuario_prova->store();
            
            $prova = $usuario_prova->prova;
    
            $questoes = $prova->getQuestaos();

            foreach($questoes as $questao)
            {
                if (!empty($data['alternativas_'.$questao->id])) 
                {
                    $alternativas_marcadas = $data['alternativas_'.$questao->id];
                    
                    $questao_usuario_prova = new QuestaoUsuarioProva;

                    $questao_usuario_prova->questao_id       = $questao->id;
                    $questao_usuario_prova->usuario_prova_id = $usuario_prova->id;
                    $questao_usuario_prova->peso             = $questao->peso;
                    $questao_usuario_prova->dt_registro      = date('Y-m-d');

                    $questao_usuario_prova->store();

                    foreach($alternativas_marcadas as $alternativa)
                    {
                        $alternativa_resposta = new AlternativaRespostaQuestao;
                        
                        $alternativa_resposta->alternativa_id           = $alternativa;
                        $alternativa_resposta->questao_usuario_prova_id = $questao_usuario_prova->id;

                        $alternativa_resposta->store();
                    }
                }
                else if(!empty($data['resposta_'.$questao->id]))
                {
                    $questao_usuario_prova = new QuestaoUsuarioProva;

                    $questao_usuario_prova->questao_id       = $questao->id;
                    $questao_usuario_prova->usuario_prova_id = $usuario_prova->id;
                    $questao_usuario_prova->peso             = $questao->peso;
                    $questao_usuario_prova->dt_registro      = date('Y-m-d');
                    $questao_usuario_prova->resposta_usuario = $data['resposta_'.$questao->id];

                    $questao_usuario_prova->store();
                }
            }

            TTransaction::close();

            new TMessage('info', 'Suas respostas foram salvas!', new TAction(['ProvasView', 'onLoad']));
        }
        catch (Exception $e) 
        {
            TToast::show('erro', 'Ocorreu um erro ao salvar');
            TTransaction::rollback();
        }
    }
}
