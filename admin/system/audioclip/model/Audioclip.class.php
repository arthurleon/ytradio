<?php


/**
 * Audioclip [CLASS]
 * Description  
 * @copyright (c) year, Arthur F. D. Leon HandsOn Consultoria
 */
class Audioclip {
    
    private $ResultSet;
    private $FullResultSet;
    private $Data;
    private $AudioclipId;
    private $Result;
    private $Error;

    //Nome da tabela no banco de dados!
    const Entity = 'audioclip';
    
    public function ExeCreate(array $Data) {
        $this->Data = $Data;
        if (empty($this->Data["url"]) || empty($this->Data["tags"])):
            $this->Result = false;
            $this->Error = ['<b>Erro ao cadastrar:</b> Para cadastrar, preencha pelo menos a URL e as TAGS!', WS_ALERT];
        else:
            if($this->checkDoubleURL()):
                $this->Error = ['<b>Erro ao cadastrar:</b> URL já cadastrada!', WS_ALERT];
            else:
                $this->setData();           
                $this->Create();
            endif;
        endif;
    }

    public function ExeUpdate($AudioclipId, array $Data) {
        $this->AudioclipId = (int) $AudioclipId;
        $this->Data = $Data;

        if ($this->Data['url'] === ''):
            $this->Result = false;
            $this->Error = ["<b>Erro ao atualizar:</b> Para atualizar clipe {$this->Data['url']}, preencha o campo url!", WS_ALERT];
        else:
            $this->setData();            
            $this->Update();
        endif;
    }
    
    public function GetList() {
        $this->ReadList();
        $array = $this->ResultSet;
        shuffle($array);
        return $array;
    }
    
    public function GetFullList() {
        $this->ReadFullList();
        return  $this->FullResultSet;                
    }
        
    
    public function getError() {
        return $this->Error;
    }
    
    public function getResult() {
        return $this->Result;
    }
    
    /**
     * PRIVATE METHODS
     */
    
    //Valida e cria os dados para realizar o cadastro
    private function setData() {
        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);        
    }
    
    //Verifies double url
    private function checkDoubleURL() {
        $readSes = new Read;
        $readSes->ExeRead('audioclip', "WHERE url = :url", "url={$this->Data['url']}");
        if ($readSes->getResult()):
            return true;
        else:
            return false;
        endif;
    }
    
    //Writes Audioclip to database
    private function Create() {
        $Create = new Create;
        $Create->ExeCreate('audioclip', $this->Data);
        if ($Create->getResult()):
            $this->Result = $Create->getResult();
            $this->Error = ["<b>Success:</b> Audioclip added!", WS_ACCEPT];
        endif;
    }
    
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id = :id", "id={$this->AudioclipId}");
        if ($Update->getResult()):            
            $this->Result = $Update->getResult();
            $this->Error = ["<b>Sucesso:</b> A {$this->Data['url']} foi atualizada no sistema!", WS_ACCEPT];
        endif;
    }
    
    private function ReadList() {
        $readList = new Read;
        $readList->ExeRead('audioclip');
        $urls = $readList->getResult();
        $this->ResultSet = [];
        foreach ($urls as $url) {
            array_push($this->ResultSet, $this->extractYouTubeId($url['url']));
        }
    }
    
    private function ReadFullList() {
        $readList = new Read;
        $readList->ExeRead('audioclip');        
        $this->ResultSet = $readList->getResult();
    }
    
    private function extractYouTubeId($url) {
        $matches = null;
        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
        return $matches[1];
    }
    
    
}
