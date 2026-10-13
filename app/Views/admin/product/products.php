<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= esc($title); ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?= view('admin/product/_filter_products'); ?>
                <div class="row m-b-15 bulk-actions-bar" style="display: none;">
                    <div class="col-sm-12">
                        <div class="bulk-toolbar-box">
                            <div class="bulk-toolbar-left">
                                <span class="bulk-pill"><span class="selected-products-count">0</span></span>
                                <span class="bulk-toolbar-label"><?= trans("products_selected"); ?></span>
                                <a href="javascript:void(0)" onclick="clearSelection();" class="bulk-deselect-link"><i class="fa fa-times-circle"></i> <?= trans("clear"); ?></a>
                            </div>
                            <div class="bulk-toolbar-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm bulk-actions-btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-bolt text-warning"></i>&nbsp;Actions&nbsp;&nbsp;<i class="fa-solid fa-chevron-down bulk-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right bulk-actions-dropdown" role="menu">
                                        <li><a href="javascript:void(0)" onclick="bulkProductAction('approve');"><i class="fa-solid fa-check text-success fa-fw"></i><span><?= trans("approve"); ?></span></a></li>
                                        <li class="divider"></li>
                                        <li><a href="javascript:void(0)" onclick="bulkProductAction('set_visible');"><i class="fa-solid fa-eye text-primary fa-fw"></i><span><?= trans("set_as_visible") != 'set_as_visible' ? trans("set_as_visible") : 'Set as Visible'; ?></span></a></li>
                                        <li><a href="javascript:void(0)" onclick="bulkProductAction('set_hidden');"><i class="fa-solid fa-eye-slash text-muted fa-fw"></i><span><?= trans("set_as_hidden") != 'set_as_hidden' ? trans("set_as_hidden") : 'Set as Hidden'; ?></span></a></li>
                                        <li class="divider"></li>
                                        <li><a href="javascript:void(0)" onclick="bulkProductAction('add_featured');"><i class="fa-solid fa-star text-warning fa-fw"></i><span><?= trans("add_to_featured"); ?></span></a></li>
                                        <li><a href="javascript:void(0)" onclick="bulkProductAction('remove_featured');"><i class="fa-regular fa-star text-muted fa-fw"></i><span><?= trans("remove_from_featured"); ?></span></a></li>
                                        <li class="divider"></li>
                                        <li><a href="javascript:void(0)" onclick="bulkProductAction('add_special_offer');"><i class="fa-solid fa-tag text-danger fa-fw"></i><span><?= trans("add_to_special_offers"); ?></span></a></li>
                                        <li><a href="javascript:void(0)" onclick="bulkProductAction('remove_special_offer');"><i class="fa-solid fa-tag text-muted fa-fw" style="opacity: 0.5;"></i><span><?= trans("remove_from_special_offers"); ?></span></a></li>
                                        <?php if ($listType == 'deleted_products'): ?>
                                            <li class="divider"></li>
                                            <li><a href="javascript:void(0)" onclick="bulkProductAction('restore');"><i class="fa-solid fa-reply text-success fa-fw"></i><span><?= trans("restore"); ?></span></a></li>
                                            <li class="danger-item"><a href="javascript:void(0)" onclick="deleteSelectedProductsPermanently('<?= trans("confirm_products", true); ?>');"><i class="fa-solid fa-trash-can text-danger fa-fw"></i><span><?= trans("delete_permanently"); ?></span></a></li>
                                        <?php else: ?>
                                            <li class="divider"></li>
                                            <li class="danger-item"><a href="javascript:void(0)" onclick="deleteSelectedProducts('<?= trans("confirm_products", true); ?>');"><i class="fa-solid fa-trash text-danger fa-fw"></i><span><?= trans("delete"); ?></span></a></li>
                                            <li class="danger-item"><a href="javascript:void(0)" onclick="deleteSelectedProductsPermanently('<?= trans("confirm_products", true); ?>');"><i class="fa-solid fa-trash-can text-danger fa-fw"></i><span><?= trans("delete_permanently"); ?></span></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <?php if ($listType == 'deleted_products'): ?>
                                    <button type="button" class="btn btn-sm btn-success" onclick="bulkProductAction('restore');"><i class="fa fa-reply"></i>&nbsp;&nbsp;<?= trans("restore"); ?></button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-sm btn-danger btn-table-delete" onclick="deleteSelectedProducts('<?= trans("confirm_products", true); ?>');"><i class="fa fa-trash"></i>&nbsp;&nbsp;<?= trans("delete"); ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('product'); ?></th>
                            <th><?= trans('product_type'); ?></th>
                            <th><?= trans('category'); ?></th>
                            <th><?= trans('user'); ?></th>
                            <th><?= trans('price'); ?></th>
                            <th><?= trans('stock'); ?></th>
                            <?php if ($listType == 'featured_products'): ?>
                                <th><?= trans('purchased_plan'); ?></th>
                                <th><?= trans('remaining_days'); ?></th>
                            <?php endif; ?>
                            <?php if ($listType == 'edited_products' || $listType == 'pending_products'): ?>
                                <th><?= trans('status'); ?></th>
                            <?php endif; ?>
                            <th><?= trans('page_views'); ?></th>
                            <th><?= trans('updated'); ?></th>
                            <th><?= trans('date'); ?></th>
                            <th class="max-width-120"><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($products)):
                            foreach ($products as $item): ?>
                                <tr>
                                    <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $item->id; ?>"></td>
                                    <td><?= esc($item->id); ?></td>
                                    <td>
                                        <div class="media">
                                            <div class="<?= $activeLang->text_direction == 'rtl' ? 'media-right' : 'media-left'; ?>">
                                                <a href="<?= generateProductUrl($item); ?>" target="_blank">
                                                    <img data-src="<?= getProductItemImage($item); ?>" alt="" class="lazyload" style="width: 80px; height: 80px; border-radius: 1px; object-fit: cover">
                                                </a>
                                            </div>
                                            <div class="media-body <?= $activeLang->text_direction == 'rtl' ? 'text-right' : 'text-left'; ?>">
                                                <div class="m-b-5">
                                                    <a href="<?= generateProductUrl($item); ?>" target="_blank" class="table-link">
                                                        <?= esc($item->title); ?>
                                                    </a>
                                                </div>
                                                <?php if (!empty($item->sku)): ?>
                                                    <p class="m-b-5 font-size-13">
                                                        <strong><?= trans('sku'); ?>:</strong>&nbsp;<?= esc($item->sku); ?>
                                                    </p>
                                                <?php endif; ?>
                                                <p class="m-b-5">
                                                    <?php if ($item->is_promoted == 1): ?>
                                                        <label class="label label-success"><?= trans("featured"); ?></label>
                                                    <?php endif;
                                                    if ($item->is_special_offer == 1): ?>
                                                        <label class="label label-info"><?= trans("special_offer"); ?></label>
                                                    <?php endif;
                                                    if ($item->is_commission_set == 1): ?>
                                                        &nbsp;<label class="label bg-warning"><i class="fa fa-hand-holding-dollar"></i>&nbsp;<?= esc(formatDecimalClean($item->commission_rate)) ?>%</label>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= trans($item->product_type); ?></td>
                                    <td><?= esc($item->cat_name); ?></td>
                                    <td>
                                        <a href="<?= generateProfileUrl($item->user_slug); ?>" target="_blank" class="table-username">
                                            <?= esc($item->user_username); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if (!empty($item->price_discounted)): ?>
                                            <span><?= priceFormatted($item->price_discounted, $item->currency, true); ?></span>
                                        <?php else: ?>
                                            <span>-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="white-space-nowrap">
                                        <?php if ($item->product_type == "digital"): ?>
                                            <span class="text-success"><?= trans("in_stock"); ?></span>
                                        <?php else:
                                            if ($item->stock < 1): ?>
                                                <span class="text-danger"><?= $item->listing_type == 'ordinary_listing' ? trans("sold") : trans("out_of_stock"); ?></span>
                                            <?php else: ?>
                                                <span class="text-success"><?= trans("in_stock"); ?>&nbsp;<?= $item->listing_type != 'ordinary_listing' ? '(' . $item->stock . ')' : ''; ?></span>
                                            <?php endif;
                                        endif; ?>
                                    </td>

                                    <?php if ($listType == 'featured_products'): ?>
                                        <td>
                                            <div class="label label-default" style="font-size: 12px; font-weight: 600;">
                                                <span>
                                                    <?php if ($item->is_promoted == 1):
                                                        echo esc($item->promote_plan);
                                                    endif; ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td style="min-width: 120px;">
                                            <?php if ($item->is_promoted == 1): ?>
                                                <strong><?= dateDifference($item->promote_end_date, date('Y-m-d H:i:s')); ?></strong>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>

                                    <?php if ($listType == 'edited_products' || $listType == 'pending_products'): ?>
                                        <td>
                                            <?php if ($item->is_rejected == 1): ?>
                                                <p>
                                                    <label class="label label-danger"><?= trans("rejected"); ?></label>
                                                </p>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalReason<?= $item->id; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;<?= trans("show_reason"); ?></button>
                                                <div id="modalReason<?= $item->id; ?>" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title"><?= trans("reason"); ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="m-t-10"><?= esc($item->reject_reason); ?></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans("close"); ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else:
                                                if ($item->status == 1):?>
                                                    <label class="label label-success"><?= trans("active"); ?></label>
                                                <?php else: ?>
                                                    <label class="label label-default"><?= trans("pending"); ?></label>
                                                <?php endif;
                                            endif; ?>
                                        </td>
                                    <?php endif; ?>

                                    <td><?= numberFormatShort($item->pageviews); ?></td>
                                    <td><?= !empty($item->updated_at) ? timeAgo($item->updated_at) : ''; ?></td>
                                    <td><?= formatDate($item->created_at); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans("select_option"); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <a href="<?= adminUrl('product-details/' . $item->id); ?>"><i class="fa fa-info option-icon"></i><?= trans("view_details"); ?></a>
                                                </li>

                                                <?php if ($item->is_deleted != 1 && $item->is_draft != 1 && $item->is_sold != 1): ?>

                                                    <?php if ($item->is_promoted == 1): ?>
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="removeFromFeatured('<?= esc($item->id); ?>');"><i class="fa fa-minus option-icon"></i><?= trans("remove_from_featured"); ?></a>
                                                        </li>
                                                    <?php else: ?>
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="$('#day_count_product_id').val('<?= esc($item->id); ?>');" data-toggle="modal" data-target="#modalAddFeatured"><i class="fa fa-plus option-icon"></i><?= trans('add_to_featured'); ?></a>
                                                        </li>
                                                    <?php endif;
                                                    if ($item->is_special_offer == 1): ?>
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="addRemoveSpecialOffer('<?= esc($item->id); ?>');"><i class="fa fa-minus option-icon"></i><?= trans("remove_from_special_offers"); ?></a>
                                                        </li>
                                                    <?php else: ?>
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="addRemoveSpecialOffer('<?= esc($item->id); ?>');"><i class="fa fa-plus option-icon"></i><?= trans('add_to_special_offers'); ?></a>
                                                        </li>
                                                    <?php endif; ?>

                                                <?php endif; ?>

                                                <?php if ($listType == 'edited_products' || $listType == 'pending_products'): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="approveProduct('<?= $item->id; ?>');"><i class="fa fa-check option-icon"></i><?= trans("approve"); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalReject" onclick="$('#reject_product_id').val(<?= $item->id; ?>);"><i class="fa fa-ban option-icon"></i><?= trans("reject"); ?></a>
                                                    </li>
                                                <?php endif; ?>

                                                <li>
                                                    <a href="<?= generateDashUrl('edit_product') . '/' . $item->id; ?>" target="_blank"><i class="fa fa-edit option-icon"></i><?= trans("edit"); ?></a>
                                                </li>
                                                <?php if ($item->is_deleted != 1): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="deleteItem('Product/deleteProduct','<?= $item->id; ?>','<?= trans("confirm_product", true); ?>');"><i class="fa fa-times option-icon"></i><?= trans('delete'); ?></a>
                                                    </li>
                                                <?php endif;
                                                if ($item->is_deleted == 1): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="restoreProduct('<?= $item->id; ?>');"><i class="fa fa-reply option-icon"></i><?= trans('restore'); ?></a>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="deleteItem('Product/deleteProductPermanently','<?= $item->id; ?>','<?= trans("confirm_product_permanent", true); ?>');"><i class="fa fa-trash-can option-icon"></i><?= trans('delete_permanently'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($products)): ?>
                        <p class="text-center">
                            <?= trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?= $pager->links; ?>
                            </div>
                            <?php if (countItems($products) > 0): ?>
                                <div class="pull-left bulk-actions-bar" style="display: none;">
                                    <div class="btn-group m-r-5">
                                        <button type="button" class="btn btn-sm bulk-actions-btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-bolt text-warning"></i>&nbsp;Actions&nbsp;&nbsp;<i class="fa-solid fa-chevron-down bulk-caret"></i>
                                        </button>
                                        <ul class="dropdown-menu bulk-actions-dropdown" role="menu">
                                            <li><a href="javascript:void(0)" onclick="bulkProductAction('approve');"><i class="fa-solid fa-check text-success fa-fw"></i><span><?= trans("approve"); ?></span></a></li>
                                            <li class="divider"></li>
                                            <li><a href="javascript:void(0)" onclick="bulkProductAction('set_visible');"><i class="fa-solid fa-eye text-primary fa-fw"></i><span><?= trans("set_as_visible") != 'set_as_visible' ? trans("set_as_visible") : 'Set as Visible'; ?></span></a></li>
                                            <li><a href="javascript:void(0)" onclick="bulkProductAction('set_hidden');"><i class="fa-solid fa-eye-slash text-muted fa-fw"></i><span><?= trans("set_as_hidden") != 'set_as_hidden' ? trans("set_as_hidden") : 'Set as Hidden'; ?></span></a></li>
                                            <li class="divider"></li>
                                            <li><a href="javascript:void(0)" onclick="bulkProductAction('add_featured');"><i class="fa-solid fa-star text-warning fa-fw"></i><span><?= trans("add_to_featured"); ?></span></a></li>
                                            <li><a href="javascript:void(0)" onclick="bulkProductAction('remove_featured');"><i class="fa-regular fa-star text-muted fa-fw"></i><span><?= trans("remove_from_featured"); ?></span></a></li>
                                            <li class="divider"></li>
                                            <li><a href="javascript:void(0)" onclick="bulkProductAction('add_special_offer');"><i class="fa-solid fa-tag text-danger fa-fw"></i><span><?= trans("add_to_special_offers"); ?></span></a></li>
                                            <li><a href="javascript:void(0)" onclick="bulkProductAction('remove_special_offer');"><i class="fa-solid fa-tag text-muted fa-fw" style="opacity: 0.5;"></i><span><?= trans("remove_from_special_offers"); ?></span></a></li>
                                            <?php if ($listType == 'deleted_products'): ?>
                                                <li class="divider"></li>
                                                <li><a href="javascript:void(0)" onclick="bulkProductAction('restore');"><i class="fa-solid fa-reply text-success fa-fw"></i><span><?= trans("restore"); ?></span></a></li>
                                                <li class="danger-item"><a href="javascript:void(0)" onclick="deleteSelectedProductsPermanently('<?= trans("confirm_products", true); ?>');"><i class="fa-solid fa-trash-can text-danger fa-fw"></i><span><?= trans("delete_permanently"); ?></span></a></li>
                                            <?php else: ?>
                                                <li class="divider"></li>
                                                <li class="danger-item"><a href="javascript:void(0)" onclick="deleteSelectedProducts('<?= trans("confirm_products", true); ?>');"><i class="fa-solid fa-trash text-danger fa-fw"></i><span><?= trans("delete"); ?></span></a></li>
                                                <li class="danger-item"><a href="javascript:void(0)" onclick="deleteSelectedProductsPermanently('<?= trans("confirm_products", true); ?>');"><i class="fa-solid fa-trash-can text-danger fa-fw"></i><span><?= trans("delete_permanently"); ?></span></a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    <?php if ($listType == 'deleted_products'): ?>
                                        <button class="btn btn-sm btn-success m-r-5" onclick="bulkProductAction('restore');"><i class="fa fa-reply"></i>&nbsp;&nbsp;<?= trans("restore"); ?></button>
                                        <button class="btn btn-sm btn-danger btn-table-delete" onclick="deleteSelectedProductsPermanently('<?= trans("confirm_products", true); ?>');"><?= trans('delete_permanently'); ?></button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-danger btn-table-delete" onclick="deleteSelectedProducts('<?= trans("confirm_products", true); ?>');"><?= trans('delete'); ?></button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteSelectedProductsPermanently('<?= trans("confirm_products", true); ?>');"><?= trans('delete_permanently'); ?></button>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalAddFeatured" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('Product/addRemoveFeaturedProduct'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= trans('add_to_featured'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><?= trans('number_of_days'); ?></label>
                        <input type="hidden" class="form-control" name="product_id" id="day_count_product_id" value="">
                        <input type="hidden" class="form-control" name="is_ajax" value="0">
                        <input type="number" class="form-control" name="day_count" placeholder="<?= trans('number_of_days'); ?>" value="1" min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?= trans("submit"); ?></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?= trans("close"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalReject" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('Product/rejectProduct'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="reject_product_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= trans("reject"); ?></h4>
                </div>
                <div class="modal-body">
                    <textarea name="reject_reason" class="form-control form-textarea" placeholder="<?= trans("reason"); ?>.." style="min-height: 150px;"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?= trans("submit"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<style>
/* Bulk Toolbar */
.bulk-toolbar-box {
    background: #ffffff;
    border: 1px solid #dbeafe;
    border-left: 4px solid #3b82f6;
    border-radius: 6px;
    padding: 10px 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.bulk-toolbar-left {
    display: flex;
    align-items: center;
    gap: 8px;
}
.bulk-toolbar-right {
    display: flex;
    align-items: center;
    gap: 6px;
}
.bulk-toolbar-label {
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
}
.bulk-pill {
    background-color: #3b82f6;
    color: #ffffff;
    font-size: 12px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 12px;
    display: inline-block;
}
.bulk-deselect-link {
    font-size: 12px;
    color: #64748b;
    margin-left: 6px;
    text-decoration: underline;
    cursor: pointer;
}
.bulk-deselect-link:hover {
    color: #ef4444;
}
.bulk-footer-actions {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 5px;
}

/* Bulk Actions Button */
.bulk-actions-btn {
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    color: #1e293b !important;
    font-weight: 600 !important;
    font-size: 13px !important;
    padding: 6px 12px !important;
    border-radius: 6px !important;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    transition: all 0.15s ease-in-out !important;
}
.bulk-actions-btn:hover,
.bulk-actions-btn:focus,
.open > .bulk-actions-btn {
    background: #f8fafc !important;
    border-color: #94a3b8 !important;
    color: #0f172a !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08) !important;
}
.bulk-actions-btn .fa-bolt {
    color: #f59e0b !important;
}
.bulk-actions-btn .bulk-caret {
    font-size: 10px;
    margin-left: 2px;
    color: #64748b;
    transition: transform 0.2s ease;
}
.open > .bulk-actions-btn .bulk-caret {
    transform: rotate(180deg);
}

/* Polished Dropdown Menu */
.bulk-actions-dropdown {
    min-width: 220px !important;
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 8px !important;
    padding: 6px !important;
    margin-top: 6px !important;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.08) !important;
}
.bulk-actions-dropdown > li > a {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    padding: 8px 12px !important;
    border-radius: 6px !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    color: #334155 !important;
    line-height: 1.3 !important;
    transition: background 0.12s ease, color 0.12s ease !important;
}
.bulk-actions-dropdown > li > a:hover,
.bulk-actions-dropdown > li > a:focus {
    background-color: #f1f5f9 !important;
    color: #0f172a !important;
}
.bulk-actions-dropdown > li > a i.fa-fw {
    width: 18px !important;
    text-align: center !important;
    font-size: 13px !important;
    flex-shrink: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}
.bulk-actions-dropdown > li.divider {
    margin: 4px 6px !important;
    height: 1px !important;
    background-color: #f1f5f9 !important;
    border: 0 !important;
}
.bulk-actions-dropdown > li.danger-item > a:hover,
.bulk-actions-dropdown > li.danger-item > a:focus {
    background-color: #fef2f2 !important;
    color: #dc2626 !important;
}
</style>

<script>
function getSelectedProductIds() {
    var productIds = [];
    $("input[name='checkbox-table']:checked").each(function () {
        productIds.push(this.value);
    });
    return productIds;
}

function updateSelectedCounter() {
    var count = $("input[name='checkbox-table']:checked").length;
    $(".selected-products-count").text(count);
    if (count > 0) {
        $(".bulk-actions-bar").fadeIn(150);
        $(".btn-table-delete").show();
    } else {
        $(".bulk-actions-bar").fadeOut(150);
        $(".btn-table-delete").hide();
    }
}

function clearSelection() {
    $('#checkAll').prop('checked', false);
    $("input[name='checkbox-table']").prop('checked', false);
    updateSelectedCounter();
}

$(document).on('change', '#checkAll, input[name="checkbox-table"]', function () {
    setTimeout(updateSelectedCounter, 50);
});

function bulkProductAction(action, message) {
    var productIds = getSelectedProductIds();
    if (productIds.length === 0) {
        Swal.fire({text: "Please select at least one product.", icon: "warning"});
        return;
    }
    var promptMsg = message || 'Are you sure you want to apply this action to the ' + productIds.length + ' selected product(s)?';
    Swal.fire(swalOptions(promptMsg)).then(function (result) {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: generateUrl('Product/bulkActionProductsPost'),
                data: {
                    'product_ids': productIds,
                    'action': action
                },
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
}
</script>