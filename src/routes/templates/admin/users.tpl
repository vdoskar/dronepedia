<form action="/api/admin/user/save-all" method="POST">
    <button class="btn btn-primary">
        Uložit vše
    </button>
    <table class="table adminTable">
        <thead>
        <tr>
            <th>UUID</th>
            <th>Jméno</th>
            <th>Usertag</th>
            <th>Email</th>
            <th>Role</th>
            <th>Registrace</th>
            <th>Aktualizace</th>
            <th>Poslední přihl.</th>
            <th>Přihlášen do</th>
            <th>Token</th>
            <th>Špatná přihl.</th>
            <th>Blokován do</th>
        </tr>
        </thead>
        <tbody>
        {foreach $users as $user}
            <tr>
                <td><a href="/profile?u={$user.username}">{$user.uuid}</a></td>
                <td>
                    <input type="text" value="{$user.label}" name="user_data[{$user.uuid}][label]">
                </td>
                <td>
                    <input type="text" value="{$user.username}" name="user_data[{$user.uuid}][username]">
                </td>
                <td>
                    <input type="text" value="{$user.email}" name="user_data[{$user.uuid}][email]">
                </td>
                <td>
                    <select id="user_role" name="user_data[{$user.uuid}][role]">
                        <option value="USER" {if $user.role == "USER"} selected {/if}>USER</option>
                        <option value="ADMIN" {if $user.role == "ADMIN"} selected {/if}>ADMIN</option>
                    </select>
                </td>
                <td>{$user.date_registered}</td>
                <td>{$user.date_updated}</td>
                <td>{$user.date_last_login}</td>
                <td>{$user.logged_until}</td>
                <td style="max-width: 5vw; overflow-x: scroll">{$user.session_token}</td>
                <td>
                    <input type="number" value="{$user.failed_login_attempts}" style="max-width: 50px;" name="user_data[{$user.uuid}][failed_login_attempts]">
                </td>
                <td>{$user.login_blocked_until|default:"-"}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</form>