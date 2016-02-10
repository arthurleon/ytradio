<?php


/**
 * Band [TYPE]
 * Description  
 * @copyright (c) 2015, Arthur F. D. Leon HandsOn Consultoria
 */
class Band {
    private $Data;
    private $BandId;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados!
    const Entity = 'band';

    /**
     * <b>Cadastrar Banda:</b> Envelope titulo, descrição, data e sessão em um array atribuitivo e execute esse método
     * para cadastrar a categoria. Case seja uma sessão, envie o category_parent como STRING null.
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if ($this->Data['name'] === ''):
            $this->Result = false;            
            $this->Error = ['<b>Erro ao cadastrar:</b> Para cadastrar uma banda, preencha pelo menos o nome!', WS_ALERT];            
        else:
            $this->setData();
            $this->setName();
            $this->Create();
        endif;
    }
    

    /**
     * <b>Atualizar Categoria:</b> Envelope os dados em uma array atribuitivo e informe o id de uma
     * categoria para atualiza-la!
     * @param INT $BandId = Id da categoria
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($BandId, array $Data) {
        $this->BandId = (int) $BandId;
        $this->Data = $Data;

        if ($this->Data['name'] === ''):
            $this->Result = false;
            $this->Error = ["<b>Erro ao atualizar:</b> Para atualizar a banda {$this->Data['name']}, preencha o campo nome!", WS_ALERT];
        else:
            $this->setData();
            $this->setName();
            $this->Update();
        endif;
    }

    /**
     * <b>Deleta categoria:</b> Informe o ID de uma categoria para remove-la do sistema. Esse método verifica
     * o tipo de categoria e se é permitido excluir de acordo com os registros do sistema!
     * @param INT $BandId = Id da categoria
     */
    public function ExeDelete($BandId) {
        $this->BandId = (int) $BandId;
        $name = "NOME DA BANDA";
        $read = new Read;
        $read->ExeRead(self::Entity, "WHERE id = :delid", "delid={$this->BandId}");

        if (!$read->getResult()):
            $this->Result = false;
            $this->Error = ['Você tentou remover uma banda que não existe no sistema!', WS_INFOR];
        else:
            extract($read->getResult()[0]);
                $delete = new Delete;
                $delete->ExeDelete(self::Entity, "WHERE id = :bandid", "bandid={$this->BandId}");
                $this->Result = true;
                $this->Error = ["A banda <b>{$name}</b> foi removida com sucesso do sistema!", WS_ACCEPT];
        endif;
    }

    /**
     * <b>Verificar Cadastro:</b> Retorna TRUE se o cadastro ou update for efetuado ou FALSE se não. Para verificar
     * erros execute um getError();
     * @return BOOL $Var = True or False
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com a mensagem e o tipo de erro!
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError() {
        return $this->Error;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida e cria os dados para realizar o cadastro
    private function setData() {
        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);
        //$this->Data['name'] = Check::Name($this->Data['name']);      
    }

    //Verifica o NAME da categoria. Se existir adiciona um pós-fix +1
    private function setName() {
        $Where = (!empty($this->BandIdId) ? "id != {$this->BandIdId} AND" : '' );

        $readName = new Read;
        $readName->ExeRead(self::Entity, "WHERE {$Where} name = :t", "t={$this->Data['name']}");
        if ($readName->getResult()):
            $this->Data['name'] = $this->Data['name'] . '-' . $readName->getRowCount();
        endif;
    }


    //Cadastra a categoria no banco!
    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Data);
        if ($Create->getResult()):
            $this->Result = $Create->getResult();
            $this->Error = ["<b>Sucesso:</b> A banda {$this->Data['name']} foi cadastrada no sistema!", WS_ACCEPT];
        endif;
    }

    //Atualiza Categoria
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id = :id", "id={$this->BandId}");
        if ($Update->getResult()):            
            $this->Result = $Update->getResult();
            $this->Error = ["<b>Sucesso:</b> A {$this->Data['name']} foi atualizada no sistema!", WS_ACCEPT];
        endif;
    }

}
