var $ = jQuery;
var forum = {
    init : function () {
        $('body').on('click', '.attach .delete', forum.delete);
    },
    el : {
        postbox : function () {
            return $("#post-new");
        },
        loader : function () {
            return forum.el.postbox().find(".loader");
        },
        photos : function() {
            return forum.el.postbox().find('.photos');
        },
        files : function() {
            return forum.el.postbox().find('.files');
        }
    },
    showLoader : function () {
        forum.el.loader().show();
    },
    hideLoader : function () {
        forum.el.loader().hide();
    },
    on_change_file_upload : function (filebox) {
        var filesize = filebox.files[0].size;
        if ( filesize >  max_upload_size ) {
            alert("File size is too big. Exceeded the limit.")
            return;
        }
        var $filebox = $(filebox);
        var $form = $filebox.parents("form");
        var $do = $form.find('[name="do"]');
        $do.val('file_upload');

        this.showLoader();

        $form.ajaxSubmit({
            error : function (xhr) {
                $do.val('post_create');
                forum.hideLoader();
                return alert(xhr.responseText);
            },
            complete: function (xhr) {
                $do.val('post_create');
                forum.hideLoader();
                var re;
                try {
                    re = JSON.parse(xhr.responseText);
                }
                catch (e) {
                    return alert(xhr.responseText);
                }
                console.log(re);
                //trace(re);
                if ( re['success'] == false || re['success'] == 'false' ) {
                    return alert('upload failed.');
                }
                forum.displayAttachment(re);
            }
        });
        $do.val('post_create');
        $filebox.val('');
    },
    displayAttachment : function ( re ) {
        var m;
        var data = re['data'];
        if ( re['data']['type'] == 'image' ) {
            forum.el.photos().append( forum.markup.upload( data ) );
            m = '<img id="id'+data['attach_id']+'" alt="'+data['file']['name']+'" src="'+data['url']+'"/>';
            tinymce.activeEditor.insertContent(m);
        }
        else {
            forum.el.files().append( forum.markup.upload( data ) );
            m = '<a href="'+data['url']+'">'+data['file']['name']+'</a>';
            tinymce.activeEditor.insertContent(m);
        }
    },
    markup : {
        upload :
            function ( data ) {
                var m = '<div class="attach" attach_id="'+data['attach_id']+'" type="'+data['type']+'">';
                if ( data['type'] == 'image' ) {
                    m += '<img src="'+data['url']+'">' +
                        '<div class="delete"><span class="dashicons dashicons-trash"></span> Delete</div>';
                }
                else {
                    m += '<a href="'+data['url']+'">'+data['file']['name']+'</a>' +
                        '<span class="delete"><span class="dashicons dashicons-trash"></span> Delete</span>';
                }
                m += "</div>";
                console.log(m);
                return m;
            }
    },
    delete : function () {

        var $delete = $(this);
        var $attach = $delete.parent('.attach');
        var id = $attach.attr('attach_id');

        var url = url_endpoint + '?do=file_delete&id=' + id;
        console.log(url);

        $.get( url, function( re ) {
            console.log(re);
            if ( re['success'] == true ) {
                var editor = tinymce.activeEditor;
                var content = editor.getContent();
                var ex = new RegExp('<img[^>]+'+id+'[^>]+>', 'gi'); // patterns, modifiers
                var html = content.replace(ex, '');
                console.log( html );
                editor.setContent(html);
                $attach.remove();
            }
        });

    }
};
forum.init();

