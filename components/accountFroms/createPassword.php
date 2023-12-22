     <input id="username" type="email" value="<?php echo $_SESSION["email"] ?>" hidden>
    <label for="password">Password</label>
    <input type="password" name="new-password" autocomplete="new-password" required>
    <label for="password">Repeat Password</label>
    <input type="password" name="rep-new-password" autocomplete="new-password" required>
    <form method="post"><button type="submit" name="terug-create-password-submit" value="Volgende">Terug</button></form>
    <button type="submit" name="create-password-submit" value="Volgende">Volgende</button>