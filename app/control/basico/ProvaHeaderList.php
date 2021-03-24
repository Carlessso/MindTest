<?php

class ProvaHeaderList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'projeto';
    private static $activeRecord = 'Prova';
    private static $primaryKey = 'id';
    private static $formName = 'formHeader_Prova';
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
        $nome = new TEntry('nome');
        $sucinto = new TEntry('sucinto');
        $minutos_realizacao = new TEntry('minutos_realizacao');
        $cor_primaria = new TEntry('cor_primaria');
        $cor_secundaria = new TEntry('cor_secundaria');
        $usuario_responsavel = new TDBCombo('usuario_responsavel', 'projeto', 'Usuario', 'id', '{id}','id asc'  );
        $is_publica = new TEntry('is_publica');
        $inicio = new TEntry('inicio');
        $fim = new TEntry('fim');

        $id->exitOnEnter();
        $nome->exitOnEnter();
        $sucinto->exitOnEnter();
        $minutos_realizacao->exitOnEnter();
        $cor_primaria->exitOnEnter();
        $cor_secundaria->exitOnEnter();
        $is_publica->exitOnEnter();
        $inicio->exitOnEnter();
        $fim->exitOnEnter();

        $id->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        $nome->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        $sucinto->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        $minutos_realizacao->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        $cor_primaria->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        $cor_secundaria->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        $is_publica->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        $inicio->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));
        $fim->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1']));

        $usuario_responsavel->setChangeAction(new TAction([$this, 'onSearch'], ['static'=>'1']));

        $id->setSize('100%');
        $fim->setSize('100%');
        $nome->setSize('100%');
        $inicio->setSize('100%');
        $sucinto->setSize('100%');
        $is_publica->setSize('100%');
        $cor_primaria->setSize('100%');
        $cor_secundaria->setSize('100%');
        $minutos_realizacao->setSize('100%');
        $usuario_responsavel->setSize('100%');

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
        $column_nome = new TDataGridColumn('nome', "Nome", 'left');
        $column_sucinto = new TDataGridColumn('sucinto', "Sucinto", 'left');
        $column_minutos_realizacao = new TDataGridColumn('minutos_realizacao', "Minutos realizacao", 'left');
        $column_cor_primaria = new TDataGridColumn('cor_primaria', "Cor primaria", 'left');
        $column_cor_secundaria = new TDataGridColumn('cor_secundaria', "Cor secundaria", 'left');
        $column_usuario_responsavel = new TDataGridColumn('usuario_responsavel', "Usuario responsavel", 'left');
        $column_is_publica = new TDataGridColumn('is_publica', "Is publica", 'left');
        $column_inicio = new TDataGridColumn('inicio', "Inicio", 'left');
        $column_fim = new TDataGridColumn('fim', "Fim", 'left');

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_sucinto);
        $this->datagrid->addColumn($column_minutos_realizacao);
        $this->datagrid->addColumn($column_cor_primaria);
        $this->datagrid->addColumn($column_cor_secundaria);
        $this->datagrid->addColumn($column_usuario_responsavel);
        $this->datagrid->addColumn($column_is_publica);
        $this->datagrid->addColumn($column_inicio);
        $this->datagrid->addColumn($column_fim);

        $action_onEdit = new TDataGridAction(array('ProvaForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('ProvaHeaderList', 'onDelete'));
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
        $tr->add(TElement::tag('td', $nome));
        $tr->add(TElement::tag('td', $sucinto));
        $tr->add(TElement::tag('td', $minutos_realizacao));
        $tr->add(TElement::tag('td', $cor_primaria));
        $tr->add(TElement::tag('td', $cor_secundaria));
        $tr->add(TElement::tag('td', $usuario_responsavel));
        $tr->add(TElement::tag('td', $is_publica));
        $tr->add(TElement::tag('td', $inicio));
        $tr->add(TElement::tag('td', $fim));

        $this->datagrid_form->addField($id);
        $this->datagrid_form->addField($nome);
        $this->datagrid_form->addField($sucinto);
        $this->datagrid_form->addField($minutos_realizacao);
        $this->datagrid_form->addField($cor_primaria);
        $this->datagrid_form->addField($cor_secundaria);
        $this->datagrid_form->addField($usuario_responsavel);
        $this->datagrid_form->addField($is_publica);
        $this->datagrid_form->addField($inicio);
        $this->datagrid_form->addField($fim);

        $this->datagrid_form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup("Listagem de provas");
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

        // $button_cadastrar = new TButton('button_button_cadastrar');
        // $button_cadastrar->setAction(new TAction(['ProvaForm', 'onShow']), "Cadastrar");
        // $button_cadastrar->addStyleClass('');
        // $button_cadastrar->setImage('fas:plus #69aa46');
        // $this->datagrid_form->addField($button_cadastrar);

        $button_cadastrar_prova = new TButton('button_button_cadastrar_form');
        $button_cadastrar_prova->setAction(new TAction(['ProvaFormView', 'onView']), "Prova tela final");
        $button_cadastrar_prova->addStyleClass('');
        $button_cadastrar_prova->setImage('fas:plus #69aa46');
        $this->datagrid_form->addField($button_cadastrar_prova);
        
        $dropdown_button_exportar = new TDropDown("Exportar", 'fas:file-export #2d3436');
        $dropdown_button_exportar->setPullSide('right');
        $dropdown_button_exportar->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['ProvaHeaderList', 'onExportCsv']), 'datagrid_'.self::$formName, 'fas:table #00b894' );
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['ProvaHeaderList', 'onExportPdf']), 'datagrid_'.self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['ProvaHeaderList', 'onExportXml']), 'datagrid_'.self::$formName, 'far:file-code #95a5a6' );
        
        $head_left_actions->add($button_cadastrar_prova);
        
        $head_right_actions->add($dropdown_button_exportar);
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Básico","Provas"]));
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
                $object = new Prova($key, FALSE); 

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

        if (isset($data->nome) AND ( (is_scalar($data->nome) AND $data->nome !== '') OR (is_array($data->nome) AND (!empty($data->nome)) )) )
        {

            $filters[] = new TFilter('nome', 'like', "%{$data->nome}%");// create the filter 
        }

        if (isset($data->sucinto) AND ( (is_scalar($data->sucinto) AND $data->sucinto !== '') OR (is_array($data->sucinto) AND (!empty($data->sucinto)) )) )
        {

            $filters[] = new TFilter('sucinto', 'like', "%{$data->sucinto}%");// create the filter 
        }

        if (isset($data->minutos_realizacao) AND ( (is_scalar($data->minutos_realizacao) AND $data->minutos_realizacao !== '') OR (is_array($data->minutos_realizacao) AND (!empty($data->minutos_realizacao)) )) )
        {

            $filters[] = new TFilter('minutos_realizacao', '=', $data->minutos_realizacao);// create the filter 
        }

        if (isset($data->cor_primaria) AND ( (is_scalar($data->cor_primaria) AND $data->cor_primaria !== '') OR (is_array($data->cor_primaria) AND (!empty($data->cor_primaria)) )) )
        {

            $filters[] = new TFilter('cor_primaria', 'like', "%{$data->cor_primaria}%");// create the filter 
        }

        if (isset($data->cor_secundaria) AND ( (is_scalar($data->cor_secundaria) AND $data->cor_secundaria !== '') OR (is_array($data->cor_secundaria) AND (!empty($data->cor_secundaria)) )) )
        {

            $filters[] = new TFilter('cor_secundaria', 'like', "%{$data->cor_secundaria}%");// create the filter 
        }

        if (isset($data->usuario_responsavel) AND ( (is_scalar($data->usuario_responsavel) AND $data->usuario_responsavel !== '') OR (is_array($data->usuario_responsavel) AND (!empty($data->usuario_responsavel)) )) )
        {

            $filters[] = new TFilter('usuario_responsavel', '=', $data->usuario_responsavel);// create the filter 
        }

        if (isset($data->is_publica) AND ( (is_scalar($data->is_publica) AND $data->is_publica !== '') OR (is_array($data->is_publica) AND (!empty($data->is_publica)) )) )
        {

            $filters[] = new TFilter('is_publica', '=', $data->is_publica);// create the filter 
        }

        if (isset($data->inicio) AND ( (is_scalar($data->inicio) AND $data->inicio !== '') OR (is_array($data->inicio) AND (!empty($data->inicio)) )) )
        {

            $filters[] = new TFilter('inicio', '=', $data->inicio);// create the filter 
        }

        if (isset($data->fim) AND ( (is_scalar($data->fim) AND $data->fim !== '') OR (is_array($data->fim) AND (!empty($data->fim)) )) )
        {

            $filters[] = new TFilter('fim', '=', $data->fim);// create the filter 
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

            // creates a repository for Prova
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

