<form action="/?action=upload" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="filename" class="form-label">Filename</label>
        <input type="text"
               class="form-control"
               id="filename"
               aria-describedby="filenameHelp"
               name="filename"
               value="<?= $_GET['filename'] ?? ''; ?>">
        <div id="filenameHelp" class="form-text">Enter filename.</div>
    </div>
    <div class="mb-3">
        <label for="file" class="form-label">File</label>
        <input type="file" class="form-control" id="file" name="file">

        <?php if (isset($error)): ?>
            <div class="invalid-feedback" style="display: block">
                <?= $error; ?>
            </div>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>