<?php

class autoloader {
	
	function __construct($bLocal = FALSE, $bSubDir = FALSE) {
		// $bLocal BOOL - being called from within the same directory
		// $bSubDir BOOL - need an extra /../		
		if ($bLocal) {
			require_once ("resources.php");
			spl_autoload_register('self::autoloadLocal');
		} elseif($bSubDir) {
			require_once ("../../../../resources/resources.php");
			spl_autoload_register('self::autoloadResourcesSubDir');
		}
		else {
			require_once ("../../../resources/resources.php");
			spl_autoload_register('self::autoloadResources');
		}
		
	}
	
	
	private function autoloadResources($className) {
		$dirs = array(
			'../../../resources/', 
			'../../../resources/generated/',
		);
		
		foreach( $dirs as $dir ) {
			if (file_exists($dir . $className.'.php')) {
				require_once($dir . $className.'.php');
				break;
			}
		}
			
	}
	
	private function autoloadResourcesSubDir($className) {
		$dirs = array(
			'../../../../resources/',
			'../../../../resources/generated/',
		);
		
		foreach( $dirs as $dir ) {
			if (file_exists($dir . $className.'.php')) {
				require_once($dir . $className.'.php');
				break;
			}
		}
		
	}
	
	private function autoloadLocal($className) {
		require ($className . ".php");
	}
	
}