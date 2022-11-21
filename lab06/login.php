<!--
    Quessto file contiene il codice HTML della pagina di login.
    Autore: Michele Lorenzo
    Corso: B
-->

<?php include("html/top.html"); ?>
    <script src="js/login.js"></script>
</head>

<body>
    <?php include("html/banner.html"); ?>
    
    <h1>The One Degree of Kevin Bacon</h1>

    <div id="flash"></div>

    <fieldset id="login">
        <legend>Login</legend>
        <div>
            <label for="username">Username</label><br>
            <input type="text" name="username" id="username" placeholder="Enter your username" maxlength="16" required>
            <br>
            <br>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" placeholder="Enter your password" maxlength="16" required>
            <br>
            <br>
            <input type="submit" value="Login" id="loginSubmit">
        </div>
    </fieldset>

<?php include("html/bottom.html"); ?>