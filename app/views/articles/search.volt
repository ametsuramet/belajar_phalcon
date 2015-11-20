
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("articles/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("articles/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Category</th>
            <th>Description</th>
            <th>Images</th>
            <th>Status</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for article in page.items %}
        <tr>
            <td>{{ article.getId() }}</td>
            <td>{{ article.getTitle() }}</td>
            <td>{{ article.getCategoryId() }}</td>
            <td>{{ article.getDescription() }}</td>
            <td>{{ article.getImages() }}</td>
            <td>{{ article.getStatus() }}</td>
            <td>{{ link_to("articles/edit/"~article.getId(), "Edit") }}</td>
            <td>{{ link_to("articles/delete/"~article.getId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("articles/search", "First") }}</td>
                        <td>{{ link_to("articles/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("articles/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("articles/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
