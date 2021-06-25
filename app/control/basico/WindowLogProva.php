<?php
/**
 * WindowLogProva
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class WindowLogProva extends TWindow
{
    protected $form; // form
    protected $datagrid; // datagrid
    private $pageNavigation;    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        parent::setSize(800, null);
        parent::setTitle('Registros da prova do aluno');
        parent::setProperty('class', 'window_modal');
        
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_id  = new TDataGridColumn('descricao', "Ação", 'center');
        $column_data = new TDataGridColumn('data', "Momento", 'left');

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_data);

        $this->datagrid->createModel();
        
                $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());


        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%; margin:40px';
        $container->add($this->datagrid);
        $container->add($this->pageNavigation);

        parent::add($container);
    }
    
    public function onLoad($param)
    {
        $this->onReload($param);
    }

    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'projeto'
            TTransaction::open('projeto');

            // creates a repository for UsuarioProva
            $repository = new TRepository('LogAlunoProva');

            $usuario_prova = new UsuarioProva($param['key']);

            $prova = $usuario_prova->prova;

            $criteria = new TCriteria;
            $criteria->add(new TFilter('prova_id','=', $prova->id));

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    $item = new stdClass;
                    $item->descricao = $object->descricao;
                    $item->data = TDateTime::convertToMask($object->data_operacao, 'yyyy-mm-dd', 'dd/mm/yyyy H:i:s');

                    $row = $this->datagrid->addItem($item);
                    $row->id = "row_{$object->id}";

                }
            }

            // reset the criteria for record count

            // close the transaction
            $this->loaded = true;

            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit(10);
            TTransaction::close();

            return $objects;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }
    public function onSend($param)
    {
        try
        {
            // get the form data
            $data = $this->form->getData();
            // validate data
            $this->form->validate();
            
            TTransaction::open('permission');
            $preferences = SystemPreference::getAllPreferences();
            TTransaction::close();
            
            MailService::send( trim($preferences['mail_support']), $data->subject, $data->message );
            
            // shows the success message
            new TMessage('info', _t('Message sent successfully'));
        }
        catch (Exception $e) // in case of exception
        {
            // get the form data
            $object = $this->form->getData();
            
            // fill the form with the active record data
            $this->form->setData($object);
            
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            
            // undo all pending operations
            TTransaction::rollback();
        }
    }
}
