<?php
class NameException extends Exception{
		public function getExceptionMessage(){
			echo "Greska na linija ".$this->getLine()." vo ".$this->getFile();
		}
	}