var Glt_Admin = {
	
	initialize: function() {
		
		this.initializeFields();
		
	},
	
	initializeFields: function() {
	
		var tab = jQuery("#glt-tab").val();
		
		switch (tab) {
			case "general":
				this.initializeLanguages();
				this.initializeFlags();
				this.initializeFlagsOrder();
				this.initializeDisplayMode();
				break;
			case "advanced":
				this.initializeAnalytics();
				break;
		}
		
	},
	
	initializeLanguages: function() {
		
		Glt_Admin.onLanguagesChange();
		jQuery("input[name='glt-languages']").click(Glt_Admin.onLanguagesChange);
		
		Glt_Admin.onLanguageSelect();
		
	},
	
	onLanguagesChange: function() {
		
		var all = jQuery("#glt-languages-all").get(0).checked;
		var languages_list_wrapper = jQuery("#languages_list_wrapper");
		
		if (all)
			languages_list_wrapper.css("display", "none");
		else
			languages_list_wrapper.css("display", "table-row");
		
		Glt_Admin.showFlags();
		
	},

	onLanguageSelect: function() {
		
		jQuery("input[name='glt-languages-list-aux']").click(Glt_Admin.onLanguageSelectChange);
		
	},
	
	onLanguageSelectChange: function(_event, _field) {
		
		var result = [];
		var target = jQuery("#glt-languages-list");
		
		var list = jQuery("input[name='glt-languages-list-aux']");
		
		for (var i=0; i<list.length; i++)
			if (list.get(i).checked)
				result.push(list.get(i).value);
		
		target.val(result.join(","));
		
	},

	showAlign: function() {
		
		var align_wrapper = jQuery("#align_wrapper");
		
		if (jQuery("#glt-display-mode").val() == "inline")
			align_wrapper.css("display", "table-row");
		else
			align_wrapper.css("display", "none");
		
	},
	
	showToolbar: function() {
		
		var toolbar_wrapper = jQuery("#toolbar_wrapper");

		if (jQuery("#glt-display-mode").val() == "inline")
			toolbar_wrapper.css("display", "table-row");
		else
			toolbar_wrapper.css("display", "none");

	},
		
	showFlags: function() {

		var all = jQuery("#glt-languages-all").get(0).checked;
		var dm_4flags = jQuery("#glt-display-mode").val() == "inline" && jQuery("#glt-inline-display-mode").val() != "dropdown";		
		var flags_wrapper = jQuery("#flags_wrapper");
		var choose_flags_wrapper = jQuery("#choose_flags_wrapper");
		var flags_list_wrapper = jQuery("#flags_list_wrapper");
		var flags_order_title_wrapper = jQuery("#flags_order_title_wrapper");
		var flags_order_wrapper = jQuery("#flags_order_wrapper");
		
		if (all && dm_4flags) {
			flags_wrapper.css("display", "table-row");
			choose_flags_wrapper.css("display", "table-row");
			flags_list_wrapper.css("display", "table-row");
			flags_order_title_wrapper.css("display", "table-row");
			flags_order_wrapper.css("display", "table-row");
		}
		else {
			flags_wrapper.css("display", "none");
			choose_flags_wrapper.css("display", "none");
			flags_list_wrapper.css("display", "none");
			flags_order_title_wrapper.css("display", "none");
			flags_order_wrapper.css("display", "none");
		}
		
	},

	initializeFlags: function() {
		
		Glt_Admin.onFlagsChange();
		jQuery("input[name='glt-flags']").click(Glt_Admin.onFlagsChange);
		
		Glt_Admin.onFlagsSelect();
		
	},
	
	onFlagsSelect: function() {
		
		jQuery("input[name='glt-flags-list-aux']").click(Glt_Admin.onFlagsSelectChange);
		
	},
	
	onFlagsSelectChange: function(_event, _field) {
		
		var result = [];
		var target = jQuery("#glt-flags-list, #glt-flags-order");
		
		var list = jQuery("input[name='glt-flags-list-aux']");
		
		for (var i=0; i<list.length; i++)
			if (list.get(i).checked)
				result.push(list.get(i).value);
		
		target.val(result.join(","));
		jQuery("#glt-flags-order-aux").val("1");
		
	},
	
	onFlagsChange: function() {
		
		var yes = jQuery("#glt-flags-show").get(0).checked;
		var choose_flags_wrapper = jQuery("#choose_flags_wrapper");
		var flags_list_wrapper = jQuery("#flags_list_wrapper");
		var flags_order_title_wrapper = jQuery("#flags_order_title_wrapper");
		var flags_order_wrapper = jQuery("#flags_order_wrapper");
		
		if (yes) {
			choose_flags_wrapper.css("display", "table-row");
			flags_list_wrapper.css("display", "table-row");
			flags_order_title_wrapper.css("display", "table-row");
			flags_order_wrapper.css("display", "table-row");
		}
		else {
			choose_flags_wrapper.css("display", "none");
			flags_list_wrapper.css("display", "none");
			flags_order_title_wrapper.css("display", "none");
			flags_order_wrapper.css("display", "none");
		}
		
	},

	initializeDisplayMode: function() {
		
		Glt_Admin.onDisplayModeChange();
		jQuery("#glt-display-mode").change(Glt_Admin.onDisplayModeChange);
		jQuery("#glt-inline-display-mode").change(Glt_Admin.showFlags);
		
	},
	
	onDisplayModeChange: function() {
		
		var field = jQuery("#glt-display-mode");
		var inline_display_mode_wrapper = jQuery("#inline_display_mode_wrapper");
		var tabbed_display_mode_wrapper = jQuery("#tabbed_display_mode_wrapper");
		var automatic_display_mode_wrapper = jQuery("#automatic_display_mode_wrapper");
		
		switch (field.val()) {
			case "inline":
				inline_display_mode_wrapper.css("display", "inline");
				tabbed_display_mode_wrapper.css("display", "none");
				automatic_display_mode_wrapper.css("display", "none");
				break;
			case "tabbed":
				inline_display_mode_wrapper.css("display", "none");
				tabbed_display_mode_wrapper.css("display", "inline");
				automatic_display_mode_wrapper.css("display", "none");
				break;
			default:
				inline_display_mode_wrapper.css("display", "none");
				tabbed_display_mode_wrapper.css("display", "none");
				automatic_display_mode_wrapper.css("display", "inline");
				break;
		}
		
		Glt_Admin.showFlags();
		Glt_Admin.showToolbar();
		Glt_Admin.showAlign();
		
	},
	
	initializeAnalytics: function() {
		
		Glt_Admin.onAnalyticsChange();
		jQuery("input[name='glt-analytics']").click(Glt_Admin.onAnalyticsChange);
		
	},
	
	onAnalyticsChange: function() {
		
		var yes = jQuery("#glt-analytics-yes").get(0).checked;
		var analytics_id_wrapper = jQuery("#analytics_id_wrapper");
		
		if (yes)
			analytics_id_wrapper.css("display", "table-row");
		else
			analytics_id_wrapper.css("display", "none");
		
	},
	
	initializeFlagsOrder: function() {
		
		jQuery("#flags_order").sortable({
			distance: 10,
			helper: "clone",
			forcePlaceholderSize: true,
			update: function(event, ui) {
				
				if (jQuery("#glt-flags-order-aux").val() == "1")
					return;
				
				var flags = jQuery("#flags_order li.glt-flag");
				var result = [];
				var temp;
				for (var i=0; i<flags.length; i++) {
					temp = flags.eq(i).attr("class");
					temp = temp.match(/glt-flag-([a-z]{2,})/);
					if (temp)
						result.push(temp[1]);
				}					
				jQuery("#glt-flags-order").val(result.join(","));
				
			}
		});
		
	}
	
};

jQuery(document).ready(function() {
	
	Glt_Admin.initialize();

});