<?php
	class DatabaseException extends Exception{
		public function getExceptionMessage(){
			echo "Грешка при селектирање на база";
		}
	}