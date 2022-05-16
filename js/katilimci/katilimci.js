function onSelectChangeUniversite() {
    var deger = document.getElementById("k_universite").value;
    if (deger!=null) {
        document.getElementById('k_fakulte').style.display = 'block';
    } else {
        document.getElementById('k_fakulte').style.display = 'none';
    }
}

function addSpaces(initial){
    initial.replace("/([0-9]{3})/","\1 ");
    initial.replace("/[0-9]{3} ([0-9]{3})/","\1 ");
    return initial;
}

$('#k_telefon').inputmask("(599) 999-99-99");