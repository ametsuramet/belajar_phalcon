
{{ content() }}

<div align="right">
    {{ link_to("articles/new", "Create articles") }}
</div>

{{ form("articles/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search articles</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="id">Id</label>
        </td>
        <td align="left">
            {{ text_field("id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="title">Title</label>
        </td>
        <td align="left">
            {{ text_field("title", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="category_id">Category</label>
        </td>
        <td align="left">
            {{ text_field("category_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="description">Description</label>
        </td>
        <td align="left">
                {{ text_area("description", "cols": "30", "rows": "4") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="images">Images</label>
        </td>
        <td align="left">
            {{ text_field("images", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="status">Status</label>
        </td>
        <td align="left">
            {{ text_field("status", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
