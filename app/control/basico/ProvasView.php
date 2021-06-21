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
class ProvasView extends TPage
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

        $this->html = new THtmlRenderer('app/resources/html/provas_view.html');
        $this->html->enableSection('main', array());
        
        TTransaction::open('projeto');

        $login   = TSession::getValue('login');
        $usuario = Usuario::getUsuarioByLogin($login);

        $provas_professor      = Prova::where('usuario_responsavel', '=', $usuario->id)->load();
        $provas_professor_html = $this->makeProvasProfessor($provas_professor);
        
        $provas_aluno      = Usuario::getProvasByLogin($login);
        $provas_aluno_html = $this->makeProvasAluno($provas_aluno);

        Usuario::getProvasByLogin($login);

        parent::add($this->html);
        parent::add($provas_professor_html);
        parent::add($provas_aluno_html);

        TTransaction::close();
    }
    
    private function makeProvasProfessor($provas)
    {
        $row        = new TElement('div');
        $row->style = 'display: flex; flex-wrap: wrap; margin: 0px 40px';
        $row->id    = 'div_provas_professor';

        $template = new THtmlRenderer('app/resources/html/prova_div_new.html');
        $template->enableSection('main');

        $row->add($template);

        foreach ($provas as $prova)
        {
            $action_delete = new TAction(['ProvasView', 'onDelete'], ['prova_id' => $prova->id, 'static' => 1]);
            $action_load   = new TAction(['ProvaFormView', 'onEdit'], ['key' => $prova->id, 'id' => $prova->id]);

            $replaces = array('prova_id'      => $prova->id,
                              'titulo'        => $prova->nome,
                              'datas'         => $prova->inicio,
                              'action_delete' => $action_delete->serialize(),
                              'action_load' => $action_load->serialize()
                            );

            $template = new THtmlRenderer('app/resources/html/prova_div.html');
            $template->enableSection('main', $replaces);

            $row->add($template);
        }

        return $row;
    }

    private function makeProvasAluno($provas)
    {
        $row        = new TElement('div');
        $row->style = 'display: flex; flex-wrap: wrap; margin: 0px 40px; display: none';
        $row->id    = 'div_provas_aluno';

        foreach ($provas as $prova)
        {
            $action_delete = new TAction(['ProvasView', 'onDelete'], ['prova_id' => $prova->id, 'static' => 1]);
            $action_load   = new TAction(['ProvasAlunoView', 'onEdit'], ['key' => $prova->id, 'id' => $prova->id]);
            
            // index.php?class=ProvaFormView&method=onEdit&key={$prova_id}&id={$prova_id}

            $replaces = array('prova_id'      => $prova->id,
                              'titulo'        => $prova->nome,
                              'datas'         => $prova->inicio,
                              'action_delete' => $action_delete->serialize(),
                              'action_load'   => $action_load->serialize()
                            );

            $template = new THtmlRenderer('app/resources/html/prova_div.html');
            $template->enableSection('main', $replaces);

            $row->add($template);
        }

        return $row;
    }
 
    public function onDelete($param)
    {
        if(isset($param['delete_prova']) && $param['delete_prova'] == 1)
        {
            try
            {
                if($param['prova_id'])
                {
                    TTransaction::open('projeto');

                    $prova = new Prova($param['prova_id']);
                    $prova->delete();            
                    
                    TTransaction::close();
                    
                    TApplication::loadPage('ProvasView', 'onLoad', $loadPageParam); 
                    
                    TToast::show('success', AdiantiCoreTranslator::translate('Record deleted'), 'topRight', 'far:check-circle');
                }
                else
                {
                    throw new Exception("Error Processing Request", 1);
                }
            }
            catch (Exception $e) // in case of exception
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());
                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters($param); // pass the key paramseter ahead
            $action->setParameter('delete_prova', 1);
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }

    public function onAddGrupos()
    {
        $window = TWindow::create('Grupos', 0.5, 0.6);
      


        $window->show();
    }

    public function onLoad()
    {

    }

}
