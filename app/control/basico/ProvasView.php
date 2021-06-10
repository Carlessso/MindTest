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

        $provas      = Prova::getObjects();
        $provas_html = $this->makeProvas($provas);
        // $this->form_title = $this->makeFormularioTitle($param);
        
        // $this->html->enableSection('main', array('form_title' => $this->form_title, 'form' => $this->form));
        
        parent::add($this->html);
        parent::add($provas_html);

        TTransaction::close();
    }
    
    private function makeProvas($provas)
    {
        $row        = new TElement('div');
        $row->style = 'display: flex; flex-wrap: wrap; margin: 0px 40px';

        $template = new THtmlRenderer('app/resources/html/prova_div_new.html');
        $template->enableSection('main');

        $row->add($template);

        foreach ($provas as $prova)
        {
            $replaces = array('prova_id' => $prova->id,
                              'titulo'   => $prova->nome,
                              'datas'    => $prova->inicio);

            $template = new THtmlRenderer('app/resources/html/prova_div.html');
            $template->enableSection('main', $replaces);

            $row->add($template);
        }

        return $row;
    }

}
