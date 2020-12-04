<!DOCTYPE html>
<html>
    <head>
        <title>Registracija</title>
    </head>
    <body>
        <h1> Registracija </h1>
        <form action="" method="post">
            <input type="hidden" name="id" />
            Ime: <input type="text" name="ime" /><br />
            Priimek: <input type="text" name="priimek"  /><br />
            Elektronski naslov: <input type="text" name="email"  /><br />
            Naslov: <input type="text" name="email"  /><br />
            Geslo: <input type="text" name="geslo" /><br />
            Ponovitev gesla: <input type="text" name="pgeslo"  /><br />
            <input type="radio" id="prodajalec" name="vloga" value="prodajalec">
            <label for="prodajalec">Prodajalec</label>
            <input type="radio" id="stranka" name="vloga" value="stranka">
            <label for="stranka">Stranka</label><br>
            <p><button>Pošlji</button></p>
        </form>
    </body>
</html>
