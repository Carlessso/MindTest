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
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct($param)
    {
        parent::__construct();
        
        // TScript::create('$(\'#leftsidebar\').hide();$(\'.navbar\').hide();');
        TScript::create('hideMenu();');

        $html = new THtmlRenderer('app/resources/html/folder_one.html');

        $html->enableSection('main', array());

        parent::add($html);
    }
    
    /**
     *
     */
    public function onView($param)
    {
    }
    
}
