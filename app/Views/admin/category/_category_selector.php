<?php $selectorId = 'categoryDropdown_' . uniqid(); ?>
<div id="<?= $selectorId; ?>" class="min-h-40px"></div>

<link href="<?= base_url('assets/admin/vendor/category-selector/category-selector.css'); ?>" rel="stylesheet" type="text/css"/>
<script src="<?= base_url('assets/admin/vendor/category-selector/category-selector.js'); ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const categorySelector = new CategorySelector('#<?= $selectorId; ?>', {
            inputName: '<?= !empty($selectorName) ? $selectorName : "category_id"; ?>',
            extraParams: {
                lang_id: '<?= $selectorLangId ?? 0; ?>',
                exclude_id: '<?= $selectorExcludeId ?? 0; ?>'
            },
            initialValue: '<?= $selectorInitialValue ?? 0; ?>',
            initialData: <?= !empty($selectorInitialData) ? $selectorInitialData : 'null'; ?>,
            showId: <?= !empty($selectorShowId) ? 'true' : 'false'; ?>,
            allowNone: <?= !empty($selectorAllowNone) ? 'true' : 'false'; ?>,
            urls: {
                fetch: "<?= adminUrl('categories/selector/list'); ?>",
                search: "<?= adminUrl('categories/selector/search'); ?>",
            },
            ux: {
                placeholder: MdsConfig.text.selectCategory,
                searchPlaceholder: MdsConfig.text.search,
                noResults: MdsConfig.text.noResultsFound,
                loading: MdsConfig.text.loading,
                searching: MdsConfig.text.searching,
                noneOption: MdsConfig.text.none,
            },
            onSelect: (item) => {
                <?php if (!empty($selectorTargetContainer)): ?>
                const targetContainer = document.getElementById('<?= $selectorTargetContainer; ?>');
                if (targetContainer) {
                    // Send custom event to the target container
                    targetContainer.dispatchEvent(new CustomEvent('category-selected', { detail: item }));

                    // Reset the selector completely after a small delay
                    setTimeout(() => {
                        categorySelector.reload();
                    }, 100);
                }
                <?php endif; ?>
            }
        });

        $(document).on('change', '#languageSwitcher', function (e) {
            const langId = e.target.value;
            categorySelector.reload({
                extraParams: { lang_id: langId }
            });
        });
    });
</script>