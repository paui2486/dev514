CKFinder.setupCKEditor();
var editor = CKEDITOR.replace( 'content', {
    language : 'zh',
    height : 500,
    allowedContent : true,
    extraPlugins: 'autosave',
    autosave_SaveKey: 'autosaveKey',
    autosave_NotOlderThen : 10,
    filebrowserBrowseUrl : '/assets/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : '/assets/ckfinder/ckfinder.html?Type=Image',
    filebrowserUploadUrl : '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserImageUploadUrl : '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Image',

    removeButtons : 'BidiLtr,BidiRtl,Anchor,Maximize,Styles,Paste,PasteText,PasteFromWord,Cut,Copy,Source,Save,NewPage,DocProps,Print,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Blockquote,CreateDiv,Language,Flash,Iframe,',

    font_names : 'Arial;Arial Black;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana;新細明體;細明體;標楷體;微軟正黑體',
    fontSize_sizes : '8/8px;9/9px;10/10px;11/11px;12/12px;13/13px;14/14px;15/15px;16/16px;17/17px;18/18px;19/19px;20/20px;21/21px;22/22px;23/23px;24/24px;25/25px;26/26px;28/28px;36/36px;48/48px;72/72px'
});

$('input.time-picker').on('focus', picker);
$("button.btn-clone").on('click', clone);
$("button.btn-del").on('click', remove);

$('#input-who').selectize({
    maxItems: 5,
    create: false,
});

$.fn.modal.Constructor.prototype.enforceFocus = function() {
    modal_this = this
    $(document).on('focusin.modal', function (e) {
        if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
        && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select')
        && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
            modal_this.$element.focus()
        }
    })
};

var minDate = moment().format("YYYY-MM-DD");

$(".act_date").datetimepicker({
    minDate: moment(),
    format: 'YYYY-MM-DD',
});

$("input[name=activity_start_date]").on("dp.change", function (e) {
    $('input[name="activity_end_date"]').data("DateTimePicker").minDate(e.date);
});

$(".act_time").val("00:00");
$(".act_time").datetimepicker({
    minDate: moment({hour: 0, minute: 0}),
    stepping: 10,
    format: 'HH:mm',
});

if ($("input[name='activity_start_date']").val() == $("input[name=activity_end_date]").val()) {
    $("input[name='activity_start_time']").on("dp.change", function (e) {
        $('input[name="activity_end_time"]').data("DateTimePicker").minDate(e.date);
    });
}

$("input[name='activity_end_time']").on("dp.change", function (e) {
    var start_time_arr = $("input[name='activity_start_time']").val().split(':');
    var end_time_arr   = $("input[name='activity_end_time']").val().split(':');
    var timecost       = Math.floor(end_time_arr[0]) - Math.floor(start_time_arr[0]) +
                            Math.round((Math.floor(end_time_arr[1]) - Math.floor(start_time_arr[1])) / 60 * 10) / 10;
    $('input[name="time_range"]').val(timecost);
});

$(document).on("keypress", "form", function(event) {
    return event.keyCode != 13;
});

$('form').on('submit', function() {
    CKEDITOR.instances.content.updateElement();
});

function clone() {
    var regex = /\[(\d*)/i;
    var id_next = $(".form-ticket").length;
    $(this).parents(".form-ticket").clone()
        .appendTo(".ticket-area")
        .attr("id", "ticket" + (id_next + 1) )
        .find("*")
        .each(function() {
            var name = $(this).attr('name');
            if (typeof name !== "undefined") {
                var cg_name = name.replace(regex, '[' + id_next);
                $(this).attr('name', cg_name);
            }
        })
        .on('focus', 'input.time-picker', picker)
        .on('focus', 'input.act_date', pickerDate)
        .on('focus', 'input.act_time', pickerTime)
        .on('click', 'button.btn-clone', clone)
        .on('click', 'button.btn-del', remove);
}

var maxDate = null;

function pickerDate() {
    $(this).datetimepicker({
        minDate: moment(),
        maxDate: $('input[name="activity_end_date"]').val(),
        format: 'YYYY-MM-DD',
    });
}

function pickerTime() {
    $(this).datetimepicker({
        minDate: moment({hour: 0, minute: 0}),
        stepping: 10,
        format: 'HH:mm',
    });
}

function picker() {
    var maxday = false;
    if ($(this).attr('name') != "activity_range") {
        maxday = maxDate;
    }

    $(this).daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
            format: 'YYYY-MM-DD H:mm',
            separator: '   -   '
        },
        minDate: 'today',
        maxDate: maxday
    });
}

function remove() {
    var count = $(".form-ticket").length;
    if (count === 1){
        alert("只剩下一張票卷！請勿刪除！！感謝");
    } else {
        $(this).parents(".form-ticket").remove();
    }
}
