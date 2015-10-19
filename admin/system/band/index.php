<h2><?php echo $getexe ?></h2>
<?php
    $bands = new Read;
    $bands->ExeRead('band');
    
    echo "<a href='panel.php?exe=band/create'>Novo</a><br><br>";
    echo "Acervo contem {$bands->getRowCount()} bandas<br><br>";
    
    foreach ($bands->getResult() as $band){
        echo "id: {$band['id']}<br>";
        echo "name: {$band['name']}<br>";
        echo "name: {$band['website']}<br>";
        echo "name: {$band['facebook']}<br>";
    }
?>