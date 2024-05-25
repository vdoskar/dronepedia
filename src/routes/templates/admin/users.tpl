<table class="table adminTable">
    <thead>
    <tr>
        <th>UUID</th>
        <th>Name</th>
        <th>Usertag</th>
        <th>email</th>
        <th>role</th>
        <th>Registered</th>
        <th>Updated</th>
        <th>Last Login</th>
        <th>Logged until</th>
        <th>Login Token</th>
        <th>Failed logins</th>
        <th>Blocked until</th>
    </tr>
    </thead>
    <tbody>
    {foreach $users as $user}
        <tr>
            <td>{$user.uuid}</td>
            <td>
                <input type="text" value="{$user.label}">
            </td>
            <td>
                <input type="text" value="{$user.username}">
            </td>
            <td>
                <input type="text" value="{$user.email}">
            </td>
            <td>
                <select name="user_role" id="user_role">
                    <option value="USER" {if $user.role == "USER"} selected {/if}>USER</option>
                    <option value="ADMIN" {if $user.role == "ADMIN"} selected {/if}>ADMIN</option>
                </select>
            </td>
            <td>{$user.date_registered}</td>
            <td>{$user.date_updated}</td>
            <td>{$user.date_last_login}</td>
            <td>{$user.logged_until}</td>
            <td>{$user.session_token}</td>
            <td>
                <input type="number" value="{$user.failed_login_attempts}">
            </td>
            <td>{$user.login_blocked_until|default:"-"}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
