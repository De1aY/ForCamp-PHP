function ClickListener() {
    var Encode = $('#encode').val();
    var Decode = $('#decode').val();
    Request(Encode, Decode);
}

function Request(Enc, Dec){
    $.get("../../temp.php", {encode: Enc, decode: Dec}, function (data) {
        $('#answer').text(data);
    });
}

$('document').ready(function () {
    $('#submit').click(ClickListener);
});