(function ($) {
    "use strict";

    // Global DOM object definition
    let aiDOM = {};

    /**
     * App Logic
     */
    const AiWriterApp = {
        init: function () {
            this.initDOM();
            this.bindEvents();
        },

        initDOM: function () {
            aiDOM = {
                // Modal & Layout
                modal: $('#modalAiWriter'),
                form: $('#formAiWriter'),
                stepInput: $('#aiStepInput'),
                stepResult: $('#aiStepResult'),

                // AI Configuration Inputs
                inputTopic: $('textarea[name="ai_topic"]'),
                inputLang: $('input[name="ai_language"]'),
                inputType: $('input[name="ai_content_type"]'),
                inputTargetContainer: $('input[name="ai_target_container"]'), // Added for dynamic container scope
                selectTone: $('select[name="ai_tone"]'),
                selectLength: $('select[name="ai_length"]'),

                // AI Generated Outputs
                outTitle: $('#aiResultTitle'),
                outSummary: $('#aiResultSummary'),
                outKeywords: $('#aiResultKeywords'),
                outContentDisplay: $('#aiResultContent'),
                outContentRaw: $('#aiResultContentRaw'),

                // Action Buttons
                btnGenerate: $('#btnAiGenerate'),
                btnRegenerate: $('#btnAiRegenerate'),
                btnReset: $('#btnAiReset'),
                btnUse: $('#btnAiUse'),
                groupResultActions: $('#aiResultButtons'),

                // STATE
                activeTrigger: null
            };
        },

        bindEvents: function () {
            // Prevent accidental form submission inside the modal
            aiDOM.form.on('submit', function (e) {
                e.preventDefault();
            });

            // Capture Trigger Element via Bootstrap Modal Events & Set Dynamic Data
            aiDOM.modal.on('show.bs.modal', function (event) {
                if (event.relatedTarget) {
                    aiDOM.activeTrigger = $(event.relatedTarget);

                    // Get and set Content Type
                    const contentType = aiDOM.activeTrigger.attr('data-content-type');
                    if (contentType) {
                        aiDOM.inputType.val(contentType);
                    }

                    // Get and set Language
                    const aiLang = aiDOM.activeTrigger.attr('data-lang');
                    if (aiLang) {
                        aiDOM.inputLang.val(aiLang);
                    }

                    // Get and set Target Container
                    const targetContainer = aiDOM.activeTrigger.attr('data-target-container');
                    if (targetContainer) {
                        aiDOM.inputTargetContainer.val(targetContainer);
                    } else {
                        aiDOM.inputTargetContainer.val(''); // Reset if not provided
                    }
                }
            });

            // Reset interface when modal is completely closed
            aiDOM.modal.on('hidden.bs.modal', function () {
                aiDOM.activeTrigger = null;
                AiWriterApp.resetInterface();
            });

            // Generate & Regenerate Actions
            aiDOM.btnGenerate.add(aiDOM.btnRegenerate).on('click', (e) => {
                e.preventDefault();
                const $btn = $(e.currentTarget);
                const isRegenerate = ($btn.attr('id') === 'btnAiRegenerate');
                this.handleGeneration($btn, isRegenerate);
            });

            // Transfer Content Action
            aiDOM.btnUse.on('click', (e) => {
                e.preventDefault();
                this.transferContentToMainForm();
            });

            // Reset Interface Action
            aiDOM.btnReset.on('click', (e) => {
                e.preventDefault();
                this.resetInterface();
            });
        },

        /**
         * API Generation Handler
         */
        handleGeneration: function ($btn, isRegen) {
            const topicValue = aiDOM.inputTopic.val().trim();

            // Validation
            if (topicValue === '') {
                Swal.fire({
                    text: AiWriterConfig.translations.errorTopic,
                    icon: "warning",
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-secondary"
                    }
                });
                return;
            }

            // Set Loading State
            $btn.attr("data-kt-indicator", "on").prop("disabled", true);

            if (isRegen) {
                this.toggleResultOpacity(true);
                aiDOM.btnReset.prop('disabled', true);
                aiDOM.btnUse.prop('disabled', true);
            }

            // Prepare Payload
            const requestData = {
                'topic': topicValue,
                'lang_name': aiDOM.inputLang.val(),
                'content_type': aiDOM.inputType.val() || 'article',
                'tone': aiDOM.selectTone.val(),
                'length': aiDOM.selectLength.val()
            };

            // Execute AJAX
            $.ajax({
                type: "POST",
                url: AiWriterConfig.endpoints.generate,
                data: requestData,
                dataType: "json",
                success: (response) => {
                    if (response && response.status === 'success') {
                        // Safety Check: Verify empty content response
                        if (!response.content || response.content.trim() === '') {
                            Swal.fire({
                                text: AiWriterConfig.translations.errorGenerate,
                                icon: "error",
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                    cancelButton: "btn btn-secondary"
                                }
                            });
                            if (isRegen) this.toggleResultOpacity(false);
                            return;
                        }

                        this.populateResults(response);
                        this.transitionToResultView(isRegen);

                    } else {
                        // Backend Error Response
                        const errorMsg = (response && response.message) ? response.message : AiWriterConfig.translations.errorGeneric;
                        Swal.fire({
                            text: errorMsg,
                            icon: "error",
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-secondary"
                            }
                        });
                        if (isRegen) this.toggleResultOpacity(false);
                    }
                },
                error: (xhr, status, error) => {
                    // Network / Server Error Handling
                    const errorMsg = AiWriterConfig.translations.errorGeneric + (error ? ' (' + error + ')' : '');
                    Swal.fire({
                        text: errorMsg,
                        icon: "error",
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-secondary"
                        }
                    });
                    if (isRegen) this.toggleResultOpacity(false);
                },
                complete: () => {
                    // Reset Loading State
                    $btn.removeAttr("data-kt-indicator").prop("disabled", false);
                    aiDOM.btnReset.prop('disabled', false);
                    aiDOM.btnUse.prop('disabled', false);
                }
            });
        },

        /**
         * Helper Methods
         */
        populateResults: function (data) {
            // Title
            aiDOM.outTitle.val(data.title || '');
            aiDOM.outTitle.closest('.form-group').toggle(!!data.title && data.title !== '');

            // Summary
            aiDOM.outSummary.val(data.summary || '');
            aiDOM.outSummary.closest('.form-group').toggle(!!data.summary && data.summary !== '');

            // Keywords
            aiDOM.outKeywords.val(data.keywords || '');
            aiDOM.outKeywords.closest('.form-group').toggle(!!data.keywords && data.keywords !== '');

            // Content
            const hasContent = !!(data.content && data.content.trim() !== '');
            aiDOM.outContentDisplay.html(data.content || '');
            aiDOM.outContentRaw.val(data.content || '');
            aiDOM.outContentDisplay.closest('.form-group').toggle(hasContent);
        },

        transitionToResultView: function (isRegen) {
            if (!isRegen) {
                // Initial Transition: Hide Input -> Show Results
                aiDOM.stepInput.hide();
                aiDOM.stepResult.show();
                aiDOM.btnGenerate.hide();
                aiDOM.groupResultActions.css('display', 'inline-block');
            } else {
                // Regenerate Transition: Restore Opacity
                this.toggleResultOpacity(false);
            }
        },

        toggleResultOpacity: function (dim) {
            aiDOM.stepResult.css('opacity', dim ? '0.5' : '1');
        },

        resetInterface: function () {
            // Reset View States
            aiDOM.stepResult.hide();
            aiDOM.stepInput.show();
            aiDOM.groupResultActions.hide();
            aiDOM.btnGenerate.show();

            // Clear Values
            aiDOM.inputTopic.val('');
            aiDOM.outTitle.val('');
            aiDOM.outSummary.val('');
            aiDOM.outKeywords.val('');
            aiDOM.outContentDisplay.html('');
            aiDOM.outContentRaw.val('');
            aiDOM.stepResult.css('opacity', '1');
        },

        /**
         * Content Transfer
         */
        findTargetElement: function (selector) {
            // Check if a specific container is set via hidden input
            const containerSelector = aiDOM.inputTargetContainer.val();
            if (containerSelector && $(containerSelector).length > 0) {
                const $scopedElement = $(containerSelector).find(selector);
                if ($scopedElement.length > 0) {
                    return $scopedElement.first();
                }
            }

            // Fallback to trigger context search (closest box/panel)
            if (aiDOM.activeTrigger && aiDOM.activeTrigger.length > 0) {
                const $container = aiDOM.activeTrigger.closest('.box-body, .box, .panel-body, .collapse, .form-group, .row');
                if ($container.length > 0) {
                    const $scopedElement = $container.find(selector);
                    if ($scopedElement.length > 0) {
                        return $scopedElement.first();
                    }
                }
            }

            // Global fallback
            return $(selector).first();
        },

        transferContentToMainForm: function () {
            const generatedTitle = aiDOM.outTitle.val();
            const generatedSummary = aiDOM.outSummary.val();
            const generatedKeys = aiDOM.outKeywords.val();

            // Determine the container from hidden input (fallback to document)
            const containerSelector = aiDOM.inputTargetContainer.val();
            const $container = (containerSelector && $(containerSelector).length > 0)
                ? $(containerSelector)
                : $(document);

            // Scope the selections within the container
            const $targetTitles = $container.find(AiWriterConfig.selectors.targetTitle);
            const $targetSummaries = $container.find(AiWriterConfig.selectors.targetSummary);
            const $targetKeywords = $container.find(AiWriterConfig.selectors.targetKeywords);

            // Transfer Title
            if (generatedTitle && $targetTitles.length) {
                $targetTitles.each(function () {
                    $(this).val(generatedTitle).trigger('change').trigger('input');
                });
            }

            // Transfer Summary
            if (generatedSummary && $targetSummaries.length) {
                $targetSummaries.each(function () {
                    $(this).val(generatedSummary).trigger('change').trigger('input');
                });
            }

            // Transfer Keywords (Supports standard input & Tagify)
            if (generatedKeys && $targetKeywords.length) {
                $targetKeywords.each(function () {
                    const $el = $(this);
                    if ($el.data('tagify')) {
                        try {
                            $el.data('tagify').addTags(generatedKeys);
                        } catch (e) {
                            console.warn('Tagify error:', e);
                        }
                    } else {
                        $el.val(generatedKeys).trigger('change').trigger('input');
                    }
                });
            }

            // Transfer Rich Text Content
            const rawContent = aiDOM.outContentRaw.val();
            if (rawContent) {
                this.setEditorContent(rawContent);
            }

            // Close Modal
            aiDOM.modal.modal('hide');
        },

        setEditorContent: function (htmlContent) {
            const targetSelector = AiWriterConfig.selectors.targetContent;
            let $targetEditor = this.findTargetElement(targetSelector);

            if ($targetEditor.length > 0) {
                const editorId = $targetEditor.attr('id');

                // TinyMCE Support
                if (typeof tinymce !== 'undefined' && editorId) {
                    const editorInstance = tinymce.get(editorId);
                    if (editorInstance) {
                        editorInstance.setContent(htmlContent);
                        return;
                    }
                }

                // Standard Textarea Fallback
                $targetEditor.val(htmlContent).trigger('change');

            } else {
                // Global Editor Fallback
                if (typeof tinymce !== 'undefined' && tinymce.activeEditor) {
                    tinymce.activeEditor.setContent(htmlContent);
                }
            }
        }
    };

    // Initialize Application when DOM is fully loaded
    $(document).ready(function () {
        AiWriterApp.init();
    });

})(jQuery);