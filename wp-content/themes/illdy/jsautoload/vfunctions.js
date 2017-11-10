/**
 * Created by tiago on 09/04/2017.
 */

$(document).ready(function () {
    openResponsiveMenu();
});

function validateInputs(id, text) {
    id.text('* ' + text);
    id.css('display', 'inline');
}

function hideValidation(id) {
    id.text('');
    id.css('display', 'hidden');
}

//random string
function randomize() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 15; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

$(document).keyup(function (e) {
    if (e.keyCode == 27) { // escape key maps to keycode `27`
        $('div.login_overlay').remove();
        $('#loginJQ').hide();
        $('div.registar_overlay').remove();
        $('#registarJQ').hide();
        $('div.forgotJQ_overlay').remove();
        $('#forgotJQ').hide();
        $('div.updateAssociate_overlay').remove();
        $('#updateAssociate').hide();
        $('div.profile_overlay').remove();
        $('#profile-information').hide();
    }
});


function openResponsiveMenu() {
    $('.open-responsive-menu').click(function () {
        $('.responsive-menu').toggle('slow', function () {
            $(this).toggleClass('active');
        });
    });
}

function getMonth(month) {
    var foo;
    if (month == '01') {
        foo = "Jan";
    } else if (month == '02') {
        foo = "Fev";
    } else if (month == '03') {
        foo = "Mar";
    } else if (month == '04') {
        foo = "Abr";
    } else if (month == '05') {
        foo = "Mai";
    } else if (month == '06') {
        foo = "Jun";
    } else if (month == '07') {
        foo = "Jul";
    } else if (month == '08') {
        foo = "Ago";
    } else if (month == '09') {
        foo = "Set";
    } else if (month == '10') {
        foo = "Out";
    } else if (month == '11') {
        foo = "Nov";
    } else if (month == '12') {
        foo = "Dez";
    }
    return foo;
}

function countWords(str) {
    return (str.replace(/[^A-Z]/gi, "").length);
}

function agenda() {
    $.ajax({
        type: 'POST',
        url: "/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'events',
            function: 'getEvent'
        },
        statusCode: {
            200: function (response) {
                var currentYear = new Date().getFullYear();
                var input = [];
                for (i = 0; i < response.length; i++) {
                    var dateStart = response[i].data_inicio;
                    var dateEnd = response[i].data_fim;
                    var yearStart = dateStart.substr(6, 4);
                    var monthStart = dateStart.substr(3, 2);
                    var dayStart = dateStart.substr(0, 2);
                    var yearFinish = dateEnd.substr(6, 4);
                    var monthFinish = dateEnd.substr(3, 2);
                    var dayFinish = dateEnd.substr(0, 2);
                    input.push({
                        idEvent: response[i].idEvento,
                        name: response[i].designacao,
                        location: response[i].local,
                        speaker: response[i].orador,
                        price: response[i].preco,
                        description: response[i].descricao,
                        typeEvent: response[i].idTipoEvento,
						typeEventDesig: response[i].desig,
                        startDate: new Date(yearStart, monthStart - 1, dayStart),
                        endDate: new Date(yearFinish, monthFinish - 1, dayFinish),
                        color: response[i].color,
                        vacancies: response[i].vagas,
                        pageID: response[i].pageID,
                        hours: response[i].hora,
                        duration: response[i].duracao,
                        link: response[i].link,
                        associatePrice: response[i].preco_associado,
                        open: response[i].aberto
                    });
                }

                $('#calendar').calendar({
                    enableContextMenu: true,
                    enableRangeSelection: true,
                    contextMenuItems: [
                        {
                            text: 'Inscrição',
                            click: addRegistration
                        }
                    ],
                    mouseOnDay: function (e) {
                        if (e.events.length > 0) {
                            var content = '';

                            for (var i in e.events) {
                                content += '<div class="event-tooltip-content">'
                                    + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
									+ '<div class="event-name" style="color:black">' + e.events[i].typeEventDesig + '</div>'
                                    + '<div class="event-location">' + e.events[i].location + '</div>'
                                '</div>';
                            }

                            $(e.element).popover({
                                trigger: 'manual',
                                container: 'body',
                                html: true,
                                content: content
                            });

                            $(e.element).popover('show');
                        }
                    },
                    mouseOutDay: function (e) {
                        if (e.events.length > 0) {
                            $(e.element).popover('hide');
                        }
                    },
                    dayContextMenu: function (e) {
                        $(e.element).popover('hide');
                    },
                    dataSource: input
                });
            }
        },
        500: function () {
            window.alert('Erro na BD');
        }
    });
}

function addRegistration(event) {
    //Get today´s date
    var today = new Date();
    if (event.startDate > today && event.open == 1) {
        var idEvent = event.idEvent;
        $('#event-id-reg').val(event.idEvent);
        var associate;
        var id;
        if ($('#user-type').val() == 2) {
            associate = $('#hiddenAssociateId').val();
            id = 0;
            $.ajax({
                type: 'POST',
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'registration',
                    function: 'addRegistration',
                    id: id,
                    idEvent: idEvent,
                    idAssociate: associate,
                },
                statusCode: {
                    201: function () {
                        $('#registration-modal').modal('hide');
						alert('Inscrição efetuada com sucesso!');
                        validateInputs($('#regist-validate-msg'), 'Inscrição efetuada com sucesso!');
                        hideValidation($('#regist-email-msg'));
                        hideValidation($('#regist-error-msg'));
                    },
                    500: function (response) {
                        $('#registration-modal').modal('hide');
                        console.log(response.msg);
                    },
                    501: function () {
                        validateInputs($('#regist-email-msg'), 'Introduza um email válido!');
                    },
                    502: function () {
                        $('#registration-modal').modal('hide');
						alert('Já está inscrito!');
                        hideValidation($('#regist-validate-msg'));
                        validateInputs($('#regist-error-msg'), 'Já se inscreveu neste evento!');
                    }
                }
            });
        } else {
            associate = 0;
            id = 1;
            $('#registration-modal').modal('show');
        }
    } else {
        alert('Não se pode inscrever neste evento');
    }
}
