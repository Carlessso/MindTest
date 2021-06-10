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
class LoginUsuario extends TPage
{
    protected $form; // form
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    public function __construct($param)
    {
        parent::__construct();
        
        $html = new THtmlRenderer('app/resources/html/login.html');
        $html->enableSection('main', array());
        
        parent::add($html);
    }
    
    /**
     * user exit action
     * Populate unit combo
     */
    public static function onExitUser($param)
    {
        try
        {
            TTransaction::open('permission');
            
            $user = SystemUser::newFromLogin( $param['login'] );
            if ($user instanceof SystemUser)
            {
                $units = $user->getSystemUserUnits();
                $options = [];
                
                if ($units)
                {
                    foreach ($units as $unit)
                    {
                        $options[$unit->id] = $unit->name;
                    }
                }
                TCombo::reload('form_login', 'unit_id', $options);
            }
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error',$e->getMessage());
            TTransaction::rollback();
        }
    }
    
    /**
     * Authenticate the User
     */
    public static function onLogin($param)
    {
        $ini  = AdiantiApplicationConfig::get();

        try
        {
            $data = (object) $param;
            
            (new TRequiredValidator)->validate( _t('Login'),    $data->login);
            (new TRequiredValidator)->validate( _t('Password'), $data->password);
            
            if (!empty($ini['general']['multiunit']) and $ini['general']['multiunit'] == '1')
            {
                (new TRequiredValidator)->validate( _t('Unit'), $data->unit_id);
            }
            
            TSession::regenerate();
            $user = ApplicationAuthenticationService::authenticate( $data->login, $data->password );
            if ($user)
            {
                ApplicationAuthenticationService::setUnit( $data->unit_id ?? null );
                ApplicationAuthenticationService::setLang( $data->lang_id ?? null );

                SystemAccessLogService::registerLogin();
                AdiantiCoreApplication::gotoPage("ProvasView"); // reload

                $frontpage = $user->frontpage;
                // if (!empty($param['previous_class']) && $param['previous_class'] !== 'LoginForm')
                // {
                //     AdiantiCoreApplication::gotoPage($param['previous_class'], $param['previous_method'], unserialize($param['previous_parameters'])); // reload
                // }
                // elseif ($frontpage instanceof SystemProgram and $frontpage->controller)
                // {
                //     AdiantiCoreApplication::gotoPage($frontpage->controller); // reload
                //     TSession::setValue('frontpage', $frontpage->controller);
                // }
                // else
                // {
                //     AdiantiCoreApplication::gotoPage('EmptyPage'); // reload
                //     TSession::setValue('frontpage', 'EmptyPage');
                // }
            }
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error',$e->getMessage());
            TSession::setValue('logged', FALSE);
            TTransaction::rollback();
        }
    }
    
    /** 
     * Reload permissions
     */
    public static function reloadPermissions()
    {
        try
        {
            TTransaction::open('permission');
            $user = SystemUser::newFromLogin( TSession::getValue('login') );
            
            if ($user)
            {
                $programs = $user->getPrograms();
                $programs['LoginForm'] = TRUE;
                TSession::setValue('programs', $programs);
                
                $frontpage = $user->frontpage;
                if ($frontpage instanceof SystemProgram AND $frontpage->controller)
                {
                    TApplication::gotoPage($frontpage->controller); // reload
                }
                else
                {
                    TApplication::gotoPage('EmptyPage'); // reload
                }
            }
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    
    /**
     *
     */
    public function onLoad($param)
    {
    }
    
    /**
     * Logout
     */
    public static function onLogout()
    {
        SystemAccessLogService::registerLogout();
        TSession::freeSession();
        AdiantiCoreApplication::gotoPage('LoginForm', '');
    }
}
