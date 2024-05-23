
<div class="content halfBody mt-8">
    <h1 class="text-center">{$title}</h1>
    <div class="authFormGroup">
        <form method="POST" id="registerForm" class="authForm" action="/api/auth/register">
            <div class="form-group">
            <label for="username">Uživatelské jméno</label>
                <input type="text"
                       id="username"
                       name="username"
                       class="form-control"
                       required
                >
            </div>
            <br>
            <div class="form-group">
                <label for="usertag">User Tag (@)</label>
                <input type="text"
                       id="usertag"
                       name="usertag"
                       class="form-control"
                       required
                >
            </div> 
            <br>
            <div class="form-group">
                <label for="email">Emailová adresa</label>
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       required
                >
                <small id="emailHelp" class="form-text text-muted">Vaši e-mailovou adresu nikde nesdílíme.</small>
            </div>
            <br>
            <div class="form-group">
                <label for="pass1">Heslo</label>
                <input type="password"
                       id="pass1"
                       name="pass1"
                       class="form-control"
                       required
                       title="Heslo musí mít minimálně 8 znaků."
                >
            </div>
            <br>
            <div class="form-group">
                <label for="pass2">Heslo znovu</label>
                <input type="password"
                       id="pass2"
                       name="pass2"
                       class="form-control"
                       required
                       title="Heslo musí mít minimálně 8 znaků."
                >
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Registrovat</button>
            <div class="form-group mt-2">
                <small>Již máte účet? Přihlašte se <a href="/login">zde</a></small>
            </div>
        </form>
        <div class="authFormImage">
            <img src="https://picsum.photos/450/550" alt="Registrační obrázek">
        </div>
    </div>
</div>


<script>

    // Slugify usertag
    document.getElementById("usertag").addEventListener("input", function(event) {
        event.target.value = utils.slugify(event.target.value.replace(" ", ""));
    });

    // handle form submission
    document.getElementById("registerForm").onsubmit = function(event) {
        event.preventDefault();
        const formData = new FormData(event.target);

        if (formData.get("pass1") !== formData.get("pass2")) {
            alert("Hesla se neshodují.");
            return;
        }

        if (formData.get("pass1").length < 8) {
            alert("Heslo musí mít minimálně 8 znaků.");
            return;
        }

        if (formData.get("username").length < 3) {
            alert("Uživatelské jméno musí mít minimálně 3 znaky.");
            return;
        }

        if (!utils.regex.isValidEmail(formData.get("email"))) {
            alert("Neplatný formát e-mailové adresy");
            return;
        }

        event.target.submit();
    }
</script>