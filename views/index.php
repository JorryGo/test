<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test task</title>
    <script src="/frontend/jquery.js"></script>
    <link rel="stylesheet" href="/frontend/style.css">
</head>
<body>

<h1 class="title">Reviews page</h1>

<form class="form" id="submitForm" action="/send" method="post">
    <input type="text" minlength="1" name="name" placeholder="Name" required>
    <input type="email" minlength="1" name="email" placeholder="Email" required>
    <br>
    <textarea name="text" placeholder="Your text" required></textarea>

    <button class="send-button" type="submit">Send</button>
</form>

<div id="info" class="info hide">text</div>

<div id="reviews"></div>

<script src="/frontend/app.js"></script>
</body>
</html>