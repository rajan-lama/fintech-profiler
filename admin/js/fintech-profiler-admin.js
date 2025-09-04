(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

jQuery(document).ready(function($) {
    let wrapper = $('#fintech-profiler-links-wrapper');
    let template = $('#fintech-profiler-link-template').html();
    let rowIndex = wrapper.find('.fintech-profiler-link-row').length;

    $('#add-fintech-profiler-link').on('click', function() {
        let newRow = template.replace(/INDEX/g, rowIndex);
        wrapper.append(newRow);
        rowIndex++;
    });

    wrapper.on('click', '.remove-row', function() {
        $(this).closest('.fintech-profiler-link-row').remove();
    });

    wrapper.on('click', '.upload-fintech-profiler-image', function(e) {
        e.preventDefault();
        let button = $(this);
        let customUploader = wp.media({
            title: 'Select Image',
            button: { text: 'Use this image' },
            multiple: false
        }).on('select', function() {
            let attachment = customUploader.state().get('selection').first().toJSON();
            button.siblings('.fintech-profiler-link-image').val(attachment.url);
            button.siblings('.fintech-profiler-link-preview').attr('src', attachment.url).show();
        }).open();
    });
});
