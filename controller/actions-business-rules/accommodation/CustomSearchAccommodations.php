<?php

class CustomSearchAccommodation {
    private array $columns; 
    private array $conditions; 
    private array $complements; 

    public function __construct(array $columns, array $conditions, array $complements){
        $this->columns = $columns;
        $this->conditions = $conditions;
        $this->complements = $complements;
    }

    public function execute(classDAO $accommodationDAO){
        $columnsLength = count($this->columns);   
        $conditionsLength = count($this->conditions);
        $coplementsLength = count($this->complements);
        
        if(!($this->columns && $this->conditions && $this->complements)){
            throw new Exception("Não foi possível realizar a pesquisa, dados ou filtros faltantes.");
        }
    
        if(in_array("", $this->columns) || in_array("", $this->conditions) || in_array("", $this->complements)) {
            throw new Exception("Não foi possível realizar a pesquisa, dados incorretos ou faltantes.");
        }
    
        if($columnsLength !== $conditionsLength || $columnsLength !== $coplementsLength || $conditionsLength !== $coplementsLength) {
            throw new Exception("Dados insuficientes para realizar a pesquisa.");
        }
    
        return $accommodationDAO->customSearch($this->columns, $this->conditions, $this->complements);
    }
}