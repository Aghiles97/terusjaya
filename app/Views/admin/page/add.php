<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('add_page'); ?></h3>
                </div>
                <div class="right">
                    <div class="display-flex align-items-center gap-10">
                        <button type="button" class="btn btn-primary display-flex align-items-center gap-5"
                                data-content-type="article"
                                data-target-container=".form-ai-generate"
                                data-lang="<?= esc($activeLang->name ?? 'English'); ?>"
                                data-toggle="modal"
                                data-target="#modalAiWriter">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="16" height="16" fill="currentColor">
                                <path d="M295.4 37L310.2 73.8L347 88.6C350 89.8 352 92.8 352 96C352 99.2 350 102.2 347 103.4L310.2 118.2L295.4 155C294.2 158 291.2 160 288 160C284.8 160 281.8 158 280.6 155L265.8 118.2L229 103.4C226 102.2 224 99.2 224 96C224 92.8 226 89.8 229 88.6L265.8 73.8L280.6 37C281.8 34 284.8 32 288 32C291.2 32 294.2 34 295.4 37zM142.7 105.7L164.2 155.8L214.3 177.3C220.2 179.8 224 185.6 224 192C224 198.4 220.2 204.2 214.3 206.7L164.2 228.2L142.7 278.3C140.2 284.2 134.4 288 128 288C121.6 288 115.8 284.2 113.3 278.3L91.8 228.2L41.7 206.7C35.8 204.2 32 198.4 32 192C32 185.6 35.8 179.8 41.7 177.3L91.8 155.8L113.3 105.7C115.8 99.8 121.6 96 128 96C134.4 96 140.2 99.8 142.7 105.7zM496 368C502.4 368 508.2 371.8 510.7 377.7L532.2 427.8L582.3 449.3C588.2 451.8 592 457.6 592 464C592 470.4 588.2 476.2 582.3 478.7L532.2 500.2L510.7 550.3C508.2 556.2 502.4 560 496 560C489.6 560 483.8 556.2 481.3 550.3L459.8 500.2L409.7 478.7C403.8 476.2 400 470.4 400 464C400 457.6 403.8 451.8 409.7 449.3L459.8 427.8L481.3 377.7C483.8 371.8 489.6 368 496 368zM492 64C503 64 513.6 68.4 521.5 76.2L563.8 118.5C571.6 126.4 576 137 576 148C576 159 571.6 169.6 563.8 177.5L475.6 265.7L374.3 164.4L462.5 76.2C470.4 68.4 481 64 492 64zM76.2 462.5L340.4 198.3L441.7 299.6L177.5 563.8C169.6 571.6 159 576 148 576C137 576 126.4 571.6 118.5 563.8L76.2 521.5C68.4 513.6 64 503 64 492C64 481 68.4 470.4 76.2 462.5z"></path>
                            </svg>
                            <?= trans("generate_with_ai"); ?>
                        </button>

                        <a href="<?= adminUrl("pages"); ?>" class="btn btn-success btn-add-new">
                            <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans('pages'); ?>
                        </a>
                    </div>
                </div>
            </div>
            <form action="<?= base_url('Admin/addPagePost'); ?>" method="post" class="form-ai-generate">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('title'); ?></label>
                        <input type="text" class="form-control ai-input-title" name="title" placeholder="<?= trans('title'); ?>" value="<?= old('title'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans("slug"); ?>
                            <small>(<?= trans("slug_exp"); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?= trans("slug"); ?>" value="<?= old('slug'); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans("description"); ?> (<?= trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control ai-input-summary" name="description" placeholder="<?= trans("description"); ?> (<?= trans('meta_tag'); ?>)" value="<?= old('description'); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control ai-input-keywords" name="keywords" placeholder="<?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)" value="<?= old('keywords'); ?>">
                    </div>
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control" style="max-width: 600px;">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= selectedLangId() == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= trans('order'); ?></label>
                        <input type="number" class="form-control" name="page_order" placeholder="<?= trans('order'); ?>" value="1" min="1" style="max-width: 600px;">
                    </div>

                    <div class="form-group">
                        <label><?= trans("location"); ?></label>
                        <div class="row">
                            <div class="col-md-2 col-sm-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="location" value="top_menu" id="location_1" class="custom-control-input" checked>
                                    <label for="location_1" class="custom-control-label"><?= trans("top_menu"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="location" value="quick_links" id="location_2" class="custom-control-input">
                                    <label for="location_2" class="custom-control-label"><?= trans("footer_quick_links"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="location" value="information" id="location_3" class="custom-control-input">
                                    <label for="location_3" class="custom-control-label"><?= trans("footer_information"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="location" value="footer_bottom" id="location_4" class="custom-control-input">
                                    <label for="location_4" class="custom-control-label"><?= trans("footer_bottom"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    ai-input-content
                    <div class="form-group">
                        <label><?= trans("visibility"); ?></label>
                        <?= formRadio('visibility', 1, 0, trans("show"), trans("hide"), 1, 'col-md-2'); ?>
                    </div>

                    <div class="form-group">
                        <label><?= trans("show_title"); ?></label>
                        <?= formRadio('title_active', 1, 0, trans("yes"), trans("no"), 1, 'col-md-2'); ?>
                    </div>

                    <div class="form-group" style="margin-top: 30px;">
                        <?= view('admin/includes/_text_editor', [
                                'editorInputName'   => 'page_content',
                                'editorLabel'       => trans("content"),
                                'editorContent'     => null,
                                'editorFileManager' => true,
                                'editorClass'       => 'tinyMCE ai-input-content',
                        ]); ?>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_page'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= view('admin/includes/_image_file_manager'); ?>