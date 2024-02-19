<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Filename</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($files->list() as $index => $filename): ?>
        <tr>
            <th scope="row"><?= $index + 1 ?></th>
            <td><?= $filename ?></td>
            <td>
                <div class="btn-group" role="group" aria-label="Actions">
                    <form method="get" action="/">
                        <input type="hidden" name="action" value="preview">
                        <input type="hidden" name="filename" value="<?= $filename; ?>">

                        <button type="submit" class="btn btn-outline-primary">
                            View
                        </button>
                    </form>

                    <form method="get" action="/">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="filename" value="<?= $filename; ?>">

                        <button type="submit" class="btn btn-outline-primary">
                            Edit
                        </button>
                    </form>

                    <form method="post" action="/?action=delete">
                        <input type="hidden" name="filename" value="<?= $filename; ?>">

                        <button type="submit" class="btn btn-outline-danger">
                            Delete
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>