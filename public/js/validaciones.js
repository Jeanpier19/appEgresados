

function showInvalid(msg,input){
    var _isValid = input.className.split(' ');
    if (_isValid[_isValid.length - 1] == 'invalid' || _isValid[_isValid.length - 1] == 'valid') {
        _isValid.pop();
        input.className = _isValid[0];
    }
    input.className = input.className + " invalid";

    if ($('#' + input.id).siblings('em') != null) {
        $('#' + input.id).siblings('em').remove();
    }
    $('#' + input.id).after('<em class="text-error">' + msg + '</em>');
    return false;
}

function showInvalidSelect(msg, input) {
    var _isValid = input.className.split(' ');
    if (_isValid[_isValid.length - 1] == 'invalid-select') {
        _isValid.pop();
        input.className = _isValid[0];
    }
    input.className = input.className + " invalid-select";

    if ($('#' + input.id).siblings('em') != null) {
        $('#' + input.id).siblings('em').remove();
    }
    $('#' + input.id).after('<em class="text-error">' + msg + '</em>');
    return false;
}

function showValid(input) {
    $('#' + input.id).siblings('em').remove();
    var _isValid = input.className.split(' ');
    if (_isValid[_isValid.length - 1] == 'invalid' || _isValid[_isValid.length - 1] == 'valid') {
        _isValid.pop();
        input.className = _isValid[0];
    }
    input.className = input.className + " valid";
    return true;
}

function showNormal(...inputs) {
    for (let i = 0; i < inputs.length;i++){
        //
        var input = inputs[i];
        $('#' + input.id).siblings('em').remove();
        var _isValid = input.className.split(' ');
        if (_isValid[_isValid.length - 1] == 'invalid' || _isValid[_isValid.length - 1] == 'valid' || _isValid[_isValid.length - 1] == 'invalid-select') {
            _isValid.pop();
            input.className = _isValid[0];
        }
        //
    }
}

function MaxMinCadenas(idButton, max, min, input, req = false) {
    const boton = document.getElementById(idButton);
    var tempValue = input.value;
    if ($.trim(tempValue) == '') {
        if (req) {
            boton.disabled = true;
            msg = "Este campo es obligatorio.";
            showInvalid(msg, input);
            return false;
        } else {
            showNormal(input);
        }
        } else {
            if ($.trim(tempValue).length >= min) {
                if ($.trim(tempValue).length <= max) {
                    showValid(input);
                    boton.disabled = false;
                    return true;
                } else {
                    msg = "Por favor no escriba más de " + max + " carácteres";
                    showInvalid(msg, input);
                    boton.disabled = true;
                    return false;
                }
            } else {
                msg = "Por favor no escriba menos de " + min + " carácteres";
                showInvalid(msg, input);
                boton.disabled = true;
                return false;
            }
        }
}


// function ResetHTMLPermiso() {
//     showNormal(document.getElementById('inNombre'), document.getElementById('inDescripcion'));
//     const boton = document.getElementById('ModalUsuarioAceptar');
//     boton.disabled = false;
// }

function ResetHTMLAlumno() {
    $('#form-alumno')[0].reset();
    showNormal(document.getElementById('num_documento'), document.getElementById('apaterno'),document.getElementById('amaterno'),document.getElementById('anombres'),document.getElementById('direccion'),document.getElementById('correo'),document.getElementById('telefono'),document.getElementById('celular'));
    const boton = document.getElementById('send-alumno');
    boton.disabled = false;
}

function ResetHTMLEmpresa() {
    showNormal(document.getElementById('enombre'),document.getElementById('ecorreo'),document.getElementById('etelefono'),document.getElementById('ecelular'));
    const boton = document.getElementById('send-empresa');
    boton.disabled = false;
}

function ResetHTMLCurso() {
    showNormal(document.getElementById('titulo'),document.getElementById('descripcion'),document.getElementById('creditos'),document.getElementById('horas'));
    const boton = document.getElementById('send-curso');
    boton.disabled = false;
}

function ResetHTMLCapacitacion() {
    showNormal(document.getElementById('cdescripcion'),document.getElementById('cfecha_inicio'),document.getElementById('cfecha_fin'));
    const boton = document.getElementById('send-capacitacion');
    boton.disabled = false;
}

function ResetHTMLExperiencia() {
    showNormal(document.getElementById('efecha_inicio'),document.getElementById('efecha_fin'),document.getElementById('reconocimientos',document.getElementById('satisfaccion'),document.getElementById('estado')));
    const boton = document.getElementById('send-experiencia');
    boton.disabled = false;
}

function ResetHTMLNecesidad(){
    showNormal(document.getElementById('descripcion'),document.getElementById('fecha'),document.getElementById('horas'));
    const boton = document.getElementById('send-necesidad');
    boton.disabled = false;
}

function IsEmpty(button, ...inputs) {
    var error = 0;
    var radval = 0;
    for (let i = 0; i < inputs.length; i++) {
        var tempValue = inputs[i].value;
        var params = inputs[i].className.split(" ");
        if ($.trim(tempValue) == '' && $("#" + inputs[i].id).siblings('strong').children('span').hasClass("is-required")) {
            // if (inputs[i].id == 'radio-group') {
            // Mejora
            if (inputs[i].id.includes('radio-group')) {
                var radios = $("#" + inputs[i].id).children('div').children('input');
                for (let j = 0; j < radios.length; j++) {
                    if (radios[j].checked) {
                        radval++;
                    }
                }
                if (radval != 1) {
                    msg = "Por favor seleccione una opción.";
                    button.disabled = true;
                    showInvalid(msg, inputs[i]);
                    error++
                }
            } else if (inputs[i].tagName == 'SELECT') {
                msg = "Por favor seleccione una opción.";
                button.disabled = true;
                showInvalidSelect(msg, inputs[i]);
                error++;
            } else {
                msg = "Por favor complete este campo.";
                button.disabled = true;
                showInvalid(msg, inputs[i]);
                error++;
            }
        }
        if (params[params.length - 1] == "invalid") {
            button.disabled = true;
            error++;
        }
    }
    if (error == 0) {
        button.disabled = false;
        return true;
    } else{
        return false;
    }
}

function filter(__val__, type) {
    switch (type) {
        case 'letra':
            var preg = new RegExp("/^[A-Za-z\s]+$/g");
            if (preg.test(__val__) === true) {
                return true;
            } else {
                return false;
            }
            break;
        case 'correo':
            var preg = new RegExp("^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$");
            if (preg.test(__val__) === true) {
                return true;
            } else {
                return false;
            }
            break;
        case 'decimales':
            var preg = new RegExp("^[+-]?[0-9]{1,9}(?:.[0-9]{1,10})?$");
            if (preg.test(__val__) === true) {
                return true;
            } else {
                return false;
            }
            break;
        case 'fechas':
            var preg = new RegExp("^(?:3[01]|[12][0-9]|0?[1-9])([\-/.])(0?[1-9]|1[1-2])\1\d{4}$");
            if (preg.test(__val__) === true) {
                return true;
            } else {
                return false;
            }
            break;
        default:
            return false;
}
}

function SoloLetras(idButton, evt, input, req = false) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    const boton = document.getElementById(idButton);
    var tempValue = input.value;
    if ($.trim(tempValue) == '') {
        if (req) {
            boton.disabled = true;
            msg = "Este campo es obligatorio.";
            showInvalid(msg, input);
        } else {
            showNormal(input);
        }
    }
    var key = window.event ? evt.which : evt.keyCode;
    //console.log(key);
    var chark = String.fromCharCode(key);
    var tempValue = input.value + chark;
    if (key >= 97 && key <= 122 || key>=65 && key<=90) {
        if (filter(tempValue,'letra')) {
            return false;
        } else {
            return true;
        }
    } else {
        if (key === 8 || key === 16 || key === 13 || key === 32 || key === 225 || key === 180 || key === 252 || key == 243 || key === 250 || key === 237 || key === 235 || key === 233 || key === 176 || key===241 ) {
            return true;
        } else {
            return false;
        }
    }
}
function SoloNumeros(idButton, evt, input, req = false) {
    const boton = document.getElementById(idButton);
    var tempValue = input.value;
    if ($.trim(tempValue) == '') {
        if (req) {
            boton.disabled = true;
            msg = "Este campo es obligatorio.";
            showInvalid(msg, input);
        } else {
            showNormal(input);
        }
    }
    var key = window.event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value + chark;
    //console.log(key);
    if (key >= 48 && key <= 57) {
        return true;
    } else {
        if (key === 8 || key === 13) {
            return true;
        } else {
            return false;
        }
    }
}


function InputCorreo(idButton,input,max,min, req = false) {
    const boton = document.getElementById(idButton);
    var tempValue = input.value;
    if ($.trim(tempValue) == '') {
        if (req) {
            boton.disabled = true;
            msg = "Este campo es obligatorio.";
            showInvalid(msg, input);
        } else {
            showNormal(input);
        }
    }
    if (MaxMinCadenas(idButton, max, min, input, req)) {

        if (filter(tempValue,'correo')) {
            showValid(input);
            boton.disabled = false;
            return true;
        } else {
            msg = "No se está introduciendo un correo válido.";
            showInvalid(msg, input);
            boton.disabled = true;
            return false;
        }
    }
}

function NumConDecimales(idButton, evt, input, req = false) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    const boton = document.getElementById(idButton);
    var tempValue = input.value;
    if ($.trim(tempValue) == '') {
        if (req) {
            boton.disabled = true;
            msg = "Este campo es obligatorio.";
            showInvalid(msg, input);
        } else {
            showNormal(input);
        }
    }
    var key = window.event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value + chark;
    //console.log(key);
    if ((key >= 48 && key <= 57) || key === 46 || key === 45) {
        return true;
    } else {
        if (key === 8 || key === 13) {
            return true;
        } else {
            return false;
        }
    }
}

function InputLat(idButton, input, max, min, req = false) {
    const boton = document.getElementById(idButton);
    var tempValue = input.value;
    if ($.trim(tempValue) == '') {
        if (req) {
            boton.disabled = true;
            msg = "Este campo es obligatorio.";
            showInvalid(msg, input);
        } else {
            showNormal(input);
        }
    }
    if (MaxMinCadenas(idButton, max, min, input, req)) {

        if (filter(tempValue, 'decimales')) {
            showValid(input);
            boton.disabled = false;
            return true;
        } else {
            msg = "No se está introduciendo un numero válido.";
            showInvalid(msg, input);
            boton.disabled = true;
            return false;
        }
    }
}

function valRadioButton(button, salidaOut) {
        showNormal(salidaOut);
        button.disabled == false;
}

function dateVal(button, input, req = false) {
    if (req) {
        if (input.value == '') {
            msg = "Seleccione una fecha.";
            showInvalid(msg, input);
            button.disabled = true;
        } else {
            showNormal(input);
            button.disabled = false;
        }
    } else {
        showNormal(input);
    }
}

function seleVal(button, input, req = false) {
    //console.log(input.tagName);
    if (req) {
        if (input.value == '') {
            msg = "Por favor seleccione una opcion.";
            //showInvalid(msg, input);
            var _isValid = input.className.split(' ');
            if (_isValid[_isValid.length - 1] == 'invalid-select') {
                _isValid.pop();
                input.className = _isValid[0];
            }
            input.className = input.className + " invalid-select";

            if ($('#' + input.id).siblings('em') != null) {
                $('#' + input.id).siblings('em').remove();
            }
            $('#' + input.id).after('<em class="text-error">' + msg + '</em>');
            button.disabled = true;
        } else {
            showNormal(input);
            button.disabled = false;
        }
    } else {
        //showNormal(input);
        $('#' + input.id).siblings('em').remove();
        var _isValid = input.className.split(' ');
        if (_isValid[_isValid.length - 1] == 'invalid-select') {
            _isValid.pop();
            input.className = _isValid[0];
        }
    }
}

function SoloLetraNumeros(idButton, evt, input, req = false) {
    const boton = document.getElementById(idButton);
    var tempValue = input.value;
    if ($.trim(tempValue) == '') {
        if (req) {
            boton.disabled = true;
            msg = "Este campo es obligatorio.";
            showInvalid(msg, input);
        } else {
            showNormal(input);
        }
    }
    var key = window.event ? evt.which : evt.keyCode;
    //console.log(key);
    var chark = String.fromCharCode(key);
    var tempValue = input.value + chark;
    if (key >= 97 && key <= 122 || key >= 65 && key <= 90 || key>=48 && key<= 57) {
        return true;
    } else {
        if (key === 8 || key === 16 || key === 13 || key === 32 || key === 225 || key === 180 || key === 252 || key === 233 || key == 243 || key === 250 || key === 237 || key === 235 || key === 45 || key === 241 || key === 47 || key === 46) {
            return true;
        } else {
            return false;
        }
    }
}

function MaxMinCadenas2(idButton, max, min, input, req = false) {
    const boton = document.getElementById(idButton);
    var tempValue = input.value;
    if ($.trim(tempValue) == '') {
        if (req) {
            boton.disabled = true;
            msg = "Este campo debe poseer el siguiente formato: INF001-2021-MTC/29.01.TRUJILLO.A";
            showInvalid(msg, input);
            return false;
        } else {
            showNormal(input);
        }
    } else {
        if ($.trim(tempValue).length >= min) {
            if ($.trim(tempValue).length <= max) {
                showValid(input);
                boton.disabled = false;
                return true;
            } else {
                msg = "Por favor no escriba más de " + max + " carácteres";
                showInvalid(msg, input);
                boton.disabled = true;
                return false;
            }
        } else {
            msg = "Este campo debe poseer el siguiente formato: INF001-2021-MTC/290.01.TRUJILLO.A";
            showInvalid(msg, input);
            boton.disabled = true;
            return false;
        }
    }
}
