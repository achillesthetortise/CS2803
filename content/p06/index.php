<!DOCTYPE html>
<html>

<head>

<!--
    Author: Thomas Doolittle
    Class:  CS2803
    Assignment: Project 6
    Date: June 7, 2014
-->
<title>Simple PHP</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

</head>
<body>

<header>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

      Please enter your First Name: <input type="text" name="fname"/><br>
      Please enter your Last Name: <input type="text" name="lname"/><br>
      Site to check: 
			<select name="infosource">
      <option value="UrbanDictionary">Urban Dictionary</option>
      <option value="BehindTheName">Behind the Name</option>
      <option value="OnlineEtymologyDictionary">Online Etymology Dictionary</option>

      </select>
      <input type="submit"><br>
</form> 
</header>

<?php

require_once("simple_html_dom.php");

if( !empty($_POST) && !empty($_POST['fname']) ) {
    $name = $_POST['fname'];
    $info = $_POST['infosource'];
    echo "<div class='firstName' id='".$info."'><h2>First Name: ".$name."</h2>";
    placeText($name,$info);
    echo "</div>";
}
if( !empty($_POST) && !empty($_POST['lname']) ) {
        $name = $_POST['lname'];
        $info = $_POST['infosource'];
        echo"<div class='lastName' id='".$info."'><h2>Last Name: ".$name."</h2>";
        placeText($name,$info);
        echo "</div>";
}


function placeText($name, $info) {
    $html = new simple_html_dom();

    if( $info == "UrbanDictionary" ) {
        
        $html->load_file("http://www.urbandictionary.com/define.php?term=".$name);
        
        if( $html->getElementById('not_defined_yet') == null) {
            echo "<ul>";
            foreach($html->find('div.meaning') as $meaning) {
                echo "<li>".$meaning->plaintext."<li/>";
            }
            echo "</ul>";
        } else {
            echo "cant be found.";
        }
        
    } else if( $info == "BehindTheName" ) {
        
        $html->load_file("http://www.behindthename.com/name/".$name);
        $meaning = $html->find('div.nameheading')[0]->next_sibling();
        echo $meaning->plaintext;
        
    } else if( $info == "OnlineEtymologyDictionary") {
        
        $html->load_file("http://www.etymonline.com/index.php?search=".$name);
        
        $definition = trim($html->find('dt.highlight')[0]->plaintext);
        
        if( strcasecmp($name,$definition) == 0 ) {
            echo "<h3>".$name."</h3>";
        } else {
            echo $name." was not found, the next closest match is: ".$definition;
        }
        
        $meaning = $html->find('dd.highlight')[0];
        echo $meaning->plaintext;
    }
              
}
      
?>



</body>

</html>