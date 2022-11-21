<!--
	Author:         Michele Lorenzo
	Course:         B
	Description:    PHP page that contains form for signup.
	Content:        PHP & HTML code
--> 

<?php include("top.html"); ?>

<form action="signup-submit.php" method="POST">
    <fieldset>
        <legend>New User Signup:</legend>
        
        <div>
            <label for="name" class="left"><strong>Name:</strong></label>
            <input type="text" name="name" size="16" id="name">
        </div>    
        
        <div>
            <label class="left"><strong>Gender:</strong></label>
            <input type="radio" id="male" name="gender" value="M">
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="F">
            <label for="female">Female</label>
        </div>

        <div>
            <label for="age" class="left"><strong>Age:</strong></label>
            <input type="text" name="age" size="6" maxlength="2" id="age">
        </div>

        <div>
            <label for="personalityType" class="left"><strong>Personality Type:</strong></label>
            <input type="text" name="personalityType" size="6" maxlength="4" id="personalityType">
            (<a href="http://www.humanmetrics.com/cgi-win/JTypes2.asp">Don't know your type?</a>)
        </div>

        <div>
            <label for="favoriteOS" class="left"><strong>Favorite OS:</strong></label>
            <select name="favoriteOS" id="favoriteOS">
                <option value="Windows">Windows</option>
                <option value="Mac OS X">Mac OS X</option>
                <option value="Linux" selected>Linux</option>
            </select>
        </div>

        <div>
            <label class="left"><strong>Seeking Age:</strong></label>
            <input type="text" name="minAge" size="6" maxlength="2" placeholder="min"> to 
            <input type="text" name="maxAge" size="6" maxlength="2" placeholder="max">
        </div>

        <input type="submit" value="Sign UP">
    </fieldset>
</form>

<?php include("bottom.html"); ?>