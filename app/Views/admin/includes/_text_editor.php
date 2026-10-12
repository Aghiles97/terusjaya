<label><?= esc($editorLabel); ?></label>
<?php if (!empty($editorFileManager)): ?>
    <div class="row">
        <div class="col-sm-12 m-b-10">
            <?php if (!empty($editorFileManager)): ?>
                <button type="button" class="btn btn-default btn-file-manager" data-image-type="editor" data-toggle="modal" data-target="#imageFileManagerModal"><i class="fa fa-image"></i>&nbsp;&nbsp;<?= trans("add_image"); ?></button>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<textarea class="form-control <?= !empty($editorClass) ? esc($editorClass) : ''; ?>" name="<?= $editorInputName; ?>"><?= !empty($editorContent) ? $editorContent : ''; ?></textarea>