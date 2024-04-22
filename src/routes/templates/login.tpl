<header>
    <h1 class="text-center">
        {$title}
    </h1>
</header>

<div class="content halfBody rounded">
    <div class="authFormGroup">
        <form method="POST" class="authForm">
            <div class="form-group">
                <label for="email">Emailová adresa</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="">
            </div>
            <br>
            <div class="form-group">
                <label for="pass1">Heslo</label>
                <input type="password" id="pass1" name="pass1" class="form-control" placeholder="">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Přihlásit se</button>
            <div class="form-group mt-2">
                <small>Ještě nemáte účet? Registrujte se <a href="/register">zde</a></small>
            </div>
        </form>
        <div class="authFormImage">
            <img src="https://picsum.photos/450/250">
        </div>
    </div>
</div>
