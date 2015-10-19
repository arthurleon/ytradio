/* 
 * Given an youtube video URL (string) returns the video ID
 */

function YouTubeGetID(url){
    var ID = '';
    url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
    if(url[2] !== undefined) {
      ID = url[2].split(/[^0-9a-z_\-]/i);
      ID = ID[0];
    }
    else {
      ID = url;
    }
    return ID;
}

/* 
 * Given an youtube video URL (string) returns the video Title
 */
function getVideoTitle(url){
    id = YouTubeGetID(url.value);
    q = "https://www.googleapis.com/youtube/v3/videos?id="+id+"&key=AIzaSyAwmx7W6AW6Ay71aZxK11NhoXnJwKcc1Ps&fields=items(id,snippet(title),statistics)&part=snippet,statistics";
    //console.log(q);
    $.ajax({
        url: q, 
        dataType: "jsonp",
        success: function(data){
                 songTitle = data.items[0].snippet.title;
                 console.log(songTitle);
                 $('input[name=songname]').val(songTitle );
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert (textStatus, + ' | ' + errorThrown);
        }
    });       
}
    
/* 
 * Given an youtube video ID (string) shows the song info
 */
function showSongInfo(ID) {
    if (ID.length === 0) { 
        document.getElementById("song_name").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                // ANTES DE EXIBIR O NOVO VALOR PARSEAR A STRING COM A FUNCAO JSON.parse(xmlhttp.responseText);
                document.getElementById("song_name").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "getSongInfo.php?q=" + ID, true);
        xmlhttp.send();
    }
}    