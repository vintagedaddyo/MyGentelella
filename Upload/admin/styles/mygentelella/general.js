(function ($, window) {
    var URL = window.location,
        $BODY = $('body'),
        $SIDEBAR_MENU = $('#sidebar-menu'),
        $MENU_TOGGLE = $('#menu_toggle'),
        $SIDEBAR_FOOTER = $('.sidebar-footer'),
        $LEFT_COL = $('.left_col'),
        check = $('input[name="allbox"]').next(),
        action,
        search_button,
        dropdown,
        left,
        wLeft,
        pMenu,
        to;

    $SIDEBAR_MENU.find('li').on('click', function (ev) {
        var link = $('a', this).attr('href');

        // prevent event bubbling on parent menu
        if (link) {
            ev.stopPropagation();
        } else { // execute slidedown if parent menu
            if ($(this).is('.active')) {
                $(this).removeClass('active');
                $('ul', this).slideUp();
            } else {
                $SIDEBAR_MENU.find('li').removeClass('active');
                $SIDEBAR_MENU.find('li ul').slideUp();
                
                $(this).addClass('active');
                $('ul', this).slideDown();
            }
        }
    });

    $MENU_TOGGLE.on('click', function () {
        if ($BODY.hasClass('nav-md')) {
            $BODY.removeClass('nav-md').addClass('nav-sm');
            $LEFT_COL.removeClass('scroll-view').removeAttr('style');
            $SIDEBAR_FOOTER.hide();

            if ($SIDEBAR_MENU.find('li').hasClass('active')) {
                $SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
            }
        } else {
            $BODY.removeClass('nav-sm').addClass('nav-md');
            $SIDEBAR_FOOTER.show();

            if ($SIDEBAR_MENU.find('li').hasClass('active-sm')) {
                $SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
            }
        }
    });

    // check active menu
    $SIDEBAR_MENU.find('a[href="' + URL + '"]').parent('li').addClass('current-page');

    $SIDEBAR_MENU.find('a').filter(function () {
        return this.href == URL;
    }).parent('li').addClass('current-page').parent('ul').slideDown().parent().addClass('active');
    
    $('.inputfile').each(function () {
		var $input	 = $(this),
			$label	 = $input.next('label'),
			labelVal = $label.html();

		$input.on('change', function (e) {
			var fileName = '';

			if (this.files && this.files.length > 1) {
				fileName = ('{count} files').replace('{count}', this.files.length);
            } else if (e.target.value) {
				fileName = e.target.value.split('\\').pop();
            }
            
			if (fileName) {
				$label.html(fileName);
            } else {
				$label.html(labelVal);
            }
		});

		// Firefox bug fix
		$input.on('focus', function () { $input.addClass('has-focus'); }).on('blur', function () { $input.removeClass('has-focus'); });
	});
    
    $("input[data-icheck!='no']").iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    }).parents('label').attr('onclick', $(this).find('input').attr('onclick'));
    
    $('input[type="radio"][data-icheck!="no"], input[type="checkbox"][data-icheck!="no"]').each(function () {
        action = $(this).attr('onclick');
        $(this).attr('onclick', '');
        $(this).parents('label').attr('onclick', action).find('ins').attr('onclick', action);
    });
    
    search_button = $(".search_button");
    $("#search").wrap("<div class='input-group'></div>").parent().append(search_button);
    search_button.addClass("btn btn-primary").wrap("<span class='input-group-btn'></span>");
    
    $('input[type="button"], input[type="submit"]').each(function () {
        if (!$(this).hasClass("btn")) {
            $(this).addClass("btn btn-default");
        }
    });
    $('input[type="text"], select').each(function () {
        if (!$(this).hasClass("form-control")) {
            $(this).addClass("form-control").css({ "width": "auto", "display": "inline-block" });
        }
    });
    
    $(".popup_button").each(function () {
        $(this).off("click");
        if (!$(this).hasClass("btn")) {
            $(this).addClass("btn btn-default").css("display", "inline-block");
        }
        $(this).append(" <span class='caret'></span>");
        
        var popup = $(this).prev();
        $(this).wrap("<div class=\"dropdown\"></div>");
        $(this).parent().append(popup);
        $(this).click(function () {
            dropdown = $("#" + $(this).attr("id") + "_popup");
            console.log("#" + $(this).attr("id") + "_popup");
            left = $(this).offset().left;
            wLeft = $(window).width();
            pMenu = dropdown.width();
            if (wLeft - (left + pMenu) > 0) {
                to = "left";
            } else {
                to = "right";
            }
            
            dropdown.toggle().css(to, "0px");
        });
    });
    
    $(".quick_perm_fields > div").addClass("col-md-6 col-sm-6 col-xs-6").find("li").addClass("badge");
    
    check.on("click", function () {
        var pre = $(this).prev();
        inlineModeration.checkAll(pre);
        if ($(this).parent().hasClass("checked")) {
            $("#users_list .iCheck-helper").parent().addClass("checked");
        } else {
            $("#users_list .iCheck-helper").parent().removeClass("checked");
        }
    });
    $("#users_list .iCheck-helper").on("click", function () {
        $(this).parents("fieldset").toggleClass("inline_selected");
        
        var element = $(this).prev(),
            inlineCheck = element.attr('id').split('_'),
            id = inlineCheck[1],
            inlineIds = inlineModeration.getCookie(inlineModeration.cookieName),
            removedIds = inlineModeration.getCookie(inlineModeration.cookieName + '_removed'),
            allSelectedRow,
            selectRow;

		if (!element || !element.attr('id') || !id) {
			return false;
		}

		if (element.prop('checked') === true) {
			if (inlineIds.indexOf('ALL') === -1) {
				inlineIds = inlineModeration.addId(inlineIds, id);
			} else {
				removedIds = inlineModeration.removeId(removedIds, id);
				if (removedIds.length === 0) {
					allSelectedRow = $('#allSelectedrow');
					if (allSelectedRow) {
						allSelectedRow.show();
					}
				}
			}
		} else {
			if (inlineIds.indexOf('ALL') === -1) {
				inlineIds = inlineModeration.removeId(inlineIds, id);
				selectRow = $('#selectAllrow');
				if (selectRow) {
					selectRow.hide();
				}
			} else {
				removedIds = inlineModeration.addId(removedIds, id);
				allSelectedRow = $('#allSelectedrow');
				if (allSelectedRow) {
					allSelectedRow.hide();
				}
			}
		}

		inlineModeration.updateCookies(inlineIds, removedIds);
    });
})(jQuery, window);