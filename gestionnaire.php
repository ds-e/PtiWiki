<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include 'connectDB.php';
include 'Templates.php';

session_start();

if (array_key_exists("selected", $_POST)) {
    $selected = $_POST['selected'];
    mysqli_query($conn, "DELETE FROM users WHERE username='$selected'");
}



$result = mysqli_query($conn, "SELECT * FROM users WHERE NOT compte='manager'");

echo bannerTPL("PtiWiki - Gestion");

echo "
<h1> Table des usagers </h1>
<br>
<table border='1' style ='margin-bottom: 20px' id='tb'>
<tr>
<th>Username</th>
<th>Compte</th>
<th>Supprimer</th>
</tr>";

while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['compte'] . "</td>";
    echo "<td> 
        <button type='submit' id='" . $row['username'] . " ' class='delete'>Supprimer</button>
        </td>";
    echo "</tr>";
}
echo "</table>";

echo "
<hr>
<p><a href=PtiWiki.php?op=read&amp;file=PageAccueil>Accueil</a></p>  
";

mysqli_close($conn);
?>

<html>

<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".delete").on('click', function() {
                $(this).closest('tr').remove();
                // window.location.href = 'gestionnaire.php?selected=' + this.id;
                $.post("gestionnaire.php", {
                    selected: this.id
                });
            })
        });
    </script>

    <style>
        td {
            padding: 10px;
        }
    </style>
</head>

<body style="padding: 0 20px;">

</body>

</html>