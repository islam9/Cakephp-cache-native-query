CAKEPHP Native Query Cache
--------------------------

and am using cakephp cache to cache query individually using find method.

function in app model witch can deal with mySql -native- query cache.

And here how you can do this:
-----------------------------

place the following function within your app/app_model.php.

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
'prefix'     => strtolower($this->name) .'-',
'duration'    => $expires
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

Then  create a folder called sql within your tmp/cache/ and chmod the permissions to 777.

then open up your app/config/core.php file and place the following code

Cache::config('sql_cache', array(
    'engine'		=> 'File',
    'path'		=> CACHE .'sql'. DS,
    'serialize'	=> true,
));

and then we are ready to use our custom method like this:
$query='select * from posts';
$result=$this->ModelNmae->nativeQuery($query,true,'keyName','+1 hour');

you can clear the cache using Cache::delete() method or delete the file from the cache folder

here how i do this

hope its helpful...

