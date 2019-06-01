<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>宿舍管理系统</title>
    <style>
        body {
            padding: 0px;
            margin: 0px;
            /*background-color: #200;*/
        }

        .hidden {
            display: none;
        }
        .lizi{
            width: 750px;
            height: 200px;
            position: absolute;
            top: 10px;
            margin: 0 auto;
        }
        #spring-text {
            position: absolute;
            z-index: 20;
        }

        .topcn {
            width: 980px;
            top: 600px;
            left: 50%;
            margin-left: -490px;
            position: absolute;
            z-index: 20;

        }

        .login{
            background: transparent;
            width: 250px;
            height: 80px;
            display: block;
            text-align: center;
            margin: 0 auto;
            font-size: 50px;
            color: #4fe0fb;
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.4s;
            border-radius: 20px;
        }


        .login:hover {
            background: transparent;
            color: white;
        }
    </style>
</head>
<body>



<div id="title-desktop" class="hidden">学生宿舍管理系统</div>

<canvas id="spring-text" ></canvas>


<div class="topcn" >
    <!--<p>&nbsp;</p>-->
    <button class="login" onclick="window.location.href='?r=login'">Enter</button>
</div>
<!--<canvas id="spring-text" ></canvas>-->
<div class="header" id="demo">
    <div class="canvaszz"> </div>
    <canvas id="canvas"></canvas>
</div>




<script>


    // /***************文字粒子效果**********/



    // WRITTEN BY TRUMAN HEBERLE
    var COLOR = "#52E6FF";
    var MESSAGE = document.getElementById("title-desktop").textContent;

    var FONT_SIZE = 100;
    // var AMOUNT = 2000;
    var AMOUNT=4300;
    var SIZE = 1.5;
    var INITIAL_DISPLACEMENT = 500;
    var INITIAL_VELOCITY = 5;
    var VELOCITY_RETENTION = 0.95;
    var SETTLE_SPEED = 1;
    var FLEE_SPEED = 1;
    var FLEE_DISTANCE = 50;
    var FLEE = true;
    var SCATTER_VELOCITY = 3;
    var SCATTER = true;

    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        // Mobile
        MESSAGE = document.getElementById("title-mobile").textContent;

        FONT_SIZE = 50;
        AMOUNT = 300;
        SIZE = 2;
        INITIAL_DISPLACEMENT = 100;
        SETTLE_SPEED = 1;
        FLEE = false;
        SCATTER_VELOCITY = 2;
    }

    const canvas_1 = document.getElementById("spring-text");
    const ctx_1 = canvas_1.getContext("2d");



    var POINTS = [];
    var MOUSE = {
        x: 0,
        y: 0
    }

    function Point(x,y,r,g,b,a) {
        var angle = Math.random() * 6.28;
        this.dest_x = x;
        this.dest_y = y;
        this.original_r = r;
        this.original_g = g;
        this.original_a = a;
        this.x = canvas_1.width/2 - x + (Math.random() - 0.5) * INITIAL_DISPLACEMENT;
        this.y = canvas_1.height/2 - y + (Math.random() - 0.5) * INITIAL_DISPLACEMENT;
        this.velx = INITIAL_VELOCITY * Math.cos(angle);
        this.vely = INITIAL_VELOCITY * Math.sin(angle);
        this.target_x = canvas_1.width/2 - x;
        this.target_y = canvas_1.height/2 - y;
        this.r = r;
        this.g = g;
        this.b = b;
        this.a = a;

        this.getX = function() {
            return this.x;
        }

        this.getY = function() {
            return this.y;
        }

        this.resetTarget = function () {
            this.target_x = canvas_1.width/2 - this.dest_x;
            this.target_y = canvas_1.height/2 - this.dest_y;
        }

        this.fleeFrom = function(x, y) {
            this.velx -= ((MOUSE.x - this.x) * FLEE_SPEED / 10);
            this.vely -= ((MOUSE.y - this.y) * FLEE_SPEED / 10);
        }

        this.settleTo = function(x, y) {
            this.velx += ((this.target_x - this.x) * SETTLE_SPEED / 100);
            this.vely += ((this.target_y - this.y) * SETTLE_SPEED / 100);
            this.velx -= this.velx * (1-VELOCITY_RETENTION);
            this.vely -= this.vely * (1-VELOCITY_RETENTION);
        }

        this.scatter = function() {
            var unit = this.unitVecToMouse();
            var vel = SCATTER_VELOCITY * 10 * (0.5 + Math.random() / 2);
            this.velx = -unit.x * vel;
            this.vely = -unit.y * vel;
        }

        this.move = function() {
            if (this.distanceToMouse() <= FLEE_DISTANCE) {
                this.fleeFrom(MOUSE.x, MOUSE.y);
            }
            else {
                this.settleTo(this.target_x, this.target_y);
            }

            if (this.x + this.velx < 0 || this.x + this.velx >= canvas_1.width) {
                this.velx *= -1;
            }
            if (this.y + this.vely < 0 || this.y + this.vely >= canvas_1.height) {
                this.vely *= -1;
            }

            this.x += this.velx;
            this.y += this.vely;
        }

        this.distanceToTarget = function() {
            return this.distanceTo(this.target_x, this.target_y);
        }

        this.distanceToMouse = function() {
            return this.distanceTo(MOUSE.x, MOUSE.y);
        }

        this.distanceTo = function(x, y) {
            return Math.sqrt((x - this.x)*(x - this.x) + (y - this.y)*(y - this.y));
        }

        this.unitVecToTarget = function() {
            return this.unitVecTo(this.target_x, this.target_y);
        }

        this.unitVecToMouse = function() {
            return this.unitVecTo(MOUSE.x, MOUSE.y);
        }

        this.unitVecTo = function(x, y) {
            var dx = x - this.x;
            var dy = y - this.y;
            return {
                x: dx / Math.sqrt(dx*dx + dy*dy),
                y: dy / Math.sqrt(dx*dx + dy*dy)
            };
        }
    }

    window.addEventListener("resize", function() {
        resizeCanvas()
        adjustText()
    });

    if (FLEE) {
        window.addEventListener("mousemove", function(event) {
            MOUSE.x = event.clientX;
            MOUSE.y = event.clientY;
        });
    }

    if (SCATTER) {
        window.addEventListener("click", function(event) {
            MOUSE.x = event.clientX;
            MOUSE.y = event.clientY;
            for (var i=0; i<POINTS.length; i++) {
                POINTS[i].scatter();
            }
        });
    }
    //////画布大小
    function resizeCanvas() {
        canvas_1.width  = window.innerWidth;
        canvas_1.height = window.innerHeight/3;
    }

    function adjustText() {
        ctx_1.fillStyle = COLOR;
        ctx_1.textBaseline = "middle";
        ctx_1.textAlign = "center";
        ctx_1.font = FONT_SIZE + "px Arial";
        ctx_1.fillText(MESSAGE, canvas_1.width/2, canvas_1.height/2);
        var textWidth = ctx_1.measureText(MESSAGE).width;
        if (textWidth == 0) {
            return;
        }
        var minX = canvas_1.width/2 - textWidth/2;
        var minY = canvas_1.height/2 - FONT_SIZE/2;
        var data = ctx_1.getImageData(minX, minY, textWidth, FONT_SIZE).data;
        var isBlank = true;
        for (var i=0; i<data.length; i++) {
            if (data[i] != 0) {
                isBlank = false;
                break;
            }
        }

        if (!isBlank) {
            var count = 0;
            var curr = 0;
            var num = 0;
            var x = 0;
            var y = 0;
            var w = Math.floor(textWidth);
            POINTS = [];
            while (count < AMOUNT) {
                while (curr == 0) {
                    num = Math.floor(Math.random() * data.length);
                    curr = data[num];
                }
                num = Math.floor(num / 4);
                x = w/2 - num%w;
                y = FONT_SIZE/2 - Math.floor(num/w);
                POINTS.push(new Point(x,y,data[num*4],data[num*4 + 1],data[num*4 + 2],data[num*4 + 3]));
                curr = 0;
                count++;
            }
        }
    }

    function init() {
        resizeCanvas()
        adjustText()
        window.requestAnimationFrame(animate);
    }

    function animate() {
        update();
        draw();
    }

    function update() {
        var point;
        for (var i=0; i<POINTS.length; i++) {
            point = POINTS[i];
            point.move();
        }
    }

    function draw() {
        ctx_1.clearRect(0, 0, canvas_1.width, canvas_1.height);

        var point;
        for (var i=0; i<POINTS.length; i++) {
            point = POINTS[i];
            ctx_1.fillStyle = "rgba("+point.r+","+point.g+","+point.b+","+point.a+")";
            ctx_1.beginPath();
            ctx_1.arc(point.getX(),point.getY(),SIZE,0,2*Math.PI);
            ctx_1.fill();
        }

        window.requestAnimationFrame(animate);
    }

    init();


    // /***************文字粒子效果**********/




    //宇宙特效
    "use strict";
    var canvas = document.getElementById('canvas'),
        ctx = canvas.getContext('2d'),
        w = canvas.width = window.innerWidth,
        h = canvas.height = window.innerHeight,

        hue = 217,
        stars = [],
        count = 0,
        maxStars = 1300;//星星数量

    var canvas2 = document.createElement('canvas'),
        ctx2 = canvas2.getContext('2d');
    canvas2.width = 100;
    canvas2.height = 100;
    var half = canvas2.width / 2,
        gradient2 = ctx2.createRadialGradient(half, half, 0, half, half, half);
    gradient2.addColorStop(0.025, '#CCC');
    gradient2.addColorStop(0.1, 'hsl(' + hue + ', 61%, 33%)');
    gradient2.addColorStop(0.25, 'hsl(' + hue + ', 64%, 6%)');
    gradient2.addColorStop(1, 'transparent');

    ctx2.fillStyle = gradient2;
    ctx2.beginPath();
    ctx2.arc(half, half, half, 0, Math.PI * 2);
    ctx2.fill();




    // End cache

    function random(min, max) {
        if (arguments.length < 2) {
            max = min;
            min = 0;
        }

        if (min > max) {
            var hold = max;
            max = min;
            min = hold;
        }

        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function maxOrbit(x, y) {
        var max = Math.max(x, y),
            diameter = Math.round(Math.sqrt(max * max + max * max));
        return diameter / 2;
        //星星移动范围，值越大范围越小，
    }

    var Star = function() {

        this.orbitRadius = random(maxOrbit(w, h));
        this.radius = random(60, this.orbitRadius) / 8;
        //星星大小
        this.orbitX = w / 2;
        this.orbitY = h / 2;
        this.timePassed = random(0, maxStars);
        this.speed = random(this.orbitRadius) / 50000;
        //星星移动速度
        this.alpha = random(2, 10) / 10;

        count++;
        stars[count] = this;
    }

    Star.prototype.draw = function() {
        var x = Math.sin(this.timePassed) * this.orbitRadius + this.orbitX,
            y = Math.cos(this.timePassed) * this.orbitRadius + this.orbitY,
            twinkle = random(10);

        if (twinkle === 1 && this.alpha > 0) {
            this.alpha -= 0.05;
        } else if (twinkle === 2 && this.alpha < 1) {
            this.alpha += 0.05;
        }

        ctx.globalAlpha = this.alpha;
        ctx.drawImage(canvas2, x - this.radius / 2, y - this.radius / 2, this.radius, this.radius);
        this.timePassed += this.speed;
    }

    for (var i = 0; i < maxStars; i++) {
        new Star();
    }

    function animation() {
        ctx.globalCompositeOperation = 'source-over';
        ctx.globalAlpha = 0.5; //尾巴
        ctx.fillStyle = 'hsla(' + hue + ', 64%, 6%, 2)';
        ctx.fillRect(0, 0, w, h)

        ctx.globalCompositeOperation = 'lighter';
        for (var i = 1, l = stars.length; i < l; i++) {
            stars[i].draw();
        };

        window.requestAnimationFrame(animation);
    }

    animation();


</script>

</body>
</html>
