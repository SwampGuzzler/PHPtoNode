function addArrowHead(canvas, my_orx, my_ory, beta) {
// allow arrow width = 30 deg, half, in radians, = 0.262
// h is diam of circle on wh arrow wingtips lie; arrow length = 20
	var h = 20/Math.cos(0.262);
	var myalpha = beta + 0.262 + Math.PI;	
	var neww = h * Math.cos(myalpha);
	var newh = neww * Math.tan(myalpha);
	var a1 = neww + parseFloat(my_orx);
	var b1 = newh + parseFloat(my_ory);
	myalpha = beta - 0.262 + Math.PI;	
	neww = h * Math.cos(myalpha);
	newh = neww * Math.tan(myalpha);	
	var a2 = neww + parseFloat(my_orx);
	var b2 = newh + parseFloat(my_ory);	
	dumbTriangle(canvas, my_orx, my_ory, a1,b1, a2,b2, cur_color);
}	

function drawCircle(canvas, myX, myY, mycolor, rad) {
//    var canvas = document.getElementById('myCanvas');
    var context = canvas.getContext('2d');
	context.strokeStyle = mycolor;
	context.lineWidth = 1;
	context.beginPath();
	context.arc(myX, myY, rad, 0, Math.PI*2, true);
	context.closePath();
	context.stroke();
	return;
}
function drawDot(canvas, myX, myY, mycolor, rad) {
    var context = canvas.getContext('2d');
	context.fillStyle = mycolor;
	context.beginPath();
	context.arc(myX, myY, rad, 0, Math.PI*2, true);
	context.closePath();
	context.fill();
	return;
}
function drawLine(canvas, x0, y0, x1, y1, mycolor, howThick) {
 //   var canvas = document.getElementById('myCanvas');
    var context = canvas.getContext('2d');
	context.beginPath();	
	context.strokeStyle = mycolor;
	context.lineWidth = howThick;
	context.beginPath();
	context.moveTo(x0, y0);
	context.lineTo(x1, y1);
	context.stroke();
	return;
}

function dumbTriangle(canvas, orx, ory, x1,y1, x2,y2, color) {
	var ctx=canvas.getContext("2d");
	ctx.fillStyle=color;
	ctx.beginPath();
	ctx.moveTo(x1,y1);
	ctx.lineTo(orx,ory);
	ctx.lineTo(x2,y2);
	ctx.closePath();
	ctx.fill();
}
function eraseRegion(send_canvas, myx, myy, myw, myh) {
    var canvas = document.getElementById(send_canvas);
    var context = canvas.getContext('2d');	
	context.fillStyle = 'rgb(230,237,255)';
	context.fillRect(myx,myy, myw, myh);
	return;
}
function fillCanvasColor(which, color) {
	var canvas = document.getElementById(which);
	var context = canvas.getContext('2d');
	context.fillStyle = color;
	context.fillRect(0,0, canvas.width, canvas.height);
	return;
}
// get mouse position where clicked on canvas
function getMousePos(canvas, evt){
  // get canvas position
    var obj = canvas;
    var top = 0;
    var left = 0;
    while (obj && obj.tagName != 'BODY') {
        top += obj.offsetTop;
        left += obj.offsetLeft;
        obj = obj.offsetParent;
    }
  // return relative mouse position
    var mouseX = evt.clientX - left + window.pageXOffset;
    var mouseY = evt.clientY - top + window.pageYOffset;
    return {
        x: mouseX,
        y: mouseY
    }
}

function popup(mylink, windowname)
{
if (! window.focus)return true;
var href;
if (typeof(mylink) == 'string')
   href=mylink;
else
   href=mylink.href;
window.open(href, windowname, 'width=550,height=550,scrollbars=yes');
return false;
}
function putOnLabels(send_canvas, mycolor) {  
	var usecolor = mycolor;
	var canvas = document.getElementById(send_canvas);													
	var myForm = document.getElementById("originForm");
	var xs = 0; var ys = 0; var xe = 0; var ye = 0;
	var i = 0;	var j = 0;	
	var a = 0; var b = 0;
	var qnum = 1;
// check whether this form cell exists, if so put on label
// NOTE!! cast string values in cells into integers using Number()	
	
	for (i = 0; i < 40; i=i+4) {
		if (myForm.elements[i]) {
			j = i;
			xs = Number(myForm.elements[j].value);
			j++;
			ys = Number(myForm.elements[j].value);
			j++;
			xe = Number(myForm.elements[j].value);
			j++;
			ye = Number(myForm.elements[j].value);
			drawLine(canvas, xs, ys, xe, ye, usecolor, 2);
			drawDot(canvas, xe, ye, 'white', 9);
			drawCircle(canvas, xe, ye, 'black', 9);	
	
			if (qnum < 10) {
				a = xe - 4; 
				b = ye + 4;
				writeQNum(canvas, qnum, a, b);
			} else {
				writeQNum(canvas, qnum, xe-8, ye+4);
			}
			
			qnum++;
		}	else {
				break;
		}		
	}
	return;
}	
function showCenterImage(what_canvas, my_image, myx, myy, center) {
	var canvas=document.getElementById(what_canvas);
	var context=canvas.getContext("2d");
	var img=new Image();

//	as soon as image is loaded, draw it
	img.onload = function(){
		if (center == true) {
			var w = img.width;
			var h = img.height;
			var cornx = myx;
			var corny = myy;
			var margin = canvas.width - cornx - w;
			myx = cornx + Math.round(margin/2);
			margin = canvas.height - corny - h;
			myy = corny + Math.round(margin/2);
		}
		context.drawImage(img, myx, myy);
	};
	img.src = my_image;
	return;
}
function oldShowImage() {
	var c=document.getElementById("myCanvas");
	var context=c.getContext("2d");
	var img=new Image();

//	as soon as image is loaded, ask for width & height
	img.onload = function(){
		var w = img.width;
		var h = img.height;
		var off_w = (800 - w)/2;
		var off_h = (540 - h)/2;
			context.drawImage(img,off_w,off_h);
		};
	var D = document.getElementById("imagebutton");
	img.src = D.value;
}
function showStoryImage(which, passImage) {
	var c=document.getElementById(which);
	var context=c.getContext("2d");
	var img=new Image();
//	as soon as image is loaded, draw it
	img.onload = function(){
		var w = img.width;
		var h = img.height;
		var off_w = (800 - w)/2;
		var off_h = (460 - h)/2;
		context.drawImage(img,off_w,off_h);
	};
//	var D = document.getElementById(passImage);
	img.src = passImage;
	return;
}
function showImage(which, passImage) {
	var c=document.getElementById(which);
	var context=c.getContext("2d");
	var img=new Image();
//	as soon as image is loaded, draw it
	img.onload = function(){
		var w = img.width;
		var h = img.height;
		var off_w = (800 - w)/2;
		var off_h = (540 - h)/2;
		context.drawImage(img,off_w,off_h);
	};
//	var D = document.getElementById(passImage);
	img.src = passImage;
	return;
}

function writeQNum(canvas, message, x, y){
    var context = canvas.getContext('2d');
    context.font = '12pt Georgia';
    context.fillStyle = 'black';
    context.fillText(message, x, y);
}
function writeMessage(canvas, message, x, y){
    var context = canvas.getContext('2d');
//    context.clearRect(0, 0, canvas.width, canvas.height);
    context.font = '13pt Calibri';
    context.fillStyle = 'black';
    context.fillText(message, x, y);
}