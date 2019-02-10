<?php 


class Validator 
{
       
       private $data;
       private $errors = [];


       public function __construct($data)
       {
             $this->data = $data;
       }
   
       private function getField($field)
       {
       	   if(!isset($this->data[$field]))
       	   {
       	   	   return null;
       	   }

       	   return $this->data[$field];
       }
       
       /**
        * changer le nom de la fonction apres vue qu'on accepte des underscores '_'
        * dans le preg_match()
        * 
        * @param string $field
        * @param string $errorMsg
       */
       public function isAlpha($field, $errorMsg = '')
       {
           if(!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field)))
           {
                $this->errors[$field] = $errorMsg;
           }
       }


       public function isUniq($field, $db, $table, $errorMsg = '')
       {
       	     $record = $db->query("SELECT id FROM $table WHERE $field = ?", 
       	     [$this->getField($field)])->fetch();
             
	      	 if($record)
	      	 {
	      	 	  // echo 'record';
	      	 	  $this->errors[$field] = $errorMsg;
	      	 }

	      	 // echo 'no-record';
       }


       public function isEmail($field, $errorMsg = '')
       {
       	    if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL))
       	    {
                  $this->errors[$field] = $errorMsg;
       	    }
       }
       
       // on peut renommer la fonction matches()
       public function isConfirmed($field, $errorMsg = '')
       {
       	    $value = $this->getField($field);
       	    $confirm = $this->getField($field .'_confirm');

            if(empty($value) || ($value != $confirm))
            {
                 $this->errors[$field] = $errorMsg;
            }
       }

       
       /**
        * @return bool
       **/
       public function isValid()
       {
       	   return empty($this->errors);
       }


       public function getErrors()
       {
       	   return $this->errors;
       }
}