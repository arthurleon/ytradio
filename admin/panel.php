<?php
    session_start();
    require_once '../_app/config.inc.php';
    
    // SETS LOGIN AND LOGOFF
    $login = new Login(1);
    $logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
    $getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
    
    // VERIFIES LOGIN
    if (!$login->checkLogin()):
        unset($_SESSION['userLogin']);
        header('Location: index.php?exe=restricted');
    else:
        $userLogin = $_SESSION['userLogin'];
    endif;
    
    // VERIFIES LOGOFF
    if($logoff):
        unset($_SESSION['userLogin']);
        header('Location: index.php?exe=logoff');
    endif;
    
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Painel</h1>
        <a href="panel.php?logoff=true">Log off</a>
        <a href="panel.php?exe=audioclip/index">Clips</a>
        <a href="panel.php?exe=band/index">Bands</a>
        <div id="painel">
        <?php
            //QUERY STRING
            if (!empty($getexe)):
                $includepatch = __DIR__ . '/system/' . strip_tags(trim($getexe) . '.php');
            else:
                $includepatch = __DIR__ . '/system/home.php';
            endif;            

            if (file_exists($includepatch)):
                require_once($includepatch);
            else:
                echo "<div class=\"content notfound\">";
                WSError("<b>Erro ao incluir tela:</b> Erro ao incluir o controller /{$getexe}.php!", WS_ERROR);
                echo "</div>";
            endif;
        ?>
        </div> <!-- painel -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', <?php echo "'".UA."'" ?>, 'auto');
            ga('send', 'pageview');
        </script>
    </body>
</html>
