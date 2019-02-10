<?php 


/**
 * On peut le nomme Hash()
**/
class Str
{
        
        /**
		 * Chiffres de 0 - 9
		 * Toutes les chaines de caracteres du clavier minuscule et majuscule
		 * str_repeat() pour repeter $length = 60 fois la chaine $alphabet
		 * str_shuffle() pour melanger le resultat
		 * substr() pour limiter la taille de 0 a la taille $length demander 60
        **/
        static function random($length)
		{
			$alphabet = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
			return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
		}

}