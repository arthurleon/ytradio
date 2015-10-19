<?php


/**
 * <b>Create.class</b>
 * Generic CREATE class to input data to database.
 * @copyright (c) 2015, Arthur F. D. Leon HandsOn Consultoria
 */
class Create extends Conn{
    private $Table;
    private $Data;
    private $Result;
    
    /** @var PDOStatement */
    private $Create;
    
    /** @var PDO */
    private $Conn;
    
    /**
     * <b>ExeCreate</b> Executes a simple insert on a table. Table name and a data array (column_name => value) must be entered.
     * @param STRING $Table = Enter Table Name
     * @param ARRAY $Data = Enter Data array. (Column_name => Value)
     */
    
    public function ExeCreate($Table, array $Data) {
        $this->Table = (string) $Table;
        $this->Data = $Data;
        
        $this->getSyntax();
        $this->Execute();
    }
    
    /**
     * <b>getResult</b> returns the ID of the last insert record of FALSE if there was an error.
     * @return INTEGER $Var = lastInsertID or FALSE.
     */
    public function getResult() {
        return $this->Result;
    }
    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    
    /**
     * Get the PDO and prepares the query.
     */
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($this->Create);
    }
    
    /**
     * Creates the query syntax for the Prepared Statement.
     */
    private function getSyntax() {
        $Fields = implode(', ', array_keys($this->Data));
        $Places = ':'.implode(', :', array_keys($this->Data));
        $this->Create = "INSERT INTO {$this->Table} ({$Fields}) VALUES ({$Places})";
    }
    
    /**
     * Get the connetion and the syntax, and executes the query.
     */
    private function Execute() {
        $this->Connect();
        try {
            $this->Create->execute($this->Data);
            $this->Result = $this->Conn->lastInsertId();
        } catch (PDOException $e) {
            $this->Result = null;
            WSError("<b>Erro ao cadastrar:</b> {$e->getMessage()}", $e->getCode());
        }
        }
}
