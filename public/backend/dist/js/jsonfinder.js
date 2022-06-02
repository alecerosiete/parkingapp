
/* finders */

function find_rates_from_vehicles(onresult, vehicleType) {
    $.ajax({
        url: '/admin.php/json_finder/find_rates_from_vehicles',
        type: 'POST',
        data: {
            vehicleType: vehicleType
        },
        dataType: "json"
    }).done(onresult);
}


function find_calculate_result(onresult, params) {
    $.ajax({
        url: '/admin.php/json_finder/calculate',
        type: 'POST',
        data: params,
        dataType: "json"
    }).done(onresult);
    
}

/* fillers */

function fill_with_rate(recipientId, vehicleType, pre) {
    var onresult = function (result) {
        htmlFillSelect(recipientId, result, pre);
    };
    find_rates_from_vehicles(onresult, vehicleType);

}


function fill_with_params(recipientId, params) {
    var onresult = function (result) {
        htmlFillContent(recipientId, result);
    };
    find_calculate_result(onresult, params);
}
/* html helpers */

function htmlFillSelect(elementId, result, pre) {
    var html = "";
    pre = pre ? pre : "";
    $.each(result, function (k, v) {
        html += htmlOption(k, v, pre);
    });
    if (html.length > 0) {
        $("#" + elementId).html(html);
    } else {
        html += htmlOption("", "Sin valores disponibles");
        $("#" + elementId).html(html);
    }
}

function htmlFillContent(elementId, result, pre) {
    var html = "";
    pre = pre ? pre : "";
    if (result['error'].length > 0) {
        $.notify({
            icon: 'glyphicon glyphicon-alert',
            message: result['error']
        }, {
            type: 'error',
            mouse_over: 'pause',
            delay: 7000,
            animate: {
                enter: 'animated shake',
                exit: 'animated fadeOutUp'
            }

        });
        return false;
    }
    $("#in").text(dateFormat_hhmmss_ddmmaa(result['in']));
    $("#out").text(dateFormat_hhmmss_ddmmaa(result['out']));
    $("#days").text(result['days']);
    $("#hours").text(result['hours']);
    $("#minutes").text(result['minutes']);
    $("#amount").text(priceFormat(result['totalToPay']));
    $("#insertId").val(result['insertId']);
    $("#detail").modal("show");
    return;
    /*
     if (html.length > 0) {
     $("#" + elementId).html(html);
     }else {
     html = "Sin valores disponibles";
     $("#" + elementId).html(html);
     }
     */
}

function dateFormat_hhmmss_ddmmaa(d){
    var date = d;
    var dateSplit = date.split(" ");
    var dateSplit2 = dateSplit[0].split("-");
    var formattedDate = dateSplit2.reverse().join('-');   // 26-06-2013
    return dateSplit[1]+" "+formattedDate;
    
}

function priceFormat(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
}

function htmlFillCheck(elementId, result) {
    var html = "";
    $.each(result, function (k, v) {
        html += htmlCheck(k, v);
    });
    $("#" + elementId).html(html);
}

function htmlFillText(elementId, result) {
    $("#" + elementId).val(result);
}

function htmlFillTextP(elementId, result) {
    $("#" + elementId).html(result);
}

function htmlFillPlaceholder(elementId, result) {
    document.getElementById(elementId).placeholder = result;
}

function htmlOption(key, value, pre) {
    return "<option value='" + key + "' " + (key == pre ? 'selected' : '') + ">" + value + "</option>";
}

function htmlCheck(key, value) {
    return "<input id=" + key + " name='countries[]' type='checkbox' checked value=" + key + ">" + value + "<br>";
}
