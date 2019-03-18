var _base_url = _base_url || '';
var _is_login = _is_login || false;

$(document).ready(function() {
    numeral.defaultFormat('0,0.[00]');
    moment.locale('vi');

    if ($('.province_has_asset').length > 0) {
        get_provinces('.province_has_asset', 1);
        $('.province_has_asset.change').on('change', function () {
            get_districts_by_province($(this));
        });

        $('.district.change').on('change', function () {
            get_wards_by_district($(this));
        });
    }

    $('img.img-user').on('error', function() { img_user_default(this); });

    $('.sorting').on('change', function () {
        var key = $(this).attr('name') || 'sort';
        var value = $(this).val();
        var url = updateUrlParameter(key, value);
        location.href = url;
    });
});
function init_fm_number(element) {
    $(element).on('keyup', function(event) {
        if (event.keyCode == 190 || event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40)
        {
            return;
        }

        var tmp = numeral( $(this).val() );
        $(this).val(tmp.format());
        if (tmp = $(this).attr('data-target')) {
            $(tmp).val(numeral( $(this).val() ).value()).valid();
        }
        if (tmp = $(this).attr('data-display')) {
            $(tmp).html(numeral( $(this).val() ).format())
        }
    });

    $(element).each(function( index ) {
        $(this).val( numeral($(this).val()).format() );
    });
}
function init_tooltip(element) {
    $(element).tooltip({
        container: 'body'
    });
}
function init_btn_delete(element) {
    $(element).on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        malert('Bạn có thật sự muốn xoá không?', 'Xác nhận xoá', null, function () {
            ajax_loading(true);

            $.ajax({
                method: "DELETE",
                url: url,
                dataType: 'json'
            })
                .done(function (res) {
                    ajax_loading(false);
                    malert(res.msg, null, function () {
                        if (res.rs) {
                            window.location.reload();
                        }
                    });
                })
                .fail(function (res) {
                    ajax_loading(false);
                    if (res.status == 403) {
                        malert('Bạn không có quyền thực hiện tính năng này. Vui lòng liên hệ Admin!');
                    }
                });
        });
        return false;
    });
}
function get_districts_by_province(obj_province, select2) {
    var select2 = select2 || false;
    var destination = $(obj_province).attr('data-destination');
    var id = $(destination).attr('data-id');

    var html = '<option value="">'+($(destination).attr('data-placeholder'))+'</option>';

    if (!$(obj_province).val()) {
        $(destination).html(html).val(id).trigger('change');
        if (select2) init_select2(obj_province);
        return;
    }

    $.get(_base_url+'/location/get-districts', {
        province_id: $(obj_province).val(),
        has_asset: $(obj_province).attr('data-asset'),
        status: $(obj_province).attr('data-status'),
    }, function (res) {
        $.each(res.data, function( id, name ) {
            html += '<option value="'+id+'">'+name+'</option>';
        });
        $(destination).html(html).val(id).trigger('change');

        if (select2) init_select2(obj_province);

    }, 'json');
}
function get_wards_by_district(obj_district) {
    var destination = $(obj_district).attr('data-destination');
    var id = $(destination).attr('data-id');

    var html = '<option value="">Chọn Phường / Xã</option>';
    if (!$(obj_district).val()) {
        $(destination).html(html).val(id);
        return;
    }

    $.get('/location/get-wards', {district_id: $(obj_district).val(), has_asset: $(obj_district).attr('data-asset')}, function (res) {
        $.each(res.data, function( id, name ) {
            html += '<option value="'+id+'">'+name+'</option>';
        });
        $(destination).html(html).val(id);
    }, 'json');
}
function get_provinces(destination, has_asset) {
    destination = destination || '#province_id';
    has_asset = has_asset || 0;

    var url = _base_url + '/location/get-provinces';
    var params = {};
    if(has_asset==1) {
        params.has_asset = has_asset;
    }

    $.get(url, params, function (res) {
        var html = '<option value="">'+($(destination).attr('data-placeholder'))+'</option>';
        $.each(res.data, function( id, name ) {
            html += '<option value="'+id+'">'+name+'</option>';
        });

        $(destination).each(function( index ) {
            $(this).html(html).val($(this).attr('data-id')).trigger('change');
        });

    }, 'json');
}
function img_user_default(obj) {
    $(obj).attr('src', _base_url+'/images/user.png');
}
function formatGender(value, row, index) {
    return row.gender=='male'?'Nam':(row.gender=='female'?'Nữ':'Khác');
}
function formatFullname(value, row, index) {
    return (row.salutation=='Mr'?'Ông ':'Bà ') + row.first_name+' '+row.last_name;
}
function formatLink(value, row, index) {
    return '<a href="'+value+'">'+value+'</a>';
}
function get_list_notification() {
    if (!_is_login) {
        return false;
    }

    $.get(_base_url + '/notification/get-list', function (response) {
        if (response.rs) {
            $('.notification_counter .badge').text(response.counter);
            var html = '';
            $.each(response.data, function (i, item) {
                html += '<li><a href="' + item.object_url + '">' +
                    '<span class="image"><img src="' + (item.actor_image ? item.actor_image : '/images/user.png') + '" alt="" onerror="img_user_default(this)"/></span>' +
                    '<span>' +
                    '<span>' + item.actor_display_name + '</span>' +
                    '<span class="time">' + moment(item.created_at).fromNow() + '</span>' +
                    '</span>' +
                    '<span class="message">' + item.object_content + '</span>' +
                    '</a></li>';

                html += '<li role="separator" class="divider"></li>';
            });
            html += '<li><div class="text-center" style="width: 100%;">' +
                '<a><strong>Xem tất cả</strong> <i class="fa fa-angle-right"></i></a>' +
                '</div></li>';

            $('.notification_list').html(html);
        }
    });
}
function add_rule_phone_number() {
    jQuery.validator.addMethod("rgphone", function (value, element) {
        return this.optional(element) || /^(098|095|097|096|0169|0168|0167|0166|0165|0164|0163|0162|090|093|0122|0126|0128|0121|0120|091|094|0123|0124|0125|0127|0129|092|0188|0186|099|0199|086|088|089|087)[0-9]{7}$/.test(value);
    }, "Số điện thoại không đúng định dạng");
}
function init_select2(element) {
    $(element).select2({
        width: "100%",
        placeholder: "Select a state",
        allowClear: true
    });
}
//Date picker
function init_datepicker(element) {
    $(element).datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
}

function init_select_date(element) {
    $(element).datetimepicker({
        format: 'DD-MM-YYYY'
    });
}
function init_options_select(data, element) {
    var html = '';
    $.each(data, function( id, item ) {
        html += '<option value="'+id+'">'+item.name+'</option>';
    });

    $(element).each(function( index ) {
        $(this).html(html).val($(this).attr('data-id'));
    });
}
function init_icheck(obj) {
    if( $(obj).length ) {
        $(obj).iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    }
}
function frm_date(element) {
    var tmp = moment($(element).html());
    $(element).html(tmp.format("DD/MM/YYYY"));
}
var $modal = $('#light_box-modal');
$(document).on( "click", ".light_box_href", function(e) {
    e.preventDefault();

    light_box_modal(this);
});
function light_box_modal(obj) {
    var _id = $(obj).attr('data-id') || 'light_box-modal';
    $('#'+_id).remove();
    $('body').append('<div id="'+_id+'" class="modal fade" data-backdrop="static" style="display: none;"></div>');
    var $modal = $('#'+_id);

    // Display popup add related contact
    var href = $(obj).attr('href');
    // create the backdrop and wait for next modal to be triggered
    ajax_loading(true);
    $modal.load(href, '', function () {
        ajax_loading(false);
        $('.tooltip.fade.in').hide();
        $modal.modal();
    });
}
var _is_reload_page = false;
$(document).on('hidden.bs.modal', function (event) {
    if ($('.modal:visible').length) {
        $('body').addClass('modal-open');
    } else if (_is_reload_page) {
        location.reload();
    }
});

$(document).on( "submit", "#light_box-modal .frmAjaxSubmit", function(e) {
    e.preventDefault();

    ajax_loading(true);
    var frm = $(this);

    $.post( frm.attr('action'), frm.serialize(), function( response ) {
        ajax_loading(false);

        var jdata = null;
        var isJSON = true;
        try
        {
            jdata = $.parseJSON(response);
        }
        catch(err)
        {
            isJSON = false;
        }

        if (!isJSON) {
            $modal.html(response);
            return false;
        }

        if (jdata.result=="OK") {
            malert(jdata.messages, null, function () {
                $modal.modal('hide');
            });
        }
    });
});
function updateUrlParameter(key, value, url){
    if (!url) url = window.location.href;
    var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
        hash;

    if (re.test(url)) {
        if (typeof value !== 'undefined' && value !== null)
            return url.replace(re, '$1' + key + "=" + value + '$2$3');
        else {
            hash = url.split('#');
            url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
            if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                url += '#' + hash[1];
            return url;
        }
    }
    else {
        if (typeof value !== 'undefined' && value !== null) {
            var separator = url.indexOf('?') !== -1 ? '&' : '?';
            hash = url.split('#');
            url = hash[0] + separator + key + '=' + value;
            if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                url += '#' + hash[1];
            return url;
        }
        else
            return url;
    }
}
function ajax_loading(show) {
    if ($('#bg-load').length == 0) {
        $('body').append('<div id="bg-load" style="display: none;"><div class="loader"></div></div>');
    }
    if (show) {
        $('#bg-load').show();
    } else {
        $('#bg-load').hide();
    }
}
function init_rating(obj) {
    var options = {
        language: 'en',
        min: 0,
        stars: 5,
        showClear: false,
        starCaptions: {
            0: '0',
            0.5: '0.5',
            1: '1',
            1.5: '1.5',
            2: '2',
            2.5: '2.5',
            3: '3',
            3.5: '3.5',
            4: '4',
            4.5: '4.5',
            5: '5'
        }
    };
    $(obj).rating(options);
}
function malert_warning(msg, title, callback, sbcallback) {
    malert(msg, title, callback, sbcallback, 'alert-warning');
}
function malert_danger(msg, title, callback, sbcallback) {
    malert(msg, title, callback, sbcallback, 'alert-danger');
}
function malert(msg, title, callback, sbcallback, alert) {
    title = title || 'Thông báo';
    callback = callback || function (e) {};
    alert = alert || 'alert-success';

    if (jQuery("#modal_alert").attr('id') != 'modal_alert') {
        var html = ''+
            '<div class="modal fade" id="modal_alert" role="dialog" aria-labelledby="myModalLabel">' +
            '<div class="modal-dialog" role="document">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            '<h4 class="modal-title">Thông báo</h4>' +
            '</div>' +
            '<div class="modal-body">' +
            '<p>Thành công!</p>' +
            '</div>' +
            '<div class="modal-footer">' +
            '<button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i> Đồng ý</button>' +
            '<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-undo" aria-hidden="true"></i> Thoát</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';

        jQuery( "body" ).append(html);
    }
    $("#modal_alert .btn-success").unbind( "click" );
    if (sbcallback) {
        $("#modal_alert .modal-footer").show();
        $("#modal_alert .btn-success").bind( "click", sbcallback );
    } else {
        $("#modal_alert .modal-footer").hide();
    }

    $("#modal_alert .modal-title").html(title);
    $("#modal_alert .modal-body").html('<div class="alert '+alert+'" role="alert">'+msg+'</div>');

    $('#modal_alert').modal('show');
    $('#modal_alert').on('hidden.bs.modal', callback);
}
function queryParams(params) {
    params.page = $('#page_filter').val();
    return params;
}
function notifyMsg(msg) {
    $.niftyNoty({
        type: 'dark',
        title: 'Thông báo',
        message: msg,
        container: 'floating',
        timer: 5000
    });
}
function show_pnotify(_title, _text, _type) {
    _title = _title || 'Thông báo';
    _type = _type || 'success';

    new PNotify({
        title: _title,
        text: _text,
        type: _type
    });
}
$(function () {

    var browseImage = function() {
        $('.browse-image').click(function () {
            var name = $(this).attr('data-target');
            BrowseServer(name);
        });
    };
    browseImage();
});

function BrowseServer(name) {
    var config = {};
    config.startupPath = 'Images:/avatar/';
    var finder = new CKFinder(config);
    finder.selectActionFunction = SetFileField;
    finder.selectActionData = name;
    finder.callback = function( api ) {
        api.disableFolderContextMenuOption( 'Batch', true );
    };
    finder.popup();
}

function SetFileField(fileUrl, data) {
    var name = '';
    try {
        var hostname = (new URL(fileUrl)).hostname;
        name = fileUrl.split(hostname);
        name = name[name.length - 1];
    } catch (_) {
        name = fileUrl;
    }

    $('#' + data["selectActionData"]).val(name);

    var preview = $('#' + data["selectActionData"]).attr('data-preview');
    if (!preview) preview = '#preview-file-upload';
    $(preview).attr('src', name);

    preview = $('#' + data["selectActionData"]).attr('data-url');
    $(preview).val('');
}
function active_menu(link) {
    $("#navbar a[href*='"+link+"']").closest('li').addClass('active');
}