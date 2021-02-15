<style>
table,
td {
    border: 1px solid #333;
}

thead,
tfoot {
    background-color: #333;
    color: #fff;
}
</style>
<!-- Le type d'encodage des données, enctype, DOIT être spécifié comme ce qui suit -->
<form enctype="multipart/form-data" action="<?= Config::URL_SUBDIR(false) ?>/document/new" method="post">
  <!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
  <input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
  <input type="hidden" name="action" value="upload_document" />
  <!-- Le nom de l'élément input détermine le nom dans le tableau $_FILES -->
  Envoyez ce fichier : <input name="file" type="file" />
  <input type="submit" value="Envoyer le fichier" />
</form>

<form action="<?= Config::URL_SUBDIR(false) ?>/document/del" method="post">
    Supprimer un document (id) : 
    <input type="hidden" name="action" value="delete_document"/>
    <input type="number" name="id" />
    <input type="submit" />
</form>

<table>
    <thead>
        <tr>
            <th>id</th>
            <th>type</th>
            <th>url</th>
            <th>path</th>
            <th>is visible</th>
            <th>is deleted</th>
        </tr>
    </thead>
    <tbody>

<?php foreach($GLOBALS["docs"]->get_documents(null) as $doc) { ?>
        <tr>
            <td><?= $doc->id(); ?></td>
            <td><?= $doc->type(); ?></td>
            <td><?= $doc->url(); ?></td>
            <td><?= $doc->path(); ?></td>
            <td><?= $doc->is_visible() ? "true" : "false"; ?></td>
            <td><?= $doc->is_deleted() ? "true" : "false"; ?></td>
        </tr>
<?php } ?>
    </tbody>
</table>
