<div class="drone-card" data-drone-id="{$drone.id}">
    <div class="dc-img">
        <img src="{$drone.drone_img}" alt="{$drone.drone_name}">
    </div>
    <div class="dc-content">
        <h4>{$drone.drone_name}</h4>
        <div>{$drone.drone_description}</div>
    </div>
</div>
<br>

<div class="drone-card-dialog" style="display: none;" data-drone-id="{$drone.id}">
    <div class="dialog-content drone-dialog">
        <div class="row-1">
            <div class="dc-img">
                <img src="{$drone.drone_img}" alt="{$drone.drone_name}">
            </div>
            <div class="dc-content">
                <h1>{$drone.drone_name}</h1>
                <div>{$drone.drone_description}</div>
            </div>
        </div>
        <div class="row-2">
            <div class="dc-content">
                <h4>Parametry dronu:</h4>
                <div class="mt-4">
                    {if $drone.drone_params|count > 0}
                        <table class="table table-light">
                            {foreach $drone.drone_params as $key => $value}
                                <tr>
                                    <td>
                                        <script>document.write(droneForm.availableParams["{$key}"])</script>
                                    </td>
                                    <td>{$value}</td>
                                </tr>
                            {/foreach}
                        </table>
                    {else}
                        <p>Nejsou k dispozici žádné parametry.</p>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>