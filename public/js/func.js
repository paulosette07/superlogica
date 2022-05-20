/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

setTimeout(function () {
    $("#popBox").fadeOut();
}, 3000);

function deleteConfirm(id, callback) {
    if (confirm("Você deseja apagar o registro?")) {
        $(location).attr('href', callback + ".php?action=delete&key=" + id);
    } else {
        return false;
    }
}

function formatReal(valor)
{
    var valor = valor;

    valor = valor + '';
    valor = parseInt(valor.replace(/[\D]+/g, ''));
    valor = valor + '';
    valor = valor.replace(/([0-9]{2})$/g, ",$1");

    if (valor.length > 6) {
        valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    }

    return valor;
}

function float2moeda(num) {
    if(isNaN(num)) {
        return '0,00';
    }
    x = 0;
    if (num < 0) {
        num = Math.abs(num);
        x = 1;
    }
    if (isNaN(num))
        num = "0";
    cents = Math.floor((num * 100 + 0.5) % 100);
    num = Math.floor((num * 100 + 0.5) / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + '.'
                + num.substring(num.length - (4 * i + 3));
    ret = num + ',' + cents;
    if (x == 1)
        ret = ' - ' + ret;
    return ret;
}

function moeda2float(moeda) {
    if(moeda == '') {
        return '0';
    }
    moeda = moeda.replace(".", "");
    moeda = moeda.replace(",", ".");
    return parseFloat(moeda);
}