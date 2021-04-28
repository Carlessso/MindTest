<?php
/**
 * SystemRequestLogList
 *
 * @version    1.0
 * @package    control
 * @subpackage log
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class SystemRequestLogList extends TStandardList
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('log');            // defines the database
        parent::setActiveRecord('SystemRequestLog');   // defines the active record
        parent::setDefaultOrder('id', 'desc');         // defines the default order
        parent::addFilterField('login', 'like'); // add a filter field
        parent::addFilterField('class_name', 'like'); // add a filter field
        parent::addFilterField('session_id', 'like'); // add a filter field
        parent::addFilterField('endpoint', '='); // add a filter field
        parent::setLimit(20);
        
        // creates the form, with a table inside
        $this->form = new BootstrapFormBuilder('form_search_SystemRequestLog');
        $this->form->setFormTitle(_t('Request Log'));
        
        // create the form fields
        $login       = new TEntry('login');
        $class_name  = new TEntry('class_name');
        $session_id  = new TEntry('session_id');
        $endpoint    = new TCombo('endpoint');

        $endpoint->addItems( [ 'cli' => 'CLI', 'rest' => 'REST', 'web' => 'WEB' ]);
        
        // add the fields
        $this->form->addFields( [new TLabel(_t('Login'))], [$login], [new TLabel(_t('Program'))], [$class_name] );
        $this->form->addFields( [new TLabel(_t('Session'))], [$session_id], [new TLabel('Endpoint')], [$endpoint] );
        $login->setSize('70%');
        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('SystemRequestLog_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        
        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TQuickGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        $this->datagrid->setHeight(320);
        

        // creates the datagrid columns
        $id = $this->datagrid->addQuickColumn('id', 'id', 'center');
        $logdate = $this->datagrid->addQuickColumn(_t('Time'), 'logdate', 'center');
        $sessionid = $this->datagrid->addQuickColumn('sessionid', 'session_id', 'left');
        $login = $this->datagrid->addQuickColumn(_t('Login'), 'login', 'center');
        $access_ip = $this->datagrid->addQuickColumn('IP', 'access_ip', 'center');
        $class_name = $this->datagrid->addQuickColumn(_t('Program'), 'class_name', 'center');
        $endpoint = $this->datagrid->addQuickColumn('Endpoint', 'endpoint', 'center');
        $req_method = $this->datagrid->addQuickColumn(_t('Method'), 'request_method', 'center');
        
        $action1 = new TDataGridAction(['SystemRequestLogView', 'onLoad'],
                                       ['id'=>'{id}',
                                        'register_state'   => 'false'] );
        $action1->setUseButton(TRUE);
        $action1->setButtonClass('btn btn-default');
        $this->datagrid->addAction($action1, 'View', 'fa:search blue');
        
        $action2 = new TDataGridAction(['SystemSqlLogList', 'filterRequest'],
                                       ['request_id'=>'{id}'] );
        $action2->setUseButton(TRUE);
        $action2->setButtonClass('btn btn-default');
        $this->datagrid->addAction($action2, 'SQL', 'fa:database orange');
        
        $endpoint->setTransformer(function($value) {
            return strtoupper($value);
        });
        
        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $id->setAction($order_id);
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
       
        $headerActions = new TElement('div');
        $headerActions->class = ' datagrid-header-actions ';

        $head_left_actions = new TElement('div');
        $head_left_actions->class = ' datagrid-header-actions-left-actions ';

        $head_right_actions = new TElement('div');
        $head_right_actions->class = ' datagrid-header-actions-left-actions ';

        $headerActions->add($head_left_actions);
        $headerActions->add($head_right_actions);

        $panel = new TPanelGroup;
        $panel->add($headerActions);
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);

        $dropdown_button_exportar = new TDropDown("Exportar", 'fas:file-export #2d3436');
        $dropdown_button_exportar->setPullSide('right');
        $dropdown_button_exportar->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['SystemRequestLogList', 'onExportCsv']), 'form_search_SystemSqlLog', 'fas:table #00b894' );
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['SystemRequestLogList', 'onExportPdf']), 'form_search_SystemSqlLog', 'far:file-pdf #e74c3c' );

        // $head_left_actions->add($button_cadastrar);

        $head_right_actions->add($dropdown_button_exportar);

        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add($panel);
        
        parent::add($container);
    }
    
    /**
     *
     */
    public function filterSession($param)
    {
        parent::clearFilters();
        
        $data = new stdClass;
        $data->session_id = $param['session_id'];
        $this->form->setData($data);
        
        $criteria = new TCriteria;
        $criteria->add(new TFilter('session_id', 'like', $param['session_id']));
        parent::setCriteria($criteria);
        
        $this->onReload($param);
    }


    public function onExportCsv($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.csv';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $objects = $this->onReload();

                if ($objects)
                {
                    $handler = fopen($output, 'w');
                    TTransaction::open('projeto');

                    foreach ($objects as $object)
                    {
                        $row = [];
                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();

                            if (isset($object->$column_name))
                            {
                                $row[] = is_scalar($object->$column_name) ? $object->$column_name : '';
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos($column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $row[] = $object->render($column_name);
                            }
                        }

                        fputcsv($handler, $row);
                    }

                    fclose($handler);
                    TTransaction::close();
                }
                else
                {
                    throw new Exception(_t('No records found'));
                }

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }

    public function onExportPdf($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.pdf';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $this->datagrid->prepareForPrinting();
                $this->onReload();

                $html = clone $this->datagrid;
                $contents = file_get_contents('app/resources/styles-print.html') . $html->getContents();

                $dompdf = new \Dompdf\Dompdf;
                $dompdf->loadHtml($contents);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                file_put_contents($output, $dompdf->output());

                $window = TWindow::create('PDF', 0.8, 0.8);
                $object = new TElement('object');
                $object->data  = $output;
                $object->type  = 'application/pdf';
                $object->style = "width: 100%; height:calc(100% - 10px)";

                $window->add($object);
                $window->show();
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }

}
