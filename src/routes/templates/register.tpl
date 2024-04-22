<header>
    <h1 class="text-center">
        {$title}
    </h1>
</header>

<div class="content halfBody rounded">
    <div class="authFormGroup">
        <form method="POST" id="form" class="authForm">
            <div class="form-group">
            <label for="username">Uživatelské jméno</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <br>
            <div class="form-group">
                <label for="usertag">User Tag (@)</label>
                <input type="text" id="usertag" name="usertag" class="form-control" required>
            </div> 
            <br>
            <div class="form-group">
                <label for="email">Emailová adresa</label>
                <input type="email" id="email" name="email" class="form-control" required>
                <small id="emailHelp" class="form-text text-muted">Vaši e-mailovou adresu nikde nesdílíme.</small>
            </div>
            <br>
            <div class="form-group">
                <label for="pass1">Heslo</label>
                <input type="password" id="pass1" name="pass1" class="form-control" required minlength="8">
            </div>
            <br>
            <div class="form-group">
                <label for="pass2">Heslo znovu</label>
                <input type="password" id="pass2" name="pass2" class="form-control" required minlength="8">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Registrovat</button>
            <div class="form-group mt-2">
                <small>Již máte účet? Přihlašte se <a href="/login">zde</a></small>
            </div>
        </form>
        <div class="authFormImage">
            <img src="https://picsum.photos/450/550">    
        </div>
    </div>
</div>

<script>
    document.getElementById("form").onsubmit = function(event) {
        const formData = new FormData(event.target);
        if (formData.get("pass1") !== formData.get("pass2")) {
            alert("Hesla se neshodují.");
            event.preventDefault();
            return;
        }
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        const emailAvailable = ajax.get("/api/auth/check-availible-registration", "GET", data.email);
        console.log(emailAvailable);
        event.preventDefault();
        return;

        try {
            ajax.call("/api/auth/register", "POST", data);
            alert("Registrace proběhla úspěšně.");
            window.location.href = "/login";
        } catch (e) {
            alert("Registrace se nezdařila.");
            event.preventDefault();
        }
    }
</script>