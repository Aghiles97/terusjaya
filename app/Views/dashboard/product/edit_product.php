<?php if ($product->is_draft == 1): ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="wizard-product">
                <h1 class="product-form-title"><?= esc($title); ?></h1>
                <div class="row">
                    <div class="col-md-12 wizard-add-product">
                        <ul class="wizard-progress">
                            <li class="active" id="step_general"><strong><?= trans("general_information"); ?></strong></li>
                            <li id="step_dedails"><strong><?= trans("details"); ?></strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-add-product">
                <div class="box-body">
                    <?php if ($product->is_draft != 1): ?>
                        <h1 class="product-form-title"><?= esc($title); ?></h1>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-12 clearfix m-b-30">
                            <label class="control-label"><?= trans("images"); ?></label>
                            <?= view('dashboard/product/_image_update'); ?>
                        </div>
                    </div>
                    <form action="<?= base_url('edit-product-post'); ?>" method="post" id="form_validate" class="validate_price">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" value="<?= $product->id; ?>">
                        <input type="hidden" name="back_url" value="<?= getCurrentUrl(); ?>">
                        <div class="form-group">
                            <label class="control-label"><?= trans('product_type'); ?></label>
                            <div class="row">
                                <?php if ($generalSettings->physical_products_system == 1): ?>
                                    <div class="col-12 col-sm-6 col-custom-field">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="product_type" value="physical" id="product_type_1" class="custom-control-input" <?= $product->product_type == 'physical' ? 'checked' : ''; ?> required>
                                            <label for="product_type_1" class="custom-control-label"><?= trans('physical'); ?></label>
                                            <p class="form-element-exp"><?= trans('physical_exp'); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($generalSettings->digital_products_system == 1): ?>
                                    <div class="col-12 col-sm-6 col-custom-field">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="product_type" value="digital" id="product_type_2" class="custom-control-input" <?= $product->product_type == 'digital' ? 'checked' : ''; ?> required>
                                            <label for="product_type_2" class="custom-control-label"><?= trans('digital'); ?></label>
                                            <p class="form-element-exp"><?= trans('digital_exp'); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?= trans('listing_type'); ?></label>
                            <div class="row">
                                <?php if ($generalSettings->marketplace_system == 1): ?>
                                    <div class="col-12 col-sm-6 col-custom-field listing_sell_on_site">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="listing_type" value="sell_on_site" id="listing_type_1" class="custom-control-input" <?= $product->listing_type == 'sell_on_site' ? 'checked' : ''; ?> required>
                                            <label for="listing_type_1" class="custom-control-label"><?= trans('add_product_for_sale'); ?></label>
                                            <p class="form-element-exp"><?= trans('add_product_for_sale_exp'); ?></p>
                                        </div>
                                    </div>
                                <?php endif;
                                if ($generalSettings->classified_ads_system == 1 && $generalSettings->physical_products_system == 1): ?>
                                    <div class="col-12 col-sm-6 col-custom-field listing_ordinary_listing" <?= $product->product_type == 'digital' ? 'style="display:none;"' : ''; ?>>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="listing_type" value="ordinary_listing" id="listing_type_2" class="custom-control-input" <?= $product->listing_type == 'ordinary_listing' ? 'checked' : ''; ?> required>
                                            <label for="listing_type_2" class="custom-control-label"><?= trans('add_product_services_listing'); ?></label>
                                            <p class="form-element-exp"><?= trans('add_product_services_listing_exp'); ?></p>
                                        </div>
                                    </div>
                                <?php endif;
                                if ($generalSettings->bidding_system == 1 && $generalSettings->physical_products_system == 1): ?>
                                    <div class="col-12 col-sm-6 col-custom-field listing_bidding" <?= $product->product_type == 'digital' ? 'style="display:none;"' : ''; ?>>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="listing_type" value="bidding" id="listing_type_3" class="custom-control-input" <?= $product->listing_type == 'bidding' ? 'checked' : ''; ?> required>
                                            <label for="listing_type_3" class="custom-control-label"><?= trans('add_product_get_price_requests'); ?></label>
                                            <p class="form-element-exp"><?= trans('add_product_get_price_requests_exp'); ?></p>
                                        </div>
                                    </div>
                                <?php endif;
                                if ($generalSettings->digital_products_system == 1 && $generalSettings->selling_license_keys_system == 1): ?>
                                    <div class="col-12 col-sm-6 col-custom-field listing_license_keys" <?= $product->product_type == 'physical' ? 'style="display:none;"' : ''; ?>>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="listing_type" value="license_key" id="listing_type_4" class="custom-control-input" <?= $product->listing_type == 'license_key' ? 'checked' : ''; ?> required>
                                            <label for="listing_type_4" class="custom-control-label"><?= trans('add_product_sell_license_keys'); ?></label>
                                            <p class="form-element-exp"><?= trans('add_product_sell_license_keys_exp'); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?= trans("category"); ?></label>
                            <?= view("admin/category/_category_selector", [
                                    'selectorName'         => 'category_id',
                                    'selectorLangId'       => $activeLang->id,
                                    'selectorInitialValue' => !empty($product) ? $product->category_id : 0,
                                    'selectorInitialData'  => !empty($categorySelectorData) ? $categorySelectorData : null,
                                    'showId'               => false
                            ]); ?>
                        </div>

                        <?php if (isAdmin() || hasPermission('products')): ?>
                            <div class="form-group">
                                <label class="control-label"><?= trans('slug'); ?></label>
                                <input type="text" name="slug" class="form-control form-input" value="<?= esc($product->slug); ?>" placeholder="<?= trans("slug"); ?>" maxlength="200">
                            </div>
                        <?php endif; ?>

                        <?php if ($product->is_draft != 1 && $product->status == 1): ?>
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label"><?= trans('status'); ?></label>
                                        <select name="is_sold" class="form-control custom-select" required>
                                            <option value="0" <?= $product->is_sold != 1 ? 'selected' : ''; ?>><?= trans('active'); ?></option>
                                            <option value="1" <?= $product->is_sold == 1 ? 'selected' : ''; ?>><?= trans('sold'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label"><?= trans('visibility'); ?></label>
                                        <select name="visibility" class="form-control custom-select" required>
                                            <option value="1" <?= $product->visibility == 1 ? 'selected' : ''; ?>><?= trans('visible'); ?></option>
                                            <option value="0" <?= $product->visibility == 0 ? 'selected' : ''; ?>><?= trans('hidden'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (isAdmin() || hasPermission('products')): ?>
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="commission_mode"><?= trans("commission"); ?></label>
                                        <select name="commission_mode" id="commission_mode" class="form-control select2">
                                            <option value="default" <?= $product->is_commission_set == 0 ? 'selected' : ''; ?>><?= trans("default"); ?></option>
                                            <option value="custom" <?= $product->is_commission_set == 1 && $product->commission_rate > 0 ? 'selected' : ''; ?>><?= trans("custom"); ?></option>
                                            <option value="none" <?= $product->is_commission_set == 1 && $product->commission_rate == 0 ? 'selected' : ''; ?>><?= trans("none"); ?> (0%)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-group" id="custom_commission_input" style="<?= $product->is_commission_set == 1 && $product->commission_rate > 0 ? '' : 'display: none;'; ?>">
                                        <label><?= trans('commission_rate'); ?>&nbsp;(%)</label>
                                        <input type="number" name="commission_rate" id="commission_rate" class="form-control" min="0" max="99.99" step="0.01" value="<?= $product->commission_rate > 0 ? esc(formatDecimalClean($product->commission_rate)) : ''; ?>" placeholder="E.g. 5">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="panel-group panel-group-product">
                            <?php $languages = array();
                            array_push($languages, $activeLang);
                            if (!empty($activeLanguages)):
                                foreach ($activeLanguages as $language):
                                    if (!empty($language->id != selectedLangId())) {
                                        array_push($languages, $language);
                                    }
                                endforeach;
                            endif;
                            if (!empty($languages)):
                                foreach ($languages as $language):
                                    $editorId = $language->id == selectedLangId() ? 'editor_main' : 'editor_' . $language->id;
                                    $productDetails = getProductDetails($product->id, $language->id, false); ?>
                                    <div class="panel panel-default container-ai-generate-<?= $language->id; ?>">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse_<?= $language->id; ?>"><?= trans("details"); ?><?= countItems($activeLanguages) > 1 ? ':&nbsp;' . esc($language->name) : ''; ?>&nbsp;<?= selectedLangId() != $language->id ? '(' . trans("optional") . ')' : ''; ?><i class="fa fa-caret-down pull-right"></i></a>
                                            </h4>
                                        </div>
                                        <div id="collapse_<?= $language->id; ?>" class="panel-collapse collapse <?= selectedLangId() == $language->id ? 'in' : ''; ?>">
                                            <div class="panel-body">

                                                <?php if ((int)$aiWriterConfig->status === 1 && hasPermission('ai_writer')): ?>
                                                    <div class="display-flex justify-content-end">
                                                        <button type="button" class="btn btn-primary display-flex align-items-center gap-5"
                                                                data-content-type="product"
                                                                data-target-container=".container-ai-generate-<?= $language->id; ?>"
                                                                data-lang="<?= esc($language->name ?? 'English'); ?>"
                                                                data-toggle="modal"
                                                                data-target="#modalAiWriter">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="16" height="16" fill="currentColor">
                                                                <path d="M295.4 37L310.2 73.8L347 88.6C350 89.8 352 92.8 352 96C352 99.2 350 102.2 347 103.4L310.2 118.2L295.4 155C294.2 158 291.2 160 288 160C284.8 160 281.8 158 280.6 155L265.8 118.2L229 103.4C226 102.2 224 99.2 224 96C224 92.8 226 89.8 229 88.6L265.8 73.8L280.6 37C281.8 34 284.8 32 288 32C291.2 32 294.2 34 295.4 37zM142.7 105.7L164.2 155.8L214.3 177.3C220.2 179.8 224 185.6 224 192C224 198.4 220.2 204.2 214.3 206.7L164.2 228.2L142.7 278.3C140.2 284.2 134.4 288 128 288C121.6 288 115.8 284.2 113.3 278.3L91.8 228.2L41.7 206.7C35.8 204.2 32 198.4 32 192C32 185.6 35.8 179.8 41.7 177.3L91.8 155.8L113.3 105.7C115.8 99.8 121.6 96 128 96C134.4 96 140.2 99.8 142.7 105.7zM496 368C502.4 368 508.2 371.8 510.7 377.7L532.2 427.8L582.3 449.3C588.2 451.8 592 457.6 592 464C592 470.4 588.2 476.2 582.3 478.7L532.2 500.2L510.7 550.3C508.2 556.2 502.4 560 496 560C489.6 560 483.8 556.2 481.3 550.3L459.8 500.2L409.7 478.7C403.8 476.2 400 470.4 400 464C400 457.6 403.8 451.8 409.7 449.3L459.8 427.8L481.3 377.7C483.8 371.8 489.6 368 496 368zM492 64C503 64 513.6 68.4 521.5 76.2L563.8 118.5C571.6 126.4 576 137 576 148C576 159 571.6 169.6 563.8 177.5L475.6 265.7L374.3 164.4L462.5 76.2C470.4 68.4 481 64 492 64zM76.2 462.5L340.4 198.3L441.7 299.6L177.5 563.8C169.6 571.6 159 576 148 576C137 576 126.4 571.6 118.5 563.8L76.2 521.5C68.4 513.6 64 503 64 492C64 481 68.4 470.4 76.2 462.5z"></path>
                                                            </svg>
                                                            <?= trans("generate_with_ai"); ?>
                                                        </button>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="form-group m-b-15">
                                                    <label class="control-label"><?= trans("title"); ?></label>
                                                    <input type="text" name="title_<?= $language->id; ?>" value="<?= !empty($productDetails) ? esc($productDetails->title) : ''; ?>" class="form-control form-input ai-input-title" placeholder="<?= trans("title"); ?>" <?= selectedLangId() == $language->id ? 'required' : ''; ?> maxlength="499">
                                                </div>
                                                <div class="form-group m-b-15">
                                                    <label class="control-label"><?= trans("short_description"); ?></label>
                                                    <input type="text" name="short_description_<?= $language->id; ?>" value="<?= !empty($productDetails) ? esc($productDetails->short_description) : ''; ?>" class="form-control form-input ai-input-summary" placeholder="<?= trans("short_description"); ?>" maxlength="499">
                                                </div>
                                                <div class="form-group m-b-15">
                                                    <?= view("dashboard/product/_tags_input", ['tags' => getProductTagsString($product->id, $language->id), 'language' => $language]); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label"><?= trans("description"); ?></label>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <button type="button" id="btn_add_image_editor" class="btn btn-md btn-info m-b-10" data-editor-id="<?= $editorId; ?>" data-toggle="modal" data-target="#fileManagerModal"><i class="fa fa-image"></i>&nbsp;&nbsp;<?= trans("add_image"); ?></button>
                                                        </div>
                                                    </div>
                                                    <textarea name="description_<?= $language->id; ?>" id="<?= $editorId; ?>" class="tinyMCE text-editor ai-input-content"><?= !empty($productDetails) ? $productDetails->description : ''; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;
                            endif; ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 m-t-30 buttons-product-form">
                                <?php if ($product->is_draft == 1): ?>
                                    <button type="submit" class="btn btn-lg btn-success pull-right"><i class="fa fa-check"></i>&nbsp;&nbsp;<?= trans("save_and_continue"); ?></button>
                                <?php else: ?>
                                    <a href="<?= generateDashUrl('product', 'product_details') . '/' . $product->id; ?>" class="btn btn-lg btn-primary pull-right"><?= trans("edit_details"); ?>&nbsp;&nbsp;<i class="fa fa-long-arrow-right"></i> </a>
                                    <button type="submit" class="btn btn-lg btn-success pull-right m-r-10"><i class="fa fa-check"></i>&nbsp;&nbsp;<?= trans("save_changes"); ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?= view('dashboard/product/_product_part'); ?>