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
            <td>{$user.label}</td>
            <td>{$user.username}</td>
            <td>{$user.email}</td>
            <td>{$user.role}</td>
            <td>{$user.date_registered}</td>
            <td>{$user.date_updated}</td>
            <td>{$user.date_last_login}</td>
            <td>{$user.logged_until}</td>
            <td>{$user.session_token}</td>
            <td>{$user.failed_login_attempts}</td>
            <td>{$user.login_blocked_until|default:"-"}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
