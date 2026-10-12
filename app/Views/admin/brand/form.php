<?php
$isEdit = !empty($brand);
$formAction = $isEdit ? base_url('Category/editBrandPost') : base_url('Category/addBrandPost');
$formTitle = $isEdit ? trans('edit_brand') : trans('add_brand');
$submitButtonText = $isEdit ? trans('save_changes') : trans('add_brand');
?>

<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= $formTitle; ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl("brands"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans('brands'); ?>
                    </a>
                </div>
            </div>

            <form action="<?= $formAction; ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <?php if ($isEdit): ?>
                    <input type="hidden" name="id" value="<?= esc($brand->id); ?>">
                <?php endif; ?>

                <div class="box-body">

                    <div class="form-group">
                        <label><?= trans("name"); ?></label>
                        <?php foreach ($activeLanguages as $language):
                            $langName = '';
                            if ($isEdit && !empty($brandNamesArray) && isset($brandNamesArray[$language->id])) {
                                $langName = $brandNamesArray[$language->id];
                            } ?>
                            <input type="text" class="form-control m-b-5" name="name_<?= $language->id; ?>" value="<?= esc($langName); ?>" placeholder="<?= esc($language->name); ?>" maxlength="255" required>
                        <?php endforeach; ?>
                    </div>

                    <?php
                    $strCategoryIds = '';
                    $pickerCategories = [];
                    if (!empty($brandCategoryIdsArray)) {
                        $strCategoryIds = implode(',', $brandCategoryIdsArray);
                        $pickerCategories = getCategoriesByIdArray($brandCategoryIdsArray);
                    }
                    ?>

                    <div class="form-group">
                        <label class="form-label"><?= trans("categories"); ?></label>

                        <div id="brand_selected_categories" class="mb-2">
                            <?php if (!empty($pickerCategories)):
                                foreach ($pickerCategories as $category): ?>
                                    <div id="cat-group-<?= esc($category->id); ?>" class="btn-group m-b-5 m-r-5">
                                        <button type="button" class="btn btn-sm btn-light btn-category-name border"><?= esc($category->cat_name); ?></button>
                                        <button type="button" class="btn btn-sm btn-light btn-category-delete border" data-id="<?= esc($category->id); ?>">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                <?php endforeach;
                            endif; ?>
                        </div>

                        <input type="hidden" name="category_ids" id="input_category_ids" value="<?= esc($strCategoryIds); ?>">

                        <div class="mt-2">
                            <?= view("admin/category/_category_selector", [
                                    'selectorName'            => 'ignore_this',
                                    'selectorLangId'          => $activeLang->id,
                                    'selectorExcludeId'       => 0,
                                    'selectorInitialValue'    => 0,
                                    'selectorInitialData'     => null,
                                    'selectorAllowNone'       => false,
                                    'selectorTargetContainer' => 'brand_selected_categories'
                            ]); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?= trans("show_on_slider"); ?></label>
                        <?php $showOnSlider = $isEdit ? $brand->show_on_slider : 0; ?>
                        <?= formRadio('show_on_slider', 1, 0, trans("yes"), trans("no"), $showOnSlider, 'col-lg-4'); ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('logo'); ?>&nbsp;(<?= trans("optional"); ?>)</label>

                        <?php if ($isEdit && !empty($brand->image_path)): ?>
                            <div class="display-block m-b-10">
                                <img src="<?= getStorageFileUrl($brand->image_path, $brand->storage); ?>" width="128">
                            </div>
                        <?php endif; ?>

                        <div class="display-block">
                            <a class='btn btn-success btn-sm btn-file-upload'>
                                <?= trans('select_logo'); ?>
                                <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif, .webp" onchange="$('#upload-file-info-add').html($(this).val().replace(/.*[\/\\]/, ''));">
                            </a>
                        </div>
                        <span class='label label-info' id="upload-file-info-add"></span>
                    </div>

                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= $submitButtonText; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-category-name {
        pointer-events: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('brand_selected_categories');
        const inputIds = document.getElementById('input_category_ids');

        if (!container || !inputIds) return;

        // Load pre-selected IDs from hidden input
        let selectedIds = inputIds.value ? inputIds.value.split(',') : [];

        // Listen for custom 'category-selected' event coming from the selector
        container.addEventListener('category-selected', function (e) {
            const item = e.detail;
            const stringId = item.id.toString();

            // Add tag if it's a valid ID and not already selected
            if (item && item.id > 0 && !selectedIds.includes(stringId)) {
                selectedIds.push(stringId);

                // Build the tag HTML
                const newCategoryHTML = `
                    <div id="cat-group-${item.id}" class="btn-group m-b-5 m-r-5">
                        <button type="button" class="btn btn-sm btn-light btn-category-name border">${item.name}</button>
                        <button type="button" class="btn btn-sm btn-light btn-category-delete border" data-id="${item.id}">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `;

                // Insert tag into the container
                container.insertAdjacentHTML('beforeend', newCategoryHTML);

                // Update hidden input for backend
                inputIds.value = selectedIds.join(',');
            }
        });

        // Handle tag deletion via event delegation
        container.addEventListener('click', function (e) {
            const deleteBtn = e.target.closest('.btn-category-delete');
            if (deleteBtn) {
                const idToRemove = deleteBtn.getAttribute('data-id');

                // Remove ID from array and update hidden input
                selectedIds = selectedIds.filter(id => id !== idToRemove);
                inputIds.value = selectedIds.join(',');

                // Remove tag from DOM
                const group = document.getElementById('cat-group-' + idToRemove);
                if (group) group.remove();
            }
        });
    });
</script>