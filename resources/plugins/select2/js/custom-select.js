$(document).ready(function() {
	var select2Rtl = { dir: 'rtl' };

	$(".basic").select2($.extend({
		tags: true,
	}, select2Rtl));

	var formSmall = $(".form-small").select2($.extend({ tags: true }, select2Rtl));
	formSmall.data('select2').$container.addClass('form-control-sm')

	$(".nested").select2($.extend({ tags: true }, select2Rtl));
	$(".tagging").select2($.extend({ tags: true }, select2Rtl));
	$(".disabled-results").select2(select2Rtl);
	$(".placeholder").select2($.extend({
		placeholder: "Make a Selection",
		allowClear: true
	}, select2Rtl));

	function formatState (state) {
	  if (!state.id) {
		return state.text;
	  }
	  var baseClass = "flaticon-";
	  var $state = $(
		'<span><i class="' + baseClass + state.element.value.toLowerCase() + '" /> ' + state.text + '</i> </span>'
	  );
	  return $state;
	};

	$(".templating").select2($.extend({
	  templateSelection: formatState
	}, select2Rtl));

    $('.js-example-basic-single').select2(select2Rtl);
});