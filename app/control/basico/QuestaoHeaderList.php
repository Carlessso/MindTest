<?php

class QuestaoHeaderList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'projeto';
    private static $activeRecord = 'Questao';
    private static $primaryKey = 'id';
    private static $formName = 'formHeader_Questao';
    private $showMethods = ['onReload', 'onSearch'];
    private $limit = 20;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();
        // creates the form

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        $this->limit = 20;

        $id = new TEntry('id');
        $pergunta = new TEntry('pergunta');
        $is_multipla_escolha = new TEntry('is_multipla_escolha');
        $prova_id = new TDBCombo('prova_id', 'projeto', 'Prova', 'id', '{nome}','id asc'  );
        // $minutos_realizacao = new TEntry('minutos_realizacao');
        $peso = new TEntry('peso');
        $is_obrigatoria = new TEntry('is_obrigatoria');

        $id->exitOnEnter();
        $pergunta->exitOnEnter();
        $is_multipla_escolha->exitOnEnter();
        // $minutos_realizacao->exitOnEnter();
        $peso->exitOnEnter();
        $is_obrigatoria->exitOnEnter();

        $id->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        $pergunta->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        $is_multipla_escolha->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        // $minutos_realizacao->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        $peso->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        $is_obrigatoria->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));

        $prova_id->setChangeAction(new TAction([$this, 'onSearch'], ['static'=>'1']));

        $id->setSize('100%');
        $peso->setSize('100%');
        $pergunta->setSize('100%');
        $prova_id->setSize('100%');
        $is_obrigatoria->setSize('100%');
        // $minutos_realizacao->setSize('100%');
        $is_multipla_escolha->setSize('100%');

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_pergunta = new TDataGridColumn('pergunta', "Pergunta", 'left');
        $column_is_multipla_escolha = new TDataGridColumn('is_multipla_escolha', "Multipla escolha?", 'left');
        $column_prova_id = new TDataGridColumn('prova->nome', "Prova", 'left');
        // $column_minutos_realizacao = new TDataGridColumn('minutos_realizacao', "Minutos realizacao", 'left');
        $column_peso = new TDataGridColumn('peso', "Peso", 'left');
        $column_is_obrigatoria = new TDataGridColumn('is_obrigatoria', "Obrigatoria?", 'left');

        $column_is_obrigatoria->setTransformer([$this, 'transformSimENao']);
        $column_is_multipla_escolha->setTransformer([$this, 'transformSimENao']);

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_pergunta);
        $this->datagrid->addColumn($column_is_multipla_escolha);
        $this->datagrid->addColumn($column_prova_id);
        // $this->datagrid->addColumn($column_minutos_realizacao);
        $this->datagrid->addColumn($column_peso);
        $this->datagrid->addColumn($column_is_obrigatoria);

        $action_onEdit = new TDataGridAction(array('QuestaoForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('QuestaoHeaderList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

        $tr = new TElement('tr');
        $this->datagrid->prependRow($tr);

        $tr->add(TElement::tag('td', ''));
        $tr->add(TElement::tag('td', ''));
        $tr->add(TElement::tag('td', $id));
        $tr->add(TElement::tag('td', $pergunta));
        $tr->add(TElement::tag('td', $is_multipla_escolha));
        $tr->add(TElement::tag('td', $prova_id));
        // $tr->add(TElement::tag('td', $minutos_realizacao));
        $tr->add(TElement::tag('td', $peso));
        $tr->add(TElement::tag('td', $is_obrigatoria));

        $this->datagrid_form->addField($id);
        $this->datagrid_form->addField($pergunta);
        $this->datagrid_form->addField($is_multipla_escolha);
        $this->datagrid_form->addField($prova_id);
        // $this->datagrid_form->addField($minutos_realizacao);
        $this->datagrid_form->addField($peso);
        $this->datagrid_form->addField($is_obrigatoria);

        $this->datagrid_form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup("Listagem de quest??es");
        $this->datagridPanel = $panel;

        $panel->addFooter($this->pageNavigation);

        $headerActions = new TElement('div');
        $headerActions->class = ' datagrid-header-actions ';

        $head_left_actions = new TElement('div');
        $head_left_actions->class = ' datagrid-header-actions-left-actions ';

        $head_right_actions = new TElement('div');
        $head_right_actions->class = ' datagrid-header-actions-left-actions ';

        $headerActions->add($head_left_actions);
        $headerActions->add($head_right_actions);

        $this->datagrid_form->add($this->datagrid);
        $panel->add($headerActions);
        $panel->add($this->datagrid_form);

        $button_cadastrar = new TButton('button_button_cadastrar');
        $button_cadastrar->setAction(new TAction(['QuestaoForm', 'onShow']), "Cadastrar");
        $button_cadastrar->addStyleClass('');
        $button_cadastrar->setImage('fas:plus #69aa46');
        $this->datagrid_form->addField($button_cadastrar);

        $dropdown_button_exportar = new TDropDown("Exportar", 'fas:file-export #2d3436');
        $dropdown_button_exportar->setPullSide('right');
        $dropdown_button_exportar->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['QuestaoHeaderList', 'onExportCsv']), 'datagrid_'.self::$formName, 'fas:table #00b894' );
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['QuestaoHeaderList', 'onExportPdf']), 'datagrid_'.self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['QuestaoHeaderList', 'onExportXml']), 'datagrid_'.self::$formName, 'far:file-code #95a5a6' );

        $head_left_actions->add($button_cadastrar);

        $head_right_actions->add($dropdown_button_exportar);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["B??sico","Quest??es"]));
        }

        $container->add($panel);

        parent::add($container);

    }

    public function onDelete($param = null) 
    { 
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                // get the paramseter $key
                $key = $param['key'];
                // open a transaction with database
                TTransaction::open(self::$database);

                // instantiates object
                $object = new Questao($key, FALSE); 

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                TToast::show('success', AdiantiCoreTranslator::translate('Record deleted'), 'topRight', 'far:check-circle');
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
            // define the delete action
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters($param); // pass the key paramseter ahead
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
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
                    TTransaction::open(self::$database);

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

    public function onExportXml($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.xml';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $objects = $this->onReload();

                if ($objects)
                {
                    TTransaction::open(self::$database);

                    $dom = new DOMDocument('1.0', 'UTF-8');
                    $dom->{'formatOutput'} = true;
                    $dataset = $dom->appendChild( $dom->createElement('dataset') );

                    foreach ($objects as $object)
                    {
                        $row = $dataset->appendChild( $dom->createElement( self::$activeRecord ) );

                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();
                            $column_name_raw = str_replace(['(','{','->', '-','>','}',')', ' '], ['','','_','','','','','_'], $column_name);

                            if (isset($object->$column_name))
                            {
                                $value = is_scalar($object->$column_name) ? $object->$column_name : '';
                                $row->appendChild($dom->createElement($column_name_raw, $value)); 
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos($column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $value = $object->render($column_name);
                                $row->appendChild($dom->createElement($column_name_raw, $value));
                            }
                        }
                    }

                    $dom->save($output);

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
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        // get the search form data
        $data = $this->datagrid_form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) )
        {

            $filters[] = new TFilter('id', '=', $data->id);// create the filter 
        }

        if (isset($data->pergunta) AND ( (is_scalar($data->pergunta) AND $data->pergunta !== '') OR (is_array($data->pergunta) AND (!empty($data->pergunta)) )) )
        {

            $filters[] = new TFilter('pergunta', 'like', "%{$data->pergunta}%");// create the filter 
        }

        if (isset($data->is_multipla_escolha) AND ( (is_scalar($data->is_multipla_escolha) AND $data->is_multipla_escolha !== '') OR (is_array($data->is_multipla_escolha) AND (!empty($data->is_multipla_escolha)) )) )
        {

            $filters[] = new TFilter('is_multipla_escolha', '=', $data->is_multipla_escolha);// create the filter 
        }

        if (isset($data->prova_id) AND ( (is_scalar($data->prova_id) AND $data->prova_id !== '') OR (is_array($data->prova_id) AND (!empty($data->prova_id)) )) )
        {

            $filters[] = new TFilter('prova_id', '=', $data->prova_id);// create the filter 
        }

        if (isset($data->minutos_realizacao) AND ( (is_scalar($data->minutos_realizacao) AND $data->minutos_realizacao !== '') OR (is_array($data->minutos_realizacao) AND (!empty($data->minutos_realizacao)) )) )
        {

            $filters[] = new TFilter('minutos_realizacao', '=', $data->minutos_realizacao);// create the filter 
        }

        if (isset($data->peso) AND ( (is_scalar($data->peso) AND $data->peso !== '') OR (is_array($data->peso) AND (!empty($data->peso)) )) )
        {

            $filters[] = new TFilter('peso', '=', $data->peso);// create the filter 
        }

        if (isset($data->is_obrigatoria) AND ( (is_scalar($data->is_obrigatoria) AND $data->is_obrigatoria !== '') OR (is_array($data->is_obrigatoria) AND (!empty($data->is_obrigatoria)) )) )
        {

            $filters[] = new TFilter('is_obrigatoria', '=', $data->is_obrigatoria);// create the filter 
        }

        // fill the form with data again
        $this->datagrid_form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        if (isset($param['static']) && ($param['static'] == '1') )
        {
            $class = get_class($this);
            $onReloadParam = ['offset' => 0, 'first_page' => 1];
            AdiantiCoreApplication::loadPage($class, 'onReload', $onReloadParam);
        }
        else
        {
            $this->onReload(['offset' => 0, 'first_page' => 1]);
        }
    }

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'projeto'
            TTransaction::open(self::$database);

            // creates a repository for Questao
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'id';    
            }
            if (empty($param['direction']))
            {
                $param['direction'] = 'desc';
            }

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $this->limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->id}";

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($this->limit); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;

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

    public function onShow($param = null)
    {

    }

    public function transformSimENao($param)
    {
        if($param)
        {
            return 'Sim';
        }

        return 'N??o';
    }

    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

}

