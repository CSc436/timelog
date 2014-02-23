<?php

class LogEntry extends Eloquent {

    protected $table = 'log_entry';
	protected $primaryKey = 'LID';
	protected $softDelete = true;

}

?>