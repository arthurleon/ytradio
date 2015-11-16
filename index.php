<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">       
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="assets/main.css">
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
    <!-- Container -->    
    <header class="navigation" role="banner">
        <div class="navigation-wrapper">                   
                <a href="javascript:void(0)" class="logo">
                    <img src="assets/images/ytradio.png" alt="YouTube Radio">
                </a>                
            </nav>
        </div>
    </header>
    <div class="container">
        <main>            
            <section class="main-section">                            
            <!-- START CONTENT HERE -->                
                <article>
                    <div id="ytplayer"></div>
                    <footer id="song_info">
                        <p id="song_name">Song name: <?php echo "Soon.."; ?></p>
                    </footer>                    
                </article>                                      
            <!-- END CONTENT -->                      
            </section>
            <section class="album-section">
                <article>
                    <div class="album-img"></div>
                    <div class="album-data"></div>
                    <div class="album-sell"></div>
                </article>
            </section>
            <section class="merchan-section">
                <article>
                    <div class="merchan-img"></div>                    
                    <div class="merchan-sell"></div>
                </article>
            </section>
            </section>
            <section class="band-section">
                <article>
                    <div class="band-website"></div>                    
                    <div class="band-facebook"></div>
                    <div class="band-country"></div>
                    <div class="band-metal-archives"></div>
                </article>
            </section>            
        </main>                               
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