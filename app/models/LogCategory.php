<?php

class LogCategory extends Eloquent {

    protected $table = 'log_category';
	protected $primaryKey = 'CID';
	protected $softDelete = true;
	
	public function logentries ()
	{
		return $this->hasMany('LogEntry', 'CID', 'CID');
	}

}

?>