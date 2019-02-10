<?php 



class App 
{
        
        static $db = null;
     
        
        // Singleton
        static function getDatabase()
        {
        	// echo '--------la fonction--------';

        	if(!self::$db)
        	{
        		// echo '--------initialisation--------';
        		self::$db = new Database('root', '', 'espacemembre');
        	}

        	return self::$db;
        }

        
        // Factories
        public static function getAuth($options = [])
        {
            return new Auth(Session::getInstance(), $options);
        }
   
        // $to as $page
        public static function redirect($to)
        {
             header("Location: $to");
             exit();
        }

}
