<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.0.5/material.blue_grey-red.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <title>YouTube Radio</title>
        <style>
            article {
                width: 640px;
                margin-right: auto;
                margin-left: auto;
                
            }
            
            main{
                background-color: lightslategrey;
            }         
        </style>
    </head>
    <body>
    <?php
            require_once '_app/config.inc.php';
            $playlist = new Audioclip();
            $id = $playlist->GetList();
            //var_dump($id);
            $i = 0;
            // print_r($id);
            $width = '640px';
            $height = '360px';
        ?>                          
    <!-- GOOGLE MATERIAL LAYOUT-->
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title">YouTube Metal Radio</span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">            
            <a class="mdl-navigation__link" href="">Link</a>
          </nav>
        </div>
      </header>
      <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Menu</span>
        <nav class="mdl-navigation">          
          <a class="mdl-navigation__link" href="">Link</a>
        </nav>
      </div>
      <main class="mdl-layout__content">
          <div class="page-content">
              
              
            <!-- START CONTENT HERE -->
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col">
                    <article>
                        <div id="ytplayer"></div>
                        <div id="song_info">
                            <p id="song_name">Song name: <?php echo "Soon.."; ?></p>
                        </div>                        
                    </article>                    
                </div>
            </div>  
            <!-- END CONTENT -->
            
            
          </div>
      </main>
        
        
      <!-- GOOLE MATERIAL FOOTER -->        
        <footer class="mdl-mini-footer">
        <div class="mdl-mini-footer__left-section">
          <div class="mdl-logo">
            More Information
          </div>
          <ul class="mdl-mini-footer__link-list">
            <li><a href="#">Help</a></li>
            <li><a href="#">Privacy and Terms</a></li>
            <li><a href="#">User Agreement</a></li>
          </ul>
        </div>
        <div class="mdl-mini-footer__right-section">
          <button class="mdl-mini-footer__social-btn"></button>
          <button class="mdl-mini-footer__social-btn"></button>
          <button class="mdl-mini-footer__social-btn"></button>
        </div>
        </footer>    
        <!-- GOOLE MATERIAL END-->  
        
        
    </div>    
    <!-- END GOOGLE MATERIAL LAYOUT-->        
        
        <script src="<?php echo HOME ?>js/functions.js"></script>
        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script> 
        <!--  <script src="https://storage.googleapis.com/code.getmdl.io/1.0.5/material.min.js"></script> -->
        
        <script>
          // Load the IFrame Player API code asynchronously.
          var tag = document.createElement('script');
          tag.src = "https://www.youtube.com/player_api";
          var firstScriptTag = document.getElementsByTagName('script')[0];
          firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

          // Replace the 'ytplayer' element with an <iframe> and
          // YouTube player after the API code downloads.
          var player;
          var playlist = [];
          var current = 0;
          
          <?php foreach ($id as $value) { ?>
              playlist[playlist.length] = (<?php echo "'$value'"; ?>);
          //    console.log(playlist);
          <?php } ?>

          function onYouTubePlayerAPIReady() {                        
            player = new YT.Player('ytplayer', {              
              height: <?php echo "'".$height."'" ; ?>,
              width: <?php echo "'".$width."'" ; ?>,
              videoId: playlist[current]
            });            
            showSongInfo(playlist[current]);
            player.addEventListener("onError", onPlayerError);            
            player.addEventListener("onStateChange", onPlayerStateChange);            
          }
          
          function onPlayerStateChange(){
            // console.log("UAHUAHUAHAUH");
            if(player.getPlayerState() === 0){
                if(current <= playlist.length){
                    current++;
                    player.loadVideoById(playlist[current]);
                    showSongInfo(playlist[current]);
                }else{
                    alert("Fim da playlist");
                }
            }
          }
          
          function onPlayerError(){
            //    console.log("BUAAAA");
                current++;
                player.loadVideoById(playlist[current]);            
          }
        </script>
    </body>
</html>