<h2><?php echo $getexe ?></h2>

<?php
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if (!empty($data['SendPostForm'])):
        unset($data['SendPostForm']);

        
        $create = new Band();
        $create->ExeCreate($data);

        if ($create->getResult()):
            $phpServer = filter_input(INPUT_SERVER, 'PHP_SELF');
            header('Location: '. basename($phpServer).'?exe=band/create&id=' . $create->getResult());
        else:
            WSError($create->getError()[0], $create->getError()[1]);           
        endif;

    endif;

?>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    
</script>
<form name="PostForm" action="" method="post" enctype="multipart/form-data">
    <label>Name:</label>
    <input type="text" name="name" value="<?php if(isset($data)) {echo $data['name'] ;} ?>">
    <br><br>
    <label>Site:</label>
    <input type="text" name="website" value="<?php if(isset($data)) {echo $data['website'] ;} ?>">
    <br><br>
    <label>Facebook:</label>
    <input type="text" name="facebook" value="<?php if(isset($data)) {echo $data['facebook'] ;} ?>">
    <br><br><input type="submit" value="Cadastrar" name="SendPostForm">
</form>