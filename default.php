<!doctype html>
<html>

<head>
    <title> Thomas Doolittle - CS2803 </title>

    <link rel="stylesheet" type="text/css" href="style/MainStyle.css" >
    <link rel="stylesheet" type="text/css" href="style/AccordionStyle.css" >

    <script src="http://cdn.jquerytools.org/1.2.5/full/jquery.tools.min.js"></script>
<script type='text/javascript'>
$(document).ready(function() {
    //Initialising Accordion
    $(".accordion").tabs(".pane", {
        tabs: '> h2',
        effect: 'slide',
        initialIndex: null
    });

    //The click to hide function
    $(".accordion > h2").click(function() {
        if ($(this).hasClass("current") && $(this).next().queue().length === 0) {
            $(this).next().slideUp();
            $(this).removeClass("current");
        } else if (!$(this).hasClass("current") && $(this).next().queue().length === 0) {
            $(this).next().slideDown();
            $(this).addClass("current");
        }
    });
});

</script>

</head>
<body>
<header>
<h1>Index of Projects for CS2803</h1>
<h3>By: Thomas Doolittle</h3>
</header>
<?php
error_reporting(0);

echo "<div id='nav'>";
echo "<div class='accordion'>";

foreach (new RecursiveDirectoryIterator('content') as $dir) {
    $name = substr($dir.key(), 8, strlen($dir.key()) - 1);

    if ( !($name == '.' || $name == '..') && is_dir($dir) ) {
        echo '<h2>'.$name.'</h2>';
        echo "<div class='pane'>";
        listFiles( $dir.key() );
        echo "</div>";
    }

}

function listFiles( $path ) {
    


    $handle = opendir($path);
    while ( false !== ($entry = readdir($handle)) ) {
        if ( $entry != '.' && $entry != '..' && $entry[strlen($entry)-1] != '~' ) {
            if ( is_dir($path.'/'.$entry) ) {
                echo "<div class='accordion'>";
                echo '<h2>'.$entry.'</h2>';
                echo "<div class='pane'>";
                listFiles($path.'/'.$entry);
                echo "</div>";
                echo "</div>";
            } else {
                echo "<div id='file'><a href='".$path.'/'.$entry."'>".$entry."</a></div>";
            }
        }
        
    }


}

echo "</div>"; //accordion
echo "</div>"; //nav

?>

<footer>

<span>This site was last modified on: <?php echo date("F d Y H:i:s.", getlastmod()); ?></span>
<span>Check me out on <a href="http://github.com/achillesthetortise/CS2803.git">Github</a></span>
</footer>
</body>
</html>
