<?php
/* 
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 */
/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/app_model.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 */
class AppModel extends Model {

	function nativeQuery($query,$Cache= false,$QryKey=null,$QryExpires=null){
		
		if(isset($query) && !empty($query) && is_string($query)){
			
			if($Cache != false && isset($QryKey) && !is_null($QryKey)){

				$key = $QryKey;
				$expires = '+1 hour';
				
				if (isset($QryExpires) && !is_null($QryExpires) ) {
					$expires=$QryExpires;
				}
				
				// cache settings
				Cache::config('sql_cache', array(
					'prefix' 	=> strtolower($this->name) .'-',
					'duration'	=> $expires
				));
				
				// read result from cache
				$results = Cache::read($key, 'sql_cache');
				
				if (!is_array($results)) {
					$results = $this->query($query);
					Cache::write($key, $results, 'sql_cache');
				}
				
				return $results;
				
			}else{
				//NON-CHACHED QUERY
				$result=$this->query($query);
				return $result;
			}
			
		}else{
			// no query available
			return false;
		}
	}
	
}
?>
