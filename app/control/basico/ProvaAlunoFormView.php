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
class ProvaAlunoFormView extends TPage
{
    protected $form; // form
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct($param)
    {
        parent::__construct();
        
        $html = new THtmlRenderer('app/resources/html/prova_aluno_form.html');

        $html->enableSection('main', []);
        $html->enableSection('question', []);
        // $html->enabelSection('multipla_escolha', []);

        // $html->enabelSection('unica_escolha', []);
        // $html->enabelSection('dissertativa', []);
        
        parent::add($html);
    }
    
    /**
     *
     */
    public function onView($param)
    {
    }
    
}
