<form method="post" class="[&>input]:text-black">
    <!-- klant gegevnes -->
    <label for="email">Email-Address</label>
    <input type="email" name="email" disabled value="<?php echo $_SESSION["email"]?>">
    <label for="full-name">Voledige Naam</label>
    <input type="text" name="full-name">
    <label for="telefoonnummer">Telefoonnummer</label>
    <input type="text" name="telefoonnummer">
    <!-- verzend gegevens -->
    <label for="postcode">Postcode</label>
    <input id="postcode" name="zip" type="text" inputmode="numeric" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}">
    <label for="huisnummer">Huisnummer</label>
    <input type="text" name="huisnummer">
    <label for="straatnaam">Straatnaam</label>
    <input type="text" name="straatnaam">
    <label for="woonplaats">Woonplaats</label>
    <input type="text" name="woonplaats">

    <button type="submit" name="terug-submit" value="Volgende">Terug</button>
    <button type="submit" name="register-submit" value="Volgende">Volgende</button>
</form>