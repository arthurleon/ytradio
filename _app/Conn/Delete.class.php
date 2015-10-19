<?php


/**
 * <b>Delete.class</b>
 * Generic DELETE class to delete data on a database.
 * @copyright (c) 2015, Arthur F. D. Leon HandsOn Consultoria
 */
class Delete extends Conn{
    private $Table;
    private $Data;
    private $Terms;
    private $Places;
    private $Result;
    
    /** @var PDOStatement */
    private $Delete;
    
    /** @var PDO */
    private $Conn;
    
    /**
     * <b>ExeDelete</b> Executes a simple update on a table. Table name and a data array (column_name => value) must be entered.
     * @param STRING $Table = Enter Table Name
     * @param ARRAY $Data = Enter Data array. (Column_name => Value)
     */
    
    public function ExeDelete($Table, $Terms, $ParseString) {
        $this->Table = (string) $Table;
        $this->Terms = (string) $Terms;
        
        parse_str($ParseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }
    
    public function getResult() {
        return $this->Result;
    }
    
    public function getRowCount() {
        $this->Delete->rowCount();
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
        $this->Delete = $this->Conn->prepare($this->Delete);
    }
    
    private function getSyntax() {
        $this->Delete = "DELETE FROM {$this->Table} {$this->Terms}";
    }
    
    private function Execute() {
        $this->Connect();
        try {
            $this->Delete->execute($this->Places);
            $this->Result = true;
        } catch (PDOException $e) {
            $this->Result = null;
            WSError("<b>Erro ao deletar:</b> {$e->getMessage()}", $e->getCode());
        }
    }
}
