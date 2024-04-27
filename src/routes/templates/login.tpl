<header>
    <h1 class="text-center">
        {$title}
    </h1>
</header>

<div class="content halfBody rounded">
    <div class="authFormGroup">
        <form method="POST" class="authForm" action="/api/auth/login">
            <div class="form-group">
                <label for="email">Emailová adresa</label>
                <input type="email"
                       id="email"
                       name="email"
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
                >
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

<script>
    document.getElementById("email").value = "vladimir.doskar@tul.cz";
    document.getElementById("password").value = "A123456789";
</script>