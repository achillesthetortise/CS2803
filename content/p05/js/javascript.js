var itemNames = ['Multi-tool', 'Hammer', 'Saw', 'Power Drill', 'Dremel', 'Lug Wrench','Crimping Tool','Cable Cutter','Skate Tool','Garden Rake','Screwdriver','Shears','Power Saw','Air Pressure Gauge','Multimeter','Brake Pad Separator','Wheel Barrow','Spade','Wrench','Vice'];
var prices = [34.15,12.99,15.47,47.68,52.96,8.45,13.49,17.63,16.15,11.23,19.74,3.23,1.12,74.87,65.19,23.99,14.70,50.00,4.28,81.62];
var numCols = 4;
var buttonWidth = 160;
var buttonHeight = 80;
var total = 0;

function pageLayout() {
    var content = document.createElement('div');
    content.id = "content";
    document.body.appendChild(content);

    var register = document.createElement('div');
    register.id = "register";
    register.style.width = (numCols*buttonWidth+100)+'px';
    document.getElementById('content').appendChild(register);

    var totalCost = document.createElement('div');
    totalCost.id = "totalCost";
    document.getElementById('register').appendChild(totalCost);

    var screenTotal = document.createElement('div');
    screenTotal.id = "screenTotal";
    document.getElementById("totalCost").appendChild(screenTotal);

    var t = document.createElement('div');
    t.id = "total";
    t.innerHTML = '$'+total.toFixed(2);
    document.getElementById("screenTotal").appendChild(t);

    var itemSection = document.createElement('div');
    itemSection.id = "itemSection";
    document.getElementById('register').appendChild(itemSection);

    var receipt = document.createElement('div');
    receipt.id = "receipt";
    receipt.style.left = (numCols*buttonWidth+250)+'px';
    document.getElementById('content').appendChild(receipt);

    var screenReceipt = document.createElement('div');
    screenReceipt.id = "screenReceipt";
    document.getElementById('receipt').appendChild(screenReceipt);

    makeButtons();

}

function makeButtons() {
    var rowPos = 0;
    var colPos = 0;
    for( var i = 1; i <= itemNames.length; ++i ) {

	var button = document.createElement('div');
	button.id = 'button'+i;
	button.className = 'button';
	button.style.position = 'absolute';
	button.style.width = buttonWidth+'px';
	button.style.height = buttonHeight+'px';
	button.style.top = (rowPos+15)+'px';
	button.style.left = (((i-1)%numCols)*buttonWidth+(15*((i-1)%numCols)))+'px';
	button.title = itemNames[i-1];
	
	var itemPic = document.createElement('img');
	itemPic.id = 'pic'+i;
	itemPic.setAttribute("data-itemname",itemNames[i-1]);
	itemPic.src = "img/items/"+itemNames[i-1]+".jpg";
	itemPic.style.height = 80+'px';
	button.appendChild(itemPic);
	
	var price = document.createElement('span');
	price.className = 'itemPrice';
	price.innerHTML = '$'+prices[i-1].toFixed(2);
	button.appendChild(price);

	button.onmousedown = buttonDown;
	button.onmouseup = buttonUp;
	button.onclick = addToReceipt;

	document.getElementById('itemSection').appendChild(button);

	if( i % numCols == 0 ) {
	    rowPos += buttonHeight + 15;
	}
    }
    document.getElementById('register').style.height = (rowPos+25)+'px';
    document.getElementById('receipt').style.height = (rowPos+25)+'px';
    document.getElementById('screenReceipt').style.height = (rowPos-75)+'px';
    document.getElementById('screenReceipt').style.bottom = 25+'px';

    var button = document.createElement('div');
    button.id = 'clear';
    button.className = 'button';
    button.style.position = 'absolute';
    button.style.width = 266+'px';
    button.style.height = 20+'px';
    button.style.left = 15+'px';
    button.style.top = 15+'px';
    button.innerHTML = "Clear";
    button.onmousedown = buttonDown;
    button.onmouseup = buttonUp;
    button.onclick = clearReceipt;
    document.getElementById('receipt').appendChild(button);

    var button = document.createElement('div');
    button.id = 'removeSelected';
    button.className = 'button';
    button.style.position = 'absolute';
    button.style.width = 266+'px';
    button.style.height = 20+'px';
    button.style.left = 15+'px';
    button.style.top = 40+'px';
    button.innerHTML = "Remove Selected";
    button.onmousedown = buttonDown;
    button.onmouseup = buttonUp;
    button.onclick = removeSelected;
    document.getElementById('receipt').appendChild(button);
}

function buttonDown() {
    this.style.border = 'inset 3px';
}

function buttonUp() {
    this.style.border = 'outset 3px';
}

function addToReceipt(arg) {
    var t = document.getElementById("total");
    var p = parseFloat(this.lastChild.innerHTML.slice(1));
    total += p;
    t.innerHTML = '$'+total.toFixed(2); 

    var newItem = document.createElement('div');
    newItem.className = "receiptItem";
    newItem.style.cursor = "pointer";
    newItem.setAttribute('data-toBeRemoved',false);
    var space = p < 10 ? "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" : "&nbsp;&nbsp;&nbsp;&nbsp;";
    newItem.innerHTML = this.title+space+"$"+p.toFixed(2);
    newItem.onclick = removeToggle;
    document.getElementById("screenReceipt").appendChild(newItem);
}

function clearReceipt() {
    var r = confirm("Click ok to clear your shopping cart, otherwise cancel.");
    if(r) {
	total = 0;
	document.getElementById("total").innerHTML = '$'+total.toFixed(2);
	var node = document.getElementById("screenReceipt");
	while( node.hasChildNodes() ) { node.removeChild(node.lastChild); }
    } 
}

function removeToggle() {    
    var p = this.getAttribute('data-toBeRemoved');
    if(p == "false") {
	this.setAttribute('data-toBeRemoved',true);
	this.style.background = "#585858";
    } else {
	this.setAttribute('data-toBeRemoved',false);
	this.style.background = "#000000";
    }
}

function removeSelected() {
    var node = document.getElementById("screenReceipt");
    var n = node.firstChild;
    while(n) {
	if( n.getAttribute('data-toBeRemoved') == 'true') {
	    total -= Number(n.innerHTML.split("$")[1]);
	    var c = n.nextSibling;
	    node.removeChild(n);
	    n = c;
	} else {
	    n = n.nextSibling;
	}
    }
    var t = document.getElementById("total");
    if(total < 0.05) total = 0.00;
    t.innerHTML = '$'+total.toFixed(2);
    
}