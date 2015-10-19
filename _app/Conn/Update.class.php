<?php


/**
 * <b>Update.class</b>
 * Generic UPDATE class to update data on a database.
 * @copyright (c) 2015, Arthur F. D. Leon HandsOn Consultoria
 */
class Update extends Conn{
    private $Table;
    private $Data;
    private $Terms;
    private $Places;
    private $Result;
    
    /** @var PDOStatement */
    private $Update;
    
    /** @var PDO */
    private $Conn;
    
    /**
     * <b>ExeUpdate</b> Executes a simple update on a table. Table name and a data array (column_name => value) must be entered.
     * @param STRING $Table = Enter Table Name
     * @param ARRAY $Data = Enter Data array. (Column_name => Value)
     */
    
    public function ExeUpdate($Table, array $Data = null, $Terms, $ParseString) {
        $this->Table = (string) $Table;
        $this->Data = $Data;
        $this->Terms = (string) $Terms;        
        parse_str($ParseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }
    
    public function getResult() {
        return $this->Result;
    }
    
    public function getRowCount() {
        $this->Update->rowCount();
    }
    
    public function setPlaces($ParseString) {
        parse_str($ParseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }
    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Update = $this->Conn->prepare($this->Update);
        $this->Update->setFetchMode(PDO::FETCH_ASSOC);
    }
    
    private function getSyntax() {
        foreach ($this->Data as $Key => $Value):
            $Places[] = $Key.' = :'.$Key;
        endforeach;
        $Places = implode(', ', $Places);       
        $this->Update = "UPDATE {$this->Table} SET {$Places} {$this->Terms}";        
    }
    
    private function Execute() {
        $this->Connect();
        try {                        
            $this->Update->execute(array_merge($this->Data, $this->Places));
            $this->Result = true;
        } catch (PDOException $e) {
            $this->Result = null;
            WSError("<b>Erro ao atualizar:</b> {$e->getMessage()}", $e->getCode());
        }
    }
}
