<!--
	Author:         Michele Lorenzo
	Course:         B
	Description:    PHP page that contains form for match.
	Content:        PHP & HTML code
--> 

<?php include("top.html"); ?>

<form action="matches-submit.php" method="GET">
    <fieldset>
        <legend>Returning User:</legend>

        <div> 
            <label for="name"><strong>Name:</strong></label>
            <input type="text" name="name" size="16" id="name">
        </div>

        <input type="submit" value="View My Matches">
    </fieldset>
</form>

<?php include("bottom.html"); ?>