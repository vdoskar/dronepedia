<div class="content halfBody">
    <h1>Upravit příspěvek</h1>
    <div class="group">
        <form action="/api/posts/delete" class="mt-2" method="POST">
            <input type="text" name="slug" value="{$post.slug}" hidden>
            <button type="submit" class="btn btn-danger">
                <i class="fa-solid fa-trash-can"></i>
                &nbsp; Smazat příspěvek
            </button>
        </form>
    </div>
    <div class="group">
        <form method="post" action="/api/posts/edit" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Název</label>
                <input type="text" class="form-control" id="title" name="title" required value="{$post.title}" disabled>
            </div>
            <br>
            <div class="form-group">
                <label for="short_summary">Krátké shrnutí</label>
                <input type="text" class="form-control" id="short_summary" name="short_summary" maxlength="150" required value="{$post.short_summary}">
            </div>
            <br>
            <div class="form-group">
                <label for="content">Obsah</label>
                <textarea class="form-control" id="content" name="content" required></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="attachmentsWrapper">Přidat přílohy</label>
                <br>
                <div id="attachmentsWrapper">
                    {if $attachments|count > 0}
                        {foreach $attachments as $attachment}
                            <div class="form-group attachment-item">
                                <input type="text"
                                       class="form-control mt-2"
                                       style="
                                        max-width: calc(100% - 60px);
                                        display: inline-block;"
                                       name="attachments[]"
                                       value="{$attachment.url}"
                                       required>
                                <button class="btn btn-danger" style="margin-left: 0.5rem;" onclick="this.parentElement.remove();">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        {/foreach}
                    {/if}
                </div>
                <br>
                <button class="btn btn-secondary" onclick="attachment.add(); event.preventDefault();">
                    <i class="fa-regular fa-square-plus"></i>
                    &nbsp;Nová příloha
                </button>
            </div>
            <br>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary" id="submit" name="submit">Upravit příspěvek</button>
            </div>
            <input type="text" name="slug" value="{$post.slug}" hidden>
            <input type="text" name="author" value="{$post.author}" hidden>
        </form>
    </div>
</div>

<script>
    editor.init('content');
    editor.setData('content', `{$post.content}`);
</script>
<script>

    // add attachment
    const attachment = {
        add() {
            const wrapper = document.createElement("div");
            wrapper.classList.add('form-group');
            wrapper.classList.add('attachment-item');

            const attachment = document.createElement('input');
            attachment.type = 'text';
            attachment.name = 'attachments[]';
            attachment.classList.add('form-control');
            attachment.classList.add('mt-2');
            attachment.style.maxWidth = 'calc(100% - 60px)';
            attachment.style.display = 'inline-block';
            attachment.placeholder = 'URL přílohy';

            attachment.oninput = () => {
                if (!this.isAvailableUrlByRegex(attachment.value)) {
                    attachment.setCustomValidity('Neplatná URL adresa');
                } else {
                    attachment.setCustomValidity('');
                }
            }

            const removeButton = document.createElement('button');
            removeButton.classList.add('btn');
            removeButton.classList.add('btn-danger');
            removeButton.style.marginLeft = '0.5rem';
            removeButton.innerHTML = "<i class='fa-solid fa-trash-can'></i>";
            removeButton.onclick = () => wrapper.remove();

            wrapper.appendChild(attachment);
            wrapper.appendChild(removeButton);

            document.getElementById('attachmentsWrapper').appendChild(wrapper);
        },

        isAvailableUrlByRegex(url) {
            const regex = new RegExp('^(http|https)://', 'i');
            return regex.test(url);
        }
    }
</script>