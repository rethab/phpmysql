<!doctype html>
<head>
        <meta charset=utf-8>
        <title>Facepalminator</title>
        <link rel="stylesheet" href="style.css">
</head>
<body onload="writeName()">
        <h1>Personalized Facepalminator for FREEEEEEE!</h1>

        <?php if (isset($_GET['name'])): ?>
                <p>The Facepalminator strikes again!</p>
                <canvas id="myCanvas" width="500" height="200"></canvas>
                <img id="facepalm" src="facepalm.jpg" style="display: none">
                <br>
                <a href="index.php">I want more!</a>

                <script>
                        function writeName() {
                                var c = document.getElementById("myCanvas");
                                var ctx = c.getContext("2d");
                                var img = document.getElementById("facepalm");

                                ctx.drawImage(img, 10, 10);
                                
                                ctx.fillStyle="green";
                                ctx.font="30px Verdana"
                                ctx.fillText("OMG <?= $_GET['name'] ?>", 10, 50);
                        }
                </script>
        <?php else: ?>
                <p>Enter the name of the person you want to give a personalized instant facepalm:</p>
                <form>
                        <input name="name" required>
                        <input type="submit" value="Go">
                </form>
        <?php endif; ?>
</body>
