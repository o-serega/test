<?php
class mySql {
    public $queryRow;

    public function query($conect, $sql){



        $this->queryRow = mysqli_query($conect, $sql) or die (mysqli_error('Произошла ошибка'));
        
        $rows = array();
        
        if($this->queryRow and gettype($this->queryRow) != 'boolean'){
            	
				while ($row = mysqli_fetch_assoc($this->queryRow)) {
					$rows[] = $row;
				}
        }else{
            $rows = $this->queryRow;
        }

        return $rows; 
    }   
}
?>