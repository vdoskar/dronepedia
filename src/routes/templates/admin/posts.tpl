<table class="table adminTable">
    <thead>
       <tr>
           <th>Title</th>
           <th>Slug</th>
           <th>Short Summary</th>
           <th>Author</th>
           <th>Category</th>
           <th>Date Created</th>
           <th>Date Updated</th>
           <th>Status</th>
           <th>Actions</th>
       </tr>
    </thead>
    <tbody>
        {foreach $posts as $post}
            <tr>
                <td>{$post.title}</td>
                <td>{$post.slug}</td>
                <td>{$post.short_summary}</td>
                <td>{$post.author}</td>
                <td>{$post.category}</td>
                <td>{$post.date_created}</td>
                <td>{$post.date_updated}</td>
                <td>{$post.status}</td>
                <td>
                    <a href="/api/admin/post/delete?p={$post.slug}">Delete</a>
                    {if $post.status == "ACTIVE"}
                        <a href="/api/admin/post/close?p={$post.slug}">Close</a>
                    {elseif $post.status == "CLOSED"}
                        <a href="/api/admin/post/open?p={$post.slug}">Open</a>
                    {/if}
                </td>
            </tr>
        {/foreach}
    </tbody>
</table>
