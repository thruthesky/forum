var forum = {
    showLoader : function() {

    },
    on_change_file_upload : function (filebox) {
        var $filebox = $(filebox);
        var $form = $filebox.parents("form");
        var $do = $form.find('[name="do"]');
        $do.val('file_upload');


        var $obj;
        if ( $form.hasClass( 'comment-write-form') ) {
            $obj = $('.alt-buttons');
        }
        else $obj = $('.post-write-form .post-content-wrapper .photos');
        html.showLoaderAfter(14, $obj, ' 업로드 중 ... 1분 이상 걸릴 수 있습니다.');
        //html.createUploadLoader( $form.find(".photos") );//added by benjamin

        $form.ajaxSubmit({
            error : function (xhr) {
                $do.val('post_create');
                alert("ERROR: ajax file upload failed ...");
                //html.hideLoader();
                html.removeUploadLoader( $form.find(".photos"), null );//added by benjamin
            },
            complete: function (xhr) {
                //trace("File upload completed thru jquery.form.js");
                var re;
                try {
                    re = JSON.parse(xhr.responseText);
                }
                catch (e) {
                    //html.hideLoader();
                    html.removeUploadLoader( $form.find(".photos") );//added by benjamin
                    //console.log(s.stripTags(xhr.responseText));
                    return alert("에러: 파일 업로드에 실패하였습니다.");
                    //return alert(s.stripTags(xhr.responseText));
                }
                //trace(re);
                if ( re['code'] ) {
                    return alert(re['message']);
                }

                if ( app.isRegisterPage() ) html.update_primary_photo( re.data );
                else {
                    var $photos = $form.find('.photos');
                    $photos.append( html.render_photo( re.data ) );
                }
                html.hideLoader();
                //html.removeUploadLoader( $form.find(".photos"), re.data['idx'] );//added by benjamin
            }
        });
        $do.val('post_create');
        $filebox.val('');
    }
};