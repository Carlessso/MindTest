<?php

class LogAlunoService
{
	public static function gravaLog($param)
	{
		$response = new stdClass;

		$response->success = FALSE;

		try 
		{
			TTransaction::open('projeto');
			
			$log = new LogAlunoProva;

			$log->descricao  = $param['descricao'];
			// $log->usuario_id = TSession::getValue('userid');
			$log->usuario_id = 1;

			$log->store();

			TTransaction::close();

			$response->success = TRUE;
		} 
		catch (Exception $e) 
		{
			$response->error = $e->getMessage();

			TTransaction::rollback();
		}

		echo json_encode($response);

	}	

}