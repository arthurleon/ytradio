<h2><?php echo $getexe ?></h2>
<?php
    $audioclips = new Read;
    $audioclips->ExeRead('audioclip');
    
    echo "<a href='panel.php?exe=audioclip/create'>Novo</a><br><br>";
    echo "Acervo contem {$audioclips->getRowCount()} vídeos<br><br>";
    
    foreach ($audioclips->getResult() as $audioclip){
        echo "id: {$audioclip['id']}<br>";
        echo "url: {$audioclip['url']}<br>";
        echo "tags: {$audioclip['tags']}<br>";
        echo "songname: {$audioclip['songname']}<br>";
        echo "<a href='http://localhost/ytradio/admin/panel.php?exe=audioclip/update&id={$audioclip['id']}'>Editar</a><br><br>";
    }
?>