var showText = true;

function changeText(){
    //This function changes the text in the <section> element
    if( showText ) {
	document.getElementsByTagName("footer")[0].innerHTML ="<h2>We the People</h2> of the United States, in Order to form a more perfect Union, establish Justice, insure domestic Tranquility, provide for the common defense, promote the general Welfare, and secure the Blessings of Liberty to ourselves and our Posterity, do ordain and establish this Constitution for the United States of America.";
    } else {
	document.getElementsByTagName("footer")[0].innerHTML = "&nbsp;";
    }
    showText = !showText;
}

var easterEgg = true;
function changeBackground(number){
    //This function changes the page's background
    var colors = ["white", "gray", "burlywood", "olive"];
    document.body.style.background=colors[number];
    document.querySelector("#logo span").style.color=document.body.style.background;
    if( easterEgg ) { 
	alert("Find the easter egg on this page!"); 
	easterEgg = false;
    }
}

var txtColor = "white";
var bckColor = "black";

function changeLogo(){
	//This function inverts the logo
    document.querySelector("#logo span").style.color= txtColor;
    document.querySelector("#logo span").style.background= bckColor;
    var c = txtColor;
    txtColor = bckColor;
    bckColor = c;
}

function changeAllImages(){
	//This function changes all of the images on the page to a different theme
	var elementId;
	var imageName;
	for(var i=1; i<=9; i++){
		elementId = "box0" + i;
		imageName = 'http://lorempixel.com/400/200/sports/' + i;
		document.getElementById(elementId).style.background="url(" + imageName + ")";
	}

	imageName = 'http://lorempixel.com/150/50/sports/';
	document.querySelector("#logo img").src=imageName;
}

function centerDiv(e) {

    var boxes = document.getElementsByClassName("box");

    for(var i = 0; i < boxes.length; i++) {
	
	if( boxes[i].id != e.id ) {
	    boxes[i].style.webkitTransform = "rotateX(90deg)";
	}
    }
    e.style.position = "absolute";
    e.style.margin = "300px 0px 50px 0px";
    e.style.top = "50%";
    e.style.webkitTransform = "rotateX(0deg)";
    e.style.setProperty("background-repeat", "no-repeat");
    e.style.setProperty("background-size","cover");
    e.style.setProperty("-webkit-transition", "1s");
    e.style.setProperty("width", "750px");
    e.style.setProperty("height", "350px");
    
    var node = document.createElement('script');
    node.async = true;
    node.src = "http://numbersapi.com/random/math?callback=showNumber";
    document.body.appendChild(node);
    id = e.id;

}

var id;

function showNumber(str) {
    document.getElementById('number-fact-'+id).innerText = str;
}

function resetBoxes(f) {
    
    var boxes = document.getElementsByClassName("box");
    
    for( var i = 0; i < boxes.length; i++) {
	boxes[i].style.webkitTransform = "rotateX(0deg)";
	boxes[i].style.setProperty("width","375px");
	boxes[i].style.setProperty("height","175px");
	boxes[i].style.setProperty("margin","0 0 45px 0");
    }
    
    if( f.className.indexOf("row1") > -1 ) {
	f.style.setProperty("top","350px");
    } else if( f.className.indexOf("row2") > -1 ) {
	f.style.setProperty("top","552px");
    } else if( f.className.indexOf("row3") > -1 ) {
	f.style.setProperty("top","755px");
    } 
    
    if( f.className.indexOf("col1") > -1 ) {
	f.style.setProperty("left","50px");
    } else if( f.className.indexOf("col2") > -1 ) {
	f.style.setProperty("left","452px");
    } else if( f.className.indexOf("col3") > -1 ) {
	f.style.setProperty("left","855px");
    }

    f.style.setProperty("position","absolute");
    
    document.getElementById('number-fact-'+f.id).innerHTML = '';
}

var windowSelected = false;

function windowDisplay(g) {
    if( windowSelected ) {
	resetBoxes(g);
	windowSelected = false;
    } else {
	centerDiv(g);
	windowSelected = true;
    }

}

