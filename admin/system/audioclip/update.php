<?php
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;
?>

<div class="content form_create">

    <article>

        <header>
            <h1>Atualizar Clipe:</h1>
        </header>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $audioclipid = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!empty($data['SendPostForm'])):
            unset($data['SendPostForm']);

            //require('_models/AdminCategory.class.php');
            $update = new Audioclip();
            $update->ExeUpdate($audioclipid, $data);

            WSError($update->getError()[0], $update->getError()[1]);
        else:
            $read = new Read;
            $read->ExeRead("audioclip", "WHERE id = :id", "id={$audioclipid}");
            if (!$read->getResult()):
                header('Location: panel.php?exe=audioclip/index');
            else:
                $data = $read->getResult()[0];
            endif;
        endif;
        
        //$checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
        //if($checkCreate && empty($cadastra)):
        //    $tipo = ( empty($data['category_parent']) ? 'seção' : 'categoria');
        //    WSErro("A {$tipo} <b>{$data['category_title']}</b> foi cadastrada com sucesso no sistema! Continue atualizando a mesma!", WS_ACCEPT);
        //endif;
        
        $bands = new Read;
        $bands->ExeRead('band');
        ?>

<script src="<?php echo HOME ?>js/functions.js"></script>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

<form name="PostForm" action="" method="post" enctype="multipart/form-data">
    <label>URL:</label>
    <input type="text" name="url" value="<?php if(isset($data)) echo $data['url'] ; ?>" onblur="getVideoTitle(PostForm.url)">
    <br><br>
    <label>tags:</label>
    <input type="text" name="tags" value="<?php if(isset($data)) echo $data['tags'] ; ?>">
    <br><br>
    <label>Song name:</label>
    <input type="text" name="songname" value="<?php if(isset($data)) echo $data['songname'] ; ?>">
    <br><br>
    <label>Band:</label>
    <select name="band_id" id="band_id">        
        <?php foreach ($bands->getResult() as $band){ ?>
        echo "id: {$band['id']}<br>";        
        <option value="<?php echo $band['id'] ; ?>"><?php echo $band['name'] ; ?></option>"
        <?php } ?>
        
    </select>
    <br><br>
    <input type="submit" value="Atualizar clipe" name="SendPostForm">
</form>

    </article>

    <div class="clear"></div>
</div> <!-- content home -->