<?php
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;
?>

<div class="content form_create">

    <article>

        <header>
            <h1>Atualizar Banda:</h1>
        </header>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $bandid = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!empty($data['SendPostForm'])):
            unset($data['SendPostForm']);

            //require('_models/AdminCategory.class.php');
            $update = new Band;
            $update->ExeUpdate($bandid, $data);

            WSError($update->getError()[0], $update->getError()[1]);
        else:
            $read = new Read;
            $read->ExeRead("band", "WHERE id = :id", "id={$bandid}");
            if (!$read->getResult()):
                header('Location: panel.php?exe=band/index');
            else:
                $data = $read->getResult()[0];
            endif;
        endif;
        
        //$checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
        //if($checkCreate && empty($cadastra)):
        //    $tipo = ( empty($data['category_parent']) ? 'seção' : 'categoria');
        //    WSErro("A {$tipo} <b>{$data['category_title']}</b> foi cadastrada com sucesso no sistema! Continue atualizando a mesma!", WS_ACCEPT);
        //endif;
        
        ?>

        <form name="PostForm" action="" method="post" enctype="multipart/form-data">


            <label class="label">
                <span class="field">Name:</span>                
            </label>
            <input type="text" name="name" value="<?php if (isset($data)) echo $data['name']; ?>" />
            <br><br>
            
            <label class="label">
                <span class="field">Site:</span>                
            </label>
            <input type="text" name="website" value="<?php if (isset($data)) echo $data['website']; ?>" />
            <br><br>
            
            <label class="label">
                <span class="field">Facebook:</span>                
            </label>
            <input type="text" name="facebook" value="<?php if (isset($data)) echo $data['facebook']; ?>" />
            <br><br>            

            <input type="submit" class="btn blue" value="Atualizar Banda" name="SendPostForm" />
        </form>

    </article>

    <div class="clear"></div>
</div> <!-- content home -->