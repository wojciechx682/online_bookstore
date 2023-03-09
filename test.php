<!DOCTYPE html>
<html>
<head>
    <title>Change Background Image</title>
    <style>
        body {
            background-image: url('2.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;

        }
    </style>
    <script>
        var newBackgroundImage = new Image();
        newBackgroundImage.onload = function() {
            document.body.style.backgroundImage = "url('3.png')";
        };
        newBackgroundImage.src = "3.png";
    </script>
</head>
<body>
<!-- your content here -->
</body>
</html>
