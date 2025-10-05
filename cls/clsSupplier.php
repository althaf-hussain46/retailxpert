<?php


class ClassSupplier {
    // Private property
    private $supplierName;
    private $supplierState;

    // Magic setter
    public function __set($property, $value) {
        if ($property == "supplierName") {
            $this->supplierName = $value;
        }
        elseif($property == "supplierState"){
            $this->supplierState = $value;
        }
    }

    // Magic getter
    public function __get($property) {
        if ($property == "supplierName") {
            return $this->supplierName;
        }elseif($property == "supplierState"){
            return $this->supplierState;
        }
    }
    
    
}

?>