var elms = document.querySelectorAll("[id='graph']");

for(var i = 0; i < elms.length; i++){
var el = elms[i]; // get canvas
var options = {
    percent:  el.getAttribute('data-percent') || '25%',
    size: el.getAttribute('data-size') || 220,
    lineWidth: el.getAttribute('data-line') || 15,
    rotate: el.getAttribute('data-rotate') || 0,
    text: el.getAttribute('data-text') || '',
    color: el.getAttribute('data-color') || ''
}

var canvas = document.createElement('canvas');
var span = document.createElement('span');
canvas.className = 'canvasc';
span.className = 'spanc';
span.textContent = options.text;
    
if (typeof(G_vmlCanvasManager) !== 'undefined') {
    G_vmlCanvasManager.initElement(canvas);
}

var ctx = canvas.getContext('2d');
canvas.width = canvas.height = options.size;
if(options.color == ''){
if(options.percent == 100){
    options.color = 'yellow';
}
else if(options.percent >= 50){
    options.color = 'green';
}
else{
    options.color = 'red';
}}
el.appendChild(span);
el.appendChild(canvas);

ctx.translate(options.size / 2, options.size / 2); // change center
ctx.rotate((-1 / 2 + options.rotate / 180) * Math.PI); // rotate -90 deg

//imd = ctx.getImageData(0, 0, 240, 240);
var radius = (options.size - options.lineWidth) / 2;

var drawCircle = function(color, lineWidth, percent) {
		percent = Math.min(Math.max(0, percent || 1), 1);
		ctx.beginPath();
		ctx.arc(0, 0, radius, 0, Math.PI * 2 * percent, true);
		ctx.strokeStyle = color;
        ctx.lineCap = 'round'; // butt, round or square
		ctx.lineWidth = lineWidth
		ctx.stroke();
};

drawCircle('#efefef', options.lineWidth, 100 / 100);
drawCircle(options.color, options.lineWidth, (100 - options.percent) / 100);}