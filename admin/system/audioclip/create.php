<h2><?php echo $getexe ?></h2>

<?php
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if (!empty($data['SendPostForm'])):
        unset($data['SendPostForm']);

        
        $create = new Audioclip();
        $create->ExeCreate($data);

        if ($create->getResult()):
            $phpServer = filter_input(INPUT_SERVER, 'PHP_SELF');
            header('Location: '. basename($phpServer).'?exe=audioclip/create&id=' . $create->getResult());
        else:
            WSError($create->getError()[0], $create->getError()[1]);           
        endif;
        
    endif;
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
    <input type="submit" value="Cadastrar" name="SendPostForm">
</form>