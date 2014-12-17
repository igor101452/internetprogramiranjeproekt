<?php
	class ServerException extends Exception{
		public function getExceptionMessage(){
			echo "Грешка при конектирање на сервер";
		}
	}