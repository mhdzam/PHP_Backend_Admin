var Inbox = function () {

    var content = $('.inbox-content');
    var loading = $('.inbox-loading');
    var listListing = '';

    var loadInbox = function (el , name , cat , pageno , emailid, srchwrd) {
        var url = 'template/inbox_view.php?cat='+cat+'&page='+pageno+'&flag='+emailid+'&qqq='+srchwrd;
        var title = $('.inbox-nav > li.' + name + ' a').attr('data-title');
        listListing = name;

        loading.show();
        content.html('');
        toggleButton(el);

        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-nav > li.' + name).addClass('active');
                $('.inbox-header > h1').text(title);

                loading.hide();
                content.html(res);
                App.fixContentHeight();
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });

        // handle group checkbox:
        jQuery('body').on('change', '.mail-group-checkbox', function () {
            var set = jQuery('.mail-checkbox');
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                $(this).attr("checked", checked);
            });
            jQuery.uniform.update(set);
        });
    }

    var loadMessage = function (el, name, resetMenu , msgemailid) {
        var url = 'template/inbox_view_details.php?id='+msgemailid;

        loading.show();
        content.html('');


        var message_id = msgemailid;  
        
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            data: {'message_id': message_id},
            success: function(res) 
            {
  

                if (resetMenu) {
                    $('.inbox-nav > li.active').removeClass('active');
                }
               // $('.inbox-header > h1').text('View Message');

                loading.hide();
                content.html(res);
                App.fixContentHeight();
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
           
            },
            async: false
        });
    }

    var initWysihtml5 = function () {
        $('.inbox-wysihtml5').wysihtml5({
            "stylesheets": ["assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
        });
    }

    var initFileupload = function () {

        $('#fileupload').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: 'assets/plugins/jquery-file-upload/server/php/',
            autoUpload: true
        });

        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: 'assets/plugins/jquery-file-upload/server/php/',
                type: 'HEAD'
            }).fail(function () {
                $('<span class="alert alert-error"/>')
                    .text('Upload server currently unavailable - ' +
                    new Date())
                    .appendTo('#fileupload');
            });
        }
    }

    var loadCompose = function (el,catis,msgidis,mmbr) {
        var url = 'template/inbox_new.php?msgstatus='+catis+'&msgid='+msgidis+'&member_id='+mmbr;
        var title = $('.inbox-nav > .compose-btn a').attr('data-title');
        loading.show();
        content.html('');
        toggleButton(el);

        // load the form via ajax
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-header > h1').text(title);

                loading.hide();
                content.html(res);

                
                initWysihtml5();

                $('.inbox-wysihtml5').focus();
                App.fixContentHeight();
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    }

    var loadReply = function (el) {
        var url = 'inbox_reply.html';

        loading.show();
        content.html('');
        toggleButton(el);

        // load the form via ajax
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-header > h1').text('Reply');

                loading.hide();
                content.html(res);
                $('[name="message"]').val($('#reply_email_content_body').html());

                handleCCInput(); // init "CC" input field

                initFileupload();
                initWysihtml5();
                App.fixContentHeight();
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    }

    var loadSearchResults = function (el) {
        var url = 'inbox_search_result.html';

        loading.show();
        content.html('');
        toggleButton(el);

        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-header > h1').text('Search');

                loading.hide();
                content.html(res);
                App.fixContentHeight();
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    }

    var handleCCInput = function () {
        var the = $('.inbox-compose .mail-to .inbox-cc');
        var input = $('.inbox-compose .input-cc');
        the.hide();
        input.show();
        $('.close', input).click(function () {
            input.val('');            
            input.hide();
            the.show();
        });
    }

    var handleBCCInput = function () {

        var the = $('.inbox-compose .mail-to .inbox-bcc');
        var input = $('.inbox-compose .input-bcc');
        the.hide();
        input.show();
        $('.close', input).click(function () {
            input.val(''); 
            input.hide();
            the.show();
        });
    }

    var toggleButton = function(el) {
        if (typeof el == 'undefined') {
            return;
        }
        if (el.attr("disabled")) {
            el.attr("disabled", false);
        } else {
            el.attr("disabled", true);
        }
    }

    return {
        //main function to initiate the module
        init: function () {

            // handle compose btn click
            $('.inbox').on('click', '.pagination-control a', function () {
                loadInbox($(this),$(this).attr('show-cat'),$(this).attr('cat-id'),$(this).attr('page-no'),'',$(this).attr('srch-wrd'));
            });

            // handle compose btn click
            $('.inbox').on('click', '.page-star > span', function () {
                loadInbox($(this),$(this).attr('show-cat'),$(this).attr('cat-id'),$(this).attr('page-no'),$(this).attr('message-id'),$(this).attr('srch-wrd'));
            });
                        
            // handle compose btn click
            $('.inbox').on('click', '.compose-btn a', function () {
                loadCompose($(this));
            });

            // handle discard btn
            $('.inbox').on('click', '.inbox-discard-btn', function(e) {
                e.preventDefault();
                loadInbox($(this), listListing,0,1,'','');
            });

            // handle reply and forward button click
            $('.inbox').on('click', '.reply-btn', function () {
                loadReply($(this));
            });

            // handle view message
            $('.inbox-content').on('click', '.view-message', function () {
                var thiscatis = $(this).attr('cat-id');
                if(thiscatis === "2"){
                    loadCompose($(this),'dr',$(this).attr('message-id'),0);
                }else{
                    loadMessage($(this),'','',$(this).attr('message-id'));
                }
            });

            // handle inbox listing
            $('.inbox-nav > li.inbox > a').click(function () {
                loadInbox($(this), 'inbox',0,1,'','');
            });

        	$('.inbox').on('click', '.dropdown-menu >li #confirmation_box_for_delete', function () {
        			if(confirm('Are You Sure?')) {
        			    multicheckfrm.clicked_btn.value='b_delete';document.getElementById('multicheckfrm').submit();
        			}
        		return false;
        	});

        	$('.inbox').on('click', '.confirmation_delete #confirmation_msg_for_delete', function () {
        			if(confirm('Are You Sure?')) {
        			     window.location.href = '?act=delete&msgid='+$(this).attr('message-id')+'&a='+$(this).attr('show-cat')+'&p='+$(this).attr('page-no');
        			}
        		return false;
        	});            
    
            // handle sent listing
            $('.inbox-nav > li.sent > a').click(function () {
                loadInbox($(this), 'sent',1,1,'','');
            });

            // handle draft listing
            $('.inbox-nav > li.draft > a').click(function () {
                loadInbox($(this), 'draft',2,1,'','');
            });

            // handle trash listing
            $('.inbox-nav > li.trash > a').click(function () {
                loadInbox($(this), 'trash',3,1,'','');
            });

            //handle compose/reply cc input toggle
            $('.inbox').on('click', '.mail-to .inbox-cc', function () {
                handleCCInput();
            });

            //handle compose/reply bcc input toggle
            $('.inbox').on('click', '.mail-to .inbox-bcc', function () {
                handleBCCInput();
            });

            //handle loading content based on URL parameter
            var pgetogo=App.getURLParameter("p");
            if(pgetogo == "" || pgetogo == 0 || pgetogo == null){
                pgetogo=1;  
            }
            var srchword=App.getURLParameter("q");
            if(srchword == "" || srchword == null){
                srchword='';  
            }
            var msgidtogo=App.getURLParameter("id");
            if(msgidtogo == "" || msgidtogo == 0 || msgidtogo == null){
                msgidtogo='';  
            }
            var mmbrid=App.getURLParameter("member_id");
            if(mmbrid == "" || mmbrid == 0 || mmbrid == null){
                mmbrid='';
            }
            if (App.getURLParameter("a") === "view") {
                loadMessage('','','',msgidtogo);
            } else if (App.getURLParameter("a") === "search") {
                loadInbox($(this), 'search',4,pgetogo,'',srchword);              
            } else if (App.getURLParameter("a") === "trash") {
                loadInbox($(this), 'trash',3,pgetogo,'',srchword);              
            } else if (App.getURLParameter("a") === "draft") {
                loadInbox($(this), 'draft',2,pgetogo,'',srchword);              
            } else if (App.getURLParameter("a") === "sent") {
                loadInbox($(this), 'sent',1,pgetogo,'',srchword);              
            } else if (App.getURLParameter("a") === "compose") {
                loadCompose($(this),App.getURLParameter("status"),msgidtogo,mmbrid);
            } else {
               loadInbox($(this), 'inbox',0,pgetogo,'',srchword);
            }

        }

    };

}();