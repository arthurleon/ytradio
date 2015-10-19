<?php


/**
 * <b>Read.class</b>
 * Generic READ class to read data from a database.
 * @copyright (c) 2015, Arthur F. D. Leon HandsOn Consultoria
 */
class Read extends Conn{
    private $Select;
    private $Places;
    private $Result;
    
    /** @var PDOStatement */
    private $Read;
    
    /** @var PDO */
    private $Conn;
    
    /**
     * <b>ExeRead</b> Executes a simple insert on a table. Table name and a data array (column_name => value) must be entered.
     * @param STRING $Table = Enter Table Name
     * @param ARRAY $Data = Enter Data array. (Column_name => Value)
     */
    
    public function ExeRead($Table, $Terms = null, $ParseString = null) {
        if(!empty($ParseString)):
            parse_str($ParseString, $this->Places);
        endif;
        $this->Select = "SELECT * from {$Table} {$Terms}";
        $this->Execute();
    }
    
    public function getResult() {
        return $this->Result;
    }
    
    public function getRowCount() {
        return $this->Read->rowCount();
    }
    
    public function fullRead($Query, $ParseString = null) {
        $this->Select = (string) $Query;
        if(!empty($ParseString)):
            parse_str($ParseString, $this->Places);
        endif;
        $this->Execute();
    }
    
    public function setPlaces($ParseString) {
        parse_str($ParseString, $this->Places);
        $this->Execute();
    }
    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($this->Select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
    }
    
    private function getSyntax() {
        if($this->Places):
            foreach ($this->Places as $Bind => $Value):
                if($Bind == 'limit' || $Bind == 'offset'):
                    $Value = (int) $Value;
                endif;
                $this->Read->bindValue(":{$Bind}", $Value, (is_int($Value)? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        endif;
    }
    
    private function Execute() {
        $this->Connect();
        try {
            $this->getSyntax();
            $this->Read->execute();
            $this->Result = $this->Read->fetchAll();
        } catch (PDOException $e) {
            $this->Result = null;
            WSError("<b>Erro ao ler:</b> {$e->getMessage()}", $e->getCode());
        }
    }
}
