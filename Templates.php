<?php


require_once 'MarkDown.php';

// templates transposés de 
// James Payne, Beginning Python, Wiley, 2010, p 435-436

function mainTPL($title,$body,$navlinks){
    return <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    	<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
        <title>$title</title>
    </head>
    <body style='padding:0 20px;'>
        $body
        <hr></hr>
        <span style='margin-right: 30px;'>$navlinks</span>
    </body>
</html>
HTML;
}

function viewTPL($banner,$processedText){
    return <<<VIEW
    $banner
    $processedText
VIEW;
}

function editTPL($banner,$pageURL,$text){
    return <<<WRITE
    $banner
    <form method="POST" action="PtiWiki.php">
        <input type="hidden" name="op" value="save"></input>
        <input type="hidden" name="file" value="$pageURL"></input>
        <textarea rows="15" cols="80" name="data">$text</textarea>
        <br></br>
        <input type="submit" value="sauver"></input>
    </form>
WRITE;
}

function errorTPL($error){
    return "<h1>Erreur: $error</h1>";
}

$log="";
function bannerTPL($banner){
    
    return "
        <div  style='display: flex; justify-content: flex-end; align-items: center;'>
            ".
            displayLog()."
         </div>
        <div style='display: flex; justify-content: space-between; align-items: center;'>
          <p style='color:green;'>$banner</p>
          <div  style='display: flex; justify-content: flex-end; align-items: center;'>
            <a href=login.php style='margin-right: 20px'>Login</a>
            <a href=logout.php>Logout</a>
            " . displayGestion() ."
          </div>
        </div>
        <hr></hr>";
   
}

function displayGestion(){
    include 'connectDB.php';
    if(isset($_SESSION['username'])) {
        $select = mysqli_query($conn, "SELECT * FROM users WHERE username = '".$_SESSION['username']."' AND compte='manager'");
		if(mysqli_num_rows($select)) {
            return  "<a href=gestionnaire.php style='margin-left: 20px'>Gestion</a>";
        }
    }
}

function displayLog(){
    if(!(isset($_SESSION['username'])))
    {
        return "<span style='margin:0; text-align: right;'>--- Logged out ---</span>";
    }
    else {
        return "<span style='margin:0; text-align: right;'>--- Logged in as:  ". $_SESSION['username']. " --- </span>";
    }
}


function viewLinkTPL($file,$name){
    global $wiki;
    if(file_exists("{$wiki->getBase()}/$file.text")){
        $op="read";
        $style="";
    } else { // new file, make the link in red and set op to create
        $op="create";
        $style=" style='color:red'";
    }
    return "<a href='PtiWiki.php?op=$op&file=$file'$style>$name</a>";
}

function editLinkTPL($file,$name){
    return "<a href='PtiWiki.php?op=update&file=$file'>$name</a>";
}

function deleteLinkTPL($file,$name){
    return "<a href='PtiWiki.php?op=delete&file=$file'>$name</a>";
}

function deleteTPL($pageURL){
    return <<<DELETE
    <p>Êtes-vous certain de vouloir détruire la page "$pageURL"</p>
    <form method="GET action="PtiWiki.php">
        <input type="hidden" name="op" value="confirm-delete"></input>
        <input type="hidden" name="file" value="$pageURL"></input>
        <input type="submit" value="Détruire $pageURL!"></input>
    </form>    
DELETE;
}

?>