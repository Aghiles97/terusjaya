<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= esc($title); ?></h3>
        </div>
        <div class="right">
            <button type="button" class="btn btn-success btn-add-new" data-toggle="modal" data-target="#modalAddEmail"><i class="fa fa-plus"></i><?= trans("add_email"); ?></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">

                <div class="row table-filter-container">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-default filter-toggle collapsed m-b-10" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false">
                            <i class="fa fa-filter"></i>&nbsp;&nbsp;<?= trans("filter"); ?>
                        </button>
                        <div class="collapse navbar-collapse" id="collapseFilter">
                            <form action="<?= adminUrl('email-blacklist'); ?>" method="get" id="formFilterEmails">
                                <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                    <label><?= trans("show"); ?></label>
                                    <select name="show" class="form-control">
                                        <option value="15" <?= inputGet('show') == '15' ? 'selected' : ''; ?>>15</option>
                                        <option value="30" <?= inputGet('show') == '30' ? 'selected' : ''; ?>>30</option>
                                        <option value="60" <?= inputGet('show') == '60' ? 'selected' : ''; ?>>60</option>
                                        <option value="100" <?= inputGet('show') == '100' ? 'selected' : ''; ?>>100</option>
                                    </select>
                                </div>
                                <div class="item-table-filter" style="width: 320px;">
                                    <label><?= trans("search"); ?></label>
                                    <div class="item-table-filter-search">
                                        <input name="q" class="form-control" placeholder="<?= trans("search"); ?>" type="search" value="<?= esc(inputGet('q')); ?>">
                                        <button type="submit" class="btn bg-purple"><?= trans("filter"); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped cs_datatable_lang" role="grid">
                        <thead>
                        <tr role="row">
                            <th width="50"><?= trans('id'); ?></th>
                            <th><?= trans('type'); ?></th>
                            <th><?= trans('value'); ?></th>
                            <th><?= trans('date_added'); ?></th>
                            <th class="th-options"><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($blacklistEmails)):
                            foreach ($blacklistEmails as $item): ?>
                                <tr>
                                    <td><?= esc($item->id); ?></td>
                                    <td><?= esc(trans($item->type)); ?></td>
                                    <td>
                                        <?= $item->type === 'domain' ? '*@' . esc($item->value) : esc($item->value); ?>
                                    </td>
                                    <td style="width: 200px;"><?= formatDate($item->created_at); ?></td>
                                    <td style="width: 130px;">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" onclick="deleteItem('Admin/deleteBlacklistEmail','<?= $item->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>

                    <?php if (empty($blacklistEmails)): ?>
                        <p class="text-center">
                            <?= trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
                        <div class="col-sm-12 table-ft">
                            <div class="row">
                                <div class="pull-right">
                                    <?= $pager->links(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalAddEmail" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="max-width: 840px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= trans("add_to_blacklist"); ?></h4>
            </div>

            <form action="<?= adminUrl('email-blacklist'); ?>" method="post">
                <?= csrf_field(); ?>

                <div class="modal-body">
                    <div class="form-group">
                        <label><?= trans("type"); ?></label>
                        <select name="type" id="blacklistType" class="form-control" required>
                            <option value="email"><?= trans("email"); ?></option>
                            <option value="domain"><?= trans("domain"); ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label id="blacklistValueLabel"><?= trans("email"); ?></label>
                        <input type="email" name="value" id="blacklistValue" class="form-control" placeholder="E.g. user@example.com" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <?= trans("add_to_blacklist"); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#blacklistType').on('change', function () {
            var isDomain = this.value === 'domain';

            $('#blacklistValueLabel').text(
                isDomain
                    ? '<?= esc(trans("domain"), "js"); ?>'
                    : '<?= esc(trans("email"), "js"); ?>'
            );

            $('#blacklistValue').attr({
                type: isDomain ? 'text' : 'email',
                placeholder: isDomain ? 'E.g. example.com' : 'E.g. user@example.com'
            }).val('');
        });
    });
</script>