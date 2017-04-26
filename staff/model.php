<?php

class Model{
	
	
	function __construct(){

	}
	
	public static function Next($connector){
		if ($connector->fetch_object())
			return TRUE;
		else
			return FALSE;
	}
	

	public static function Query($connector, $sql){


		if ($connector->query($sql)){
			return $connector->query($sql);
		}
		else{
			return FALSE;
		}
	}

	
	public static function Fetch($connector){
			return ($connector->fetch_object());
	}
	
	
}

?>