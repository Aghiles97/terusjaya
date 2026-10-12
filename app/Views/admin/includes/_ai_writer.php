<div id="modalAiWriter" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="max-width: 840px;">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" style="font-size: 16px;"><i class="fa-solid fa-xmark"></i></button>
                <h4 class="modal-title"><?= trans("ai_content_generator"); ?></h4>
            </div>

            <form id="formAiWriter" action="#">
                <input type="hidden" name="ai_language" value="<?= esc($activeLang->name); ?>">
                <input type="hidden" name="ai_content_type" value="article">
                <input type="hidden" name="ai_target_container" value="">

                <div class="modal-body">
                    <div id="aiStepInput">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"><?= trans('tone_style'); ?> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="ai_tone">
                                        <?php if (!empty($aiWriterConfig->tones)): ?>
                                            <?php foreach ($aiWriterConfig->tones as $tone): ?>
                                                <option value="<?= $tone; ?>" <?= ($tone == 'neutral') ? 'selected' : ''; ?>>
                                                    <?= trans('tone_' . $tone); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"><?= trans('length_of_text'); ?> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="ai_length">
                                        <?php if (!empty($aiWriterConfig->lengths)): ?>
                                            <?php foreach ($aiWriterConfig->lengths as $length): ?>
                                                <option value="<?= $length; ?>" <?= ($length == 'medium') ? 'selected' : ''; ?>>
                                                    <?= trans($length); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="control-label"><?= trans('topic'); ?> <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="3" name="ai_topic" placeholder="<?= trans("topic_ai_placeholder", "attr") ?>"></textarea>
                            <p class="help-block text-muted" style="font-size: 13px; margin-bottom: 0; margin-top: 5px;">
                                <?= trans("topic_ai_exp"); ?>
                            </p>
                        </div>
                    </div>

                    <div id="aiStepResult" style="display: none;">
                        <div class="form-group">
                            <label class="control-label text-muted"><strong><?= trans("title"); ?></strong></label>
                            <input type="text" class="form-control" id="aiResultTitle" readonly>
                        </div>

                        <div class="form-group">
                            <label class="control-label text-muted"><strong><?= trans('summary'); ?> & <?= trans("description"); ?></strong></label>
                            <textarea class="form-control" id="aiResultSummary" rows="2" readonly></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label text-muted"><strong><?= trans("keywords"); ?></strong></label>
                            <input type="text" class="form-control" id="aiResultKeywords" readonly>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="control-label text-muted"><strong><?= trans("content"); ?></strong></label>
                            <div class="form-control" id="aiResultContent" style="height: 300px; overflow-y: auto; background-color: #f9f9f9; padding: 15px; font-size: 14px; line-height: 24px; cursor: not-allowed;"></div>
                            <textarea id="aiResultContentRaw" style="display: none;"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer" style="text-align: center;">
                    <div class="ai-action-buttons" style="display: inline-block;">

                        <button type="button" id="btnAiGenerate" class="btn btn-primary" style="min-width: 150px;">
                            <span class="display-flex align-items-center gap-5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="16" height="16" fill="currentColor">
                                    <path d="M295.4 37L310.2 73.8L347 88.6C350 89.8 352 92.8 352 96C352 99.2 350 102.2 347 103.4L310.2 118.2L295.4 155C294.2 158 291.2 160 288 160C284.8 160 281.8 158 280.6 155L265.8 118.2L229 103.4C226 102.2 224 99.2 224 96C224 92.8 226 89.8 229 88.6L265.8 73.8L280.6 37C281.8 34 284.8 32 288 32C291.2 32 294.2 34 295.4 37zM142.7 105.7L164.2 155.8L214.3 177.3C220.2 179.8 224 185.6 224 192C224 198.4 220.2 204.2 214.3 206.7L164.2 228.2L142.7 278.3C140.2 284.2 134.4 288 128 288C121.6 288 115.8 284.2 113.3 278.3L91.8 228.2L41.7 206.7C35.8 204.2 32 198.4 32 192C32 185.6 35.8 179.8 41.7 177.3L91.8 155.8L113.3 105.7C115.8 99.8 121.6 96 128 96C134.4 96 140.2 99.8 142.7 105.7zM496 368C502.4 368 508.2 371.8 510.7 377.7L532.2 427.8L582.3 449.3C588.2 451.8 592 457.6 592 464C592 470.4 588.2 476.2 582.3 478.7L532.2 500.2L510.7 550.3C508.2 556.2 502.4 560 496 560C489.6 560 483.8 556.2 481.3 550.3L459.8 500.2L409.7 478.7C403.8 476.2 400 470.4 400 464C400 457.6 403.8 451.8 409.7 449.3L459.8 427.8L481.3 377.7C483.8 371.8 489.6 368 496 368zM492 64C503 64 513.6 68.4 521.5 76.2L563.8 118.5C571.6 126.4 576 137 576 148C576 159 571.6 169.6 563.8 177.5L475.6 265.7L374.3 164.4L462.5 76.2C470.4 68.4 481 64 492 64zM76.2 462.5L340.4 198.3L441.7 299.6L177.5 563.8C169.6 571.6 159 576 148 576C137 576 126.4 571.6 118.5 563.8L76.2 521.5C68.4 513.6 64 503 64 492C64 481 68.4 470.4 76.2 462.5z"></path>
                                </svg>
                                <span class="indicator-label">
                                    <?= trans("generate_content"); ?>
                                </span>
                                <span class="indicator-progress">
                                    <?= trans("generating_content"); ?> <i class="fa fa-spinner fa-spin" style="margin-left: 5px;"></i>
                                </span>
                            </span>
                        </button>

                        <div id="aiResultButtons" style="display: none;">
                            <button type="button" class="btn btn-danger" id="btnAiReset" style="margin-right: 5px;">
                                <i class="fa fa-refresh"></i> <?= trans("reset"); ?>
                            </button>

                            <button type="button" class="btn btn-info" id="btnAiRegenerate" style="margin-right: 5px;">
                                <span class="indicator-label">
                                    <i class="fa fa-retweet"></i> <?= trans("regenerate"); ?>
                                </span>
                                <span class="indicator-progress">
                                    <i class="fa fa-retweet"></i> <?= trans("regenerate"); ?>&nbsp;<i class="fa fa-spinner fa-spin"></i>
                                </span>
                            </button>

                            <button type="button" class="btn btn-success" id="btnAiUse">
                                <i class="fa fa-check-circle"></i> <?= trans("use_content"); ?>
                            </button>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
    .indicator-progress {
        display: none;
    }

    [data-kt-indicator="on"] .indicator-label {
        display: none;
    }

    [data-kt-indicator="on"] .indicator-progress {
        display: inline-block;
    }
</style>

<?= $this->section('scripts'); ?>
<script>
    const AiWriterConfig = {
        endpoints: {
            generate: "<?= base_url('Ajax/generateAIContent'); ?>"
        },
        translations: {
            errorTopic: <?= json_encode(trans("msg_topic_empty", "raw")); ?>,
            errorGeneric: <?= json_encode(trans("msg_error", "raw")); ?>,
            errorGenerate: <?= json_encode(trans("ai_writer_api_error", "raw")); ?>
        },
        selectors: {
            targetTitle: '.ai-input-title',
            targetSummary: '.ai-input-summary',
            targetKeywords: '.ai-input-keywords',
            targetContent: '.ai-input-content'
        }
    };
</script>
<script src="<?= base_url('assets/admin/js/ai-writer.js'); ?>"></script>
<?= $this->endSection(); ?>