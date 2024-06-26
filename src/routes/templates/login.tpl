<div class="content halfBody">
    <h1 class="text-center">{$title}</h1>
    <div class="authFormGroup">
        <form method="POST" class="authForm" action="/api/auth/login">
            <div class="form-group">
                <label for="email">Emailová adresa</label>
                <input type="email"
                       id="email"
                       name="email"
                       required
                       class="form-control"
                >
            </div>
            <br>
            <div class="form-group">
                <label for="pass1">Heslo</label>
                <input type="password"
                       id="password"
                       name="password"
                       class="form-control"
                       title="Heslo musí mít minimálně 8 znaků."
                       required
                >
            </div>
            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Přihlásit se</button>
            </div>
            <br>
            <div class="form-group mt-2">
                <small>Ještě nemáte účet? Registrujte se <a href="/register">zde</a></small>
            </div>
        </form>
        <div class="authFormImage">
            <img src="https://cdn.dronepedia.krisp1k.eu/images/form_login.jpg" alt="Obrázek přihlašovací obrazovky">
        </div>
    </div>
</div>