<?php
    session_start();
    require_once '../_app/config.inc.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div id="login">
            <div class="box-in">
                <h1>Admin Area</h1>
                <?php
                require_once '../_app/config.inc.php';
                
                $login = new Login(3);
                
                if($login->checkLogin()):
                    header('Location: panel.php');
                endif;
                
                $dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if(!empty($dataLogin['adminLogin'])):                    
                    $login->ExeLogin($dataLogin);
                    if(!$login->getResult()):
                        WSError($login->getError()[0], $login->getError()[1]);
                    else:
                        header('Location: panel.php');
                    endif;
                endif;
                
                $get = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
                if(!empty($get)):
                    if($get == 'restricted'):
                        WSError("Access Denied! Log In first!", WS_ALERT);
                    elseif ($get == 'logoff'):
                        WSError("Logged off", WS_INFO);
                    endif;
                endif;
                        
                ?>        
                <form name="adminLoginForm" action="" method="POST">
                    <label>
                        <span>Email:</span>
                        <input type="email" name="user">
                    </label>
                    <label>
                        <span>Pass</span>
                        <input type="password" name="pass">
                    </label>

                    <input type="submit" value="Login" name="adminLogin" class="btn blue" />
                </form>
            </div>
        </div>
    </body>
</html>
