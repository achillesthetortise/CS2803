var c = document.getElementById("container-main");
c.style.width = Math.floor(document.body.clientWidth*0.8) + "px";
c.style.marginLeft = Math.floor(document.body.clientWidth*0.1) + "px";

var a = document.getElementById("about");
var s = document.getElementById("slider1_container");
a.style.width = parseInt(c.style.width,10) - parseInt(s.style.width) - 20 + "px";
a.style.height = s.style.height;
console.log(a.style.width);

var l = document.getElementById("left-col");
l.style.width = Math.floor(document.body.clientWidth*0.4-20) + "px";

var r = document.getElementById("right-col");
r.style.width = Math.floor(document.body.clientWidth*0.4-20) + "px"; 