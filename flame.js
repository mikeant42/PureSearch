var c = document.getElementById('c'),
    ctx = c.getContext('2d'),
    cw = c.width = 100, // padding
    ch = c.height = 275, // padding
    parts = [],
    partCount = 200,   
    partsFull = false,    
    hueRange = 200, // This is for changing the diversity of colors. The more hue, the more colors at one time.
    globalTick = 0,
    rand = function(min, max){
        return Math.floor( (Math.random() * (max - min + 1) ) + min);
    };

var Part = function(){
  this.reset();
};

Part.prototype.reset = function(){
  this.startRadius = rand(1, 25); // This is for changing the size
  this.radius = this.startRadius;
  this.x = cw/2 + (rand(0, 6) - 3);
  this.y = 250;      
  this.vx = 0;
  this.vy = 0;
  this.hue = rand(globalTick - hueRange, globalTick + hueRange);
  this.saturation = rand(50, 100);
  this.lightness = rand(70, 80); // This is for changine the brightness
  this.startAlpha = rand(1, 10) / 100;
  this.alpha = this.startAlpha;
  this.decayRate = .1;  
  this.startLife = 7; // This is for changing the height of the smoke.
  this.life = this.startLife;
  this.lineWidth = rand(1, 3);
}
    
Part.prototype.update = function(){  
  this.vx += (rand(0, 200) - 100) / 1500;
  this.vy -= this.life/50;  
  this.x += this.vx;
  this.y += this.vy;  
  this.alpha = this.startAlpha * (this.life / this.startLife);
  this.radius = this.startRadius * (this.life / this.startLife);
  this.life -= this.decayRate;  
  if(
    this.x > cw + this.radius || 
    this.x < -this.radius ||
    this.y > ch + this.radius ||
    this.y < -this.radius ||
    this.life <= this.decayRate
  ){
    this.reset();  
  }  
};
  
Part.prototype.render = function(){
  ctx.beginPath();
  ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
  ctx.fillStyle = ctx.strokeStyle = 'hsla('+this.hue+', '+this.saturation+'%, '+this.lightness+'%, '+this.alpha+')';
  ctx.lineWidth = this.lineWidth;
  ctx.fill();
  ctx.stroke();
};

var createParts = function(){
  if(!partsFull){
    if(parts.length > partCount){
      partsFull = true;
    } else {
      parts.push(new Part()); 
    }
  }
};
  
var updateParts = function(){
  var i = parts.length;
  while(i--){
    parts[i].update();
  }
};

var renderParts = function(){
  var i = parts.length;
  while(i--){
    parts[i].render();
  }   
};
    
var clear = function(){
  ctx.globalCompositeOperation = 'destination-out';
  ctx.fillStyle = 'hsla(0, 0%, 0%, .3)';
  ctx.fillRect(0, 0, cw, ch);
  ctx.globalCompositeOperation = 'lighter';
};
     
var loop = function(){
  window.requestAnimFrame(loop, c);
  clear();
  createParts();
  updateParts();
  renderParts();
  globalTick++;
};

window.requestAnimFrame=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(a){window.setTimeout(a,1E3/60)}}();

loop();

/*
	//////////////////////////////////////////////////////////////////////////////////
	Draw the vines
	//////////////////////////////////////////////////////////////////////////////////
*/

var interval;
	
	drawVineForP();				

		
		function drawVineForP() {
			
			// Define lattice
			var lattice = new Array(
				new Array({x:255, y:50}, {x:255, y:255}),
        new Array({x:255, y:50}, {x:815, y:120}),
        new Array({x:255, y:100}, {x:815, y:-100})
			);	
			
			// Get canvas context
			var canvas = $("#example")[0];
			canvas.width = 500;
			canvas.height = 900;		
			if (canvas.getContext) {
				var context = canvas.getContext("2d");	
				
				// Clear canvas
				context.clearRect(0, 0, canvas.width, canvas.height);					
			
				// Draw lattice
				context.lineWidth = 0;
				context.strokeStyle = "rgba(213, 213, 213, 0)";
				for (var i in lattice) {
					context.beginPath();
					context.moveTo(lattice[i][0].x, lattice[i][0].y);
					context.lineTo(lattice[i][1].x, lattice[i][1].y);
					context.stroke();
					context.closePath();
				}
				
				// Draw vine
				interval = drawVineWithLattice(context, lattice, 200, 270, 600, true, true);
			}
		}
		
function drawVineForU() {
			
			// Define lattice
			var lattice = new Array(
				new Array({x:255, y:50}, {x:255, y:255}),
        new Array({x:255, y:50}, {x:815, y:120}),
        new Array({x:255, y:100}, {x:815, y:-100})
			);	
			
			// Get canvas context
			var canvas = $("#u")[0];
			canvas.width = $("#u").width();
			canvas.height = $("#u").height();		
			if (canvas.getContext) {
				var context = canvas.getContext("2d");	
				
				// Clear canvas
				context.clearRect(0, 0, canvas.width, canvas.height);					
			
				// Draw lattice
				context.lineWidth = 1;
				context.strokeStyle = "rgb(213, 213, 213)";
				for (var i in lattice) {
					context.beginPath();
					context.moveTo(lattice[i][0].x, lattice[i][0].y);
					context.lineTo(lattice[i][1].x, lattice[i][1].y);
					context.stroke();
					context.closePath();
				}
				
				// Draw vine
				interval = drawVineWithLattice(context, lattice, 200, 270, 600, true, true);
			}
		}
		