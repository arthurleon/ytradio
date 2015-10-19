<?php


/**
 * Login [CLASS]
 * Authenticates, validates and checks system users
 * @copyright (c) 2015, Arthur F. D. Leon HandsOn Consultoria
 */
class Login {
    private $Level;
    private $Email;
    private $Pass;
    private $Error;
    private $Result;
    
    public function __construct($Level) {
        $this->Level = (int) $Level;
    }
    
    public function ExeLogin(array $UserData) {
        $this->Email = (string) strip_tags(trim($UserData['user']));
        $this->Pass = (string) strip_tags(trim($UserData['pass']));
        $this->setLogin();
    }
    
    public function getError() {
        return $this->Error;
    }

    public function getResult() {
        return $this->Result;
    }

    public function checkLogin() {
        if(empty($_SESSION['userLogin']) || $_SESSION['userLogin']['level'] < $this->Level):
            unset($_SESSION['userLogin']);
            return false;
        else:
            return true;
        endif;        
    }

    /**
     * PRIVATE METHODS
     */
    
    private function setLogin() {
        if(!$this->Email || !$this->Pass || !Check::Email($this->Email)):
            $this->Error = ["Enter email and pass to perform Login!", WS_INFO];
            $this->Result = false;
        elseif(!$this->GetUser()):
            $this->Error = ["User and pass not found!", WS_ALERT];
            $this->Result = false;
        elseif ($this->Result['level'] > $this->Level):
            $this->Error = ["{$this->Result['name']}, you have no power here!", WS_ERROR];
            $this->Result = false;
        else:
        $this->execute();
        endif;
    }
    
    private function GetUser() {
        $this->Pass = md5($this->Pass);
        
        $read = new Read;
        $read->ExeRead('user', "WHERE email = :e AND password = :p", "e={$this->Email}&p={$this->Pass}");
        if($read->getResult()):
            $this->Result = $read->getResult()[0];
            return true;
        else:
            return FALSE;
        endif;
    }
    
    private function execute() {
        if (!session_id()):
            session_start();
        endif;
        $_SESSION['userLogin'] = $this->Result;
        $this->Error = ["Welcome Master {$this->Result['name']}, wait for redirection...", WS_ACCEPT];
        $this->Result = TRUE;
    }
}
