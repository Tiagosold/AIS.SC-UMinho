/**
 * Created by Vitor on 24/04/2017.
 */

// IIFE - Immediately Invoked Function Expression
(function (yourcode) {

    // The global jQuery object is passed as a parameter
    yourcode(window.jQuery, window, document);

}(function ($, window, document) {

        // The $ is now locally scoped
        $(function () {

            //Calendar opens
            var calendar = $('#calendar-appears');
            var view = $('#events-view');
            calendar.css("display", "none");
            $("#events-view").on('click', function () {
                if (calendar.css('display') == 'inline-block') {
                    calendar.css('display', "none");
                } else {
                    var partners = $('#open-partners');
                    var associates = $('#open-associates');
                    var registrations = $('#open-registrations');
                    var transactions = $('#open-transactions');
                    partners.css('display', "none");
                    associates.css('display', 'none');
                    registrations.css("display", "none");
                    transactions.css("display", "none");
                    getEvents();
                }
            });
            //

            //Delete event
            var deleteEv = $('#delete-event');
            deleteEv.click('click', function () {
                deleteEvent();
            });
            //

            //Save Event
            var saveEv = $('#save-event');
            saveEv.on('click', function () {
                saveEvent();
            });
            //

            // Type event color
            $('#type-event-modal select[name="type-event-desig"]').change(function () {
                $.ajax({
                    type: 'POST',
                    url: "/wp-content/themes/illdy/bd/",
                    dataType: 'json',
                    data: {
                        object: 'events',
                        function: 'typeEvent',
                        id: 2,
                        typeEvent: $('#type-event-modal select[name="type-event-desig"]').val()
                    },
                    statusCode: {
                        200: function (response) {
                            $('#type-event-modal input[name="type-event-color"]').val(response[0].color);
                        },
                        500: function () {
                            alert('Error');
                        }
                    }
                });
            });

            //Save type event
            $('#save-type-event').on('click', function () {
                var idType = $('#type-event-modal input[name="type-event-index"]').val();
                var id = 0;
                var desig = $('#type-event-modal input[name="type-event-desig-in"]').val();
                var color = $('#type-event-color').val();
                if (idType != '') {
                    id = 2;
                } else {
                    id = 1;
                }
                saveTypeEvent(idType, id, desig, color);
            });
            //
            var saveType = $('#save-type-event');
            var typeEvent = $('#type-event-color');
            var deleteType = $('#delete-type-event');
            var editType = $('#edit-type-event');
            var createType = $('#create-type-event');

            //Edit Type Event
            $('#edit-type-event').on('click', function () {
                var text = $("#type-event-modal select[name='type-event-desig'] option:selected").html();
                var id = $('#type-event-desig').val();
                var desigmsg = $('#desigmsg');
                if (text != null) {
                    hideValidation(desigmsg);
                    $('#type-event-modal select[name="type-event-desig"]').css('display', 'none');
                    $('#type-event-modal input[name=type-event-desig-in]').css('display', 'inline');
                    $('#type-event-modal input[name=type-event-desig-in]').val(text);
                    $('#type-event-modal input[name="type-event-index"]').val(id);
                    editType.css('display', 'none');
                    createType.css('display', 'none');
                    typeEvent.css('display', 'inline');
                    deleteType.css('display', 'inline-block');
                    saveType.css('display', 'inline-block');
                } else {
                    validateInputs(desigmsg, 'Selecione uma designação!');

                }
            });

            //Create type event
            createType.on('click', function () {
                $('#type-event-modal input[name=type-event-desig-in]').val('');
                $('#type-event-modal select[name="type-event-desig"]').css('display', 'none');
                $('#type-event-modal input[name=type-event-desig-in]').css('display', 'inline');
                editType.css('display', 'none');
                createType.css('display', 'none');
                typeEvent.val('#000000');
                typeEvent.css('display', 'inline');
                saveType.css('display', 'inline-block');
            });

            //Delete type Event
            deleteType.on('click', function () {
                deleteTypeEvent();
            });

            //Open Registrations
            $('#open-regist').on('click', function () {
                $.ajax({
                    type: 'POST',
                    url: "/wp-content/themes/illdy/bd/",
                    dataType: 'json',
                    data: {
                        object: 'events',
                        function: 'changeRegistrations',
                        idEvent: $('#event-modal input[name="event-index"]').val(),
                        place: $('#event-modal input[name="event-location"]').val(),
                        startDate: $('#event-modal input[name="event-start-date"]').datepicker({dateFormat: 'dd/mm/yy'}).val(),
                        speaker: $('#event-modal input[name="event-speaker"]').val(),
                        price: $('#event-modal input[name="event-price"]').val(),
                        priceAssociate: $('#event-modal input[name="event-price-associate"]').val(),
                        description: $('#event-modal input[name="event-description"]').val(),
                        vacancies: $('#event-modal input[name="event-vacancies"]').val(),
                        hours: $('#event-modal input[name="event-hour"]').val(),
                        duration: $('#event-modal input[name="event-duration"]').val(),
                        pageID: $('#event-modal input[name="event-page-id"]').val(),
                        link: $('#event-modal input[name="event-link"]').val(),
                        open: 1
                    },
                    statusCode: {
                        201: function () {
                            $('#event-modal').modal('hide');
                            getEvents();
                        },
                        500: function () {
                            alert(response.msg);

                        }
                    }
                });
            });

            //Close Registrations
            $('#close-registrations').on('click', function () {
                $.ajax({
                    type: 'POST',
                    url: "/wp-content/themes/illdy/bd/",
                    dataType: 'json',
                    data: {
                        object: 'events',
                        function: 'changeRegistrations',
                        idEvent: $('#event-modal input[name="event-index"]').val(),
                        place: $('#event-modal input[name="event-location"]').val(),
                        startDate: $('#event-modal input[name="event-start-date"]').datepicker({dateFormat: 'dd/mm/yy'}).val(),
                        speaker: $('#event-modal input[name="event-speaker"]').val(),
                        price: $('#event-modal input[name="event-price"]').val(),
                        priceAssociate: $('#event-modal input[name="event-price-associate"]').val(),
                        description: $('#event-modal input[name="event-description"]').val(),
                        vacancies: $('#event-modal input[name="event-vacancies"]').val(),
                        hours: $('#event-modal input[name="event-hour"]').val(),
                        duration: $('#event-modal input[name="event-duration"]').val(),
                        pageID: $('#event-modal input[name="event-page-id"]').val(),
                        link: $('#event-modal input[name="event-link"]').val(),
                        open: 0
                    },
                    statusCode: {
                        201: function () {
                            $('#event-modal').modal('hide');
                            getEvents();
                        },
                        500: function (response) {
                            alert(response.msg);
                        }
                    }
                });
            });

        });

        function addEditEvents(params) {
            $.ajax({
                type: 'POST',
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: params,
                statusCode: {
                    201: function (response) {
                        getEvents();
						updateLayout();
                    },
                    500: function (response) {
                        console.log(response.msg);
                    }
                }

            });
        }

        function getEvents() {
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
                        $.each(response, function (index, value) {
                            var dateStart = value.data_inicio;
                            var dateEnd = value.data_fim;
                            var yearStart = dateStart.substr(6, 4);
                            var monthStart = dateStart.substr(3, 2);
                            var dayStart = dateStart.substr(0, 2);
                            var yearFinish = dateEnd.substr(6, 4);
                            var monthFinish = dateEnd.substr(3, 2);
                            var dayFinish = dateEnd.substr(0, 2);
                            input.push({
                                idEvent: value.idEvento,
                                name: value.designacao,
                                location: value.local,
                                speaker: value.orador,
                                price: value.preco,
                                description: value.descricao,
                                typeEvent: value.idTipoEvento,
                                startDate: new Date(yearStart, monthStart - 1, dayStart),
                                endDate: new Date(yearFinish, monthFinish - 1, dayFinish),
                                color: value.color,
                                vacancies: value.vagas,
                                pageID: value.pageID,
                                hours: value.hora,
                                duration: value.duracao,
                                link: value.link,
                                associatePrice: value.preco_associado,
                                open: value.aberto
                            });
                        });
                        $('#calendar').calendar({
                            enableContextMenu: true,
                            enableRangeSelection: true,
                            contextMenuItems: [
                                {
                                    text: 'Modificar',
                                    click: editEvent
                                },
                                {
                                    text: 'Inscrições',
                                    click: getRegistrations
                                },
                                {
                                    text: 'Apagar',
                                    click: deleteEvent
                                }
                            ],
                            selectRange: function (e) {
                                editEvent({startDate: e.startDate, endDate: e.endDate});
                            },
                            mouseOnDay: function (e) {
                                if (e.events.length > 0) {
                                    var content = '';

                                    for (var i in e.events) {
                                        content += '<div class="event-tooltip-content">'
                                            + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                                            + '<div class="event-location">' + e.events[i].location + '</div>'
                                            + '</div>';
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

                        var calendar = $('#calendar-appears');
                        calendar.css('display', 'inline-block');
                    },
                    500: function () {
                        window.alert('Erro na BD');
                    }
                }
            });
        }

        function getTypeEvent(event) {
            $.ajax({
                type: 'POST',
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'events',
                    function: 'typeEvent',
                    id: 1
                },
                statusCode: {
                    200: function (response) {
                        var attach = '';
                        var text = '';
                        $('#event-modal select[name="event-type"]').empty();
                        $('#type-event-modal select[name="type-event-desig"]').empty();
                        $.each(response, function (index, value) {
                            attach += '<option value="' + value.idTipoEvento + '">' + value.desig + '</option>';
                            text += '<option value="' + value.idTipoEvento + '">' + value.desig + '</option>';
                        });
                        $('#event-modal select[name="event-type"]').append(attach);
                        $('#type-event-modal select[name="type-event-desig"]').append(text);
                        $('#event-modal select[name="event-type"]').val(event.typeEvent);
                        $('#type-event-modal select[name="type-event-desig"]').val(event.typeEvent);
                        $('#type-event-modal input[name="type-event-color"]').val(event.color);
                    },
                    500: function () {
                        alert('Error')
                    }
                }
            });
        }

        function editEvent(event) {
            getTypeEvent(event);

            var regist = $('#open-regist');
            var close = $('#close-registrations');
            $('#event-modal select[name="event-type"]').empty();
            $('#event-modal input[name="event-open"]').val(event ? event.open : event.open);
            $('#event-modal input[name="event-index"]').val(event ? event.idEvent : event.idEvent);
            if ($('#event-modal input[name="event-index"]').val() != "") {
                if ($('#event-modal input[name="event-open"]').val() == 1) {
                    regist.css('display', 'none');
                    close.css('display', 'inline-block');
                } else {
                    close.css('display', 'none');
                    regist.css('display', 'inline-block');
                }
            } else {
                close.css('display', 'none');
                regist.css('display', 'none');
            }
            $('#event-modal input[name="event-page-id"]').val(event ? event.pageID : event.pageID);
            $('#event-modal input[name="event-name"]').val(event ? event.name : event.name);
            $('#event-modal input[name="event-location"]').val(event ? event.location : event.location);
            $('#event-modal input[name="event-speaker"]').val(event ? event.speaker : event.speaker);
            $('#event-modal input[name="event-price"]').val(event ? event.price : event.price);
            $('#event-modal input[name="event-price-associate"]').val(event ? event.associatePrice : event.associatePrice);
            $('#event-modal input[name="event-description"]').val(event ? event.description : event.description);
            $('#event-modal input[name="event-vacancies"]').val(event ? event.vacancies : event.vacancies);
            $('#event-modal input[name="event-hour"]').val(event ? event.hours : event.hours);
            $('#event-modal input[name="event-duration"]').val(event ? event.duration : event.duration);
            $('#event-modal input[name="event-link"]').val(event ? event.link : event.link);
            //
            $('#event-modal input[name="event-start-date"]').datepicker({
                dateFormat: "dd-mm-yy",
                beforeShow: function () {
                    setTimeout(function () {
                        $('.ui-datepicker').css('z-index', 99999999999999);
                    }, 0);
                }
            });
            $('#event-modal input[name="event-start-date"]').datepicker('setDate', event.startDate);
            $('#event-modal input[name="event-end-date"]').datepicker({
                dateFormat: "dd-mm-yy",
                beforeShow: function () {
                    setTimeout(function () {
                        $('.ui-datepicker').css('z-index', 99999999999999);
                    }, 0);
                }
            });
            $('#event-modal input[name="event-end-date"]').datepicker('setDate', event.endDate);
            var modal = $('#event-modal');
            modal.modal();
        }

        function deleteEvent(event) {
            $.ajax({
                type: 'POST',
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'events',
                    function: 'deleteEvent',
                    idEvent: event.idEvent
                },
                statusCode: {
                    200: function () {
                        getEvents();
						updateLayout();
                    },
                    500: function (response) {
                        console.log(response.msg);
                    }
                }
            });
        }

        function saveEvent() {
            if ($('#event-modal input[name="event-index"]').val() == '') {
                var event = {
                    object: 'events',
                    function: 'addEditEventss',
                    idTest: '0',
                    designation: $('#event-modal input[name="event-name"]').val(),
                    place: $('#event-modal input[name="event-location"]').val(),
                    startDate: $('#event-modal input[name="event-start-date"]').datepicker({dateFormat: 'dd/mm/yy'}).val(),
                    finishDate: $('#event-modal input[name="event-end-date"]').datepicker({dateFormat: 'dd/mm/yy'}).val(),
                    speaker: $('#event-modal input[name="event-speaker"]').val(),
                    price: $('#event-modal input[name="event-price"]').val(),
                    priceAssociate: $('#event-modal input[name="event-price-associate"]').val(),
                    description: $('#event-modal input[name="event-description"]').val(),
                    typeEvent: $('#event-modal select[name="event-type"]').val(),
                    vacancies: $('#event-modal input[name="event-vacancies"]').val(),
                    hours: $('#event-modal input[name="event-hour"]').val(),
                    duration: $('#event-modal input[name="event-duration"]').val(),
                    pageID: $('#event-modal input[name="event-page-id"]').val(),
                    link: $('#event-modal input[name="event-link"]').val()
                }
            } else {
                var event = {
                    object: 'events',
                    function: 'addEditEventss',
                    idTest: '1',
                    idEvent: $('#event-modal input[name="event-index"]').val(),
                    designation: $('#event-modal input[name="event-name"]').val(),
                    place: $('#event-modal input[name="event-location"]').val(),
                    startDate: $('#event-modal input[name="event-start-date"]').datepicker({dateFormat: 'dd-mm-yy'}).val(),
                    finishDate: $('#event-modal input[name="event-end-date"]').datepicker({dateFormat: 'dd-mm-yy'}).val(),
                    speaker: $('#event-modal input[name="event-speaker"]').val(),
                    price: $('#event-modal input[name="event-price"]').val(),
                    priceAssociate: $('#event-modal input[name="event-price-associate"]').val(),
                    description: $('#event-modal input[name="event-description"]').val(),
                    typeEvent: $('#event-modal select[name="event-type"]').val(),
                    vacancies: $('#event-modal input[name="event-vacancies"]').val(),
                    hours: $('#event-modal input[name="event-hour"]').val(),
                    duration: $('#event-modal input[name="event-duration"]').val(),
                    pageID: $('#event-modal input[name="event-page-id"]').val(),
                    link: $('#event-modal input[name="event-link"]').val()
                }
            }
            validateEvent(event);
        }

        function saveTypeEvent(idType, id, desig, color) {
            var desigmsg = $('#desigmsg');
            if (desig != '') {
                hideValidation(desigmsg);
                $.ajax({
                    type: 'POST',
                    url: "/wp-content/themes/illdy/bd/",
                    dataType: 'json',
                    data: {
                        object: 'events',
                        function: 'addTypeEvent',
                        desig: desig,
                        color: color,
                        id: id,
                        typeEvent: idType
                    },
                    statusCode: {
                        201: function (response) {
                            var event = {
                                typeEvent: idType,
                                color: color
                            };
                            var typeEventModal = $('#type-event-modal');
                            var editType = $('#edit-type-event');
                            var createType = $('#create-type-event');
                            var eventModal = $('#event-modal');
                            typeEventModal.modal('hide');
                            getTypeEvent(event);
                            $('#type-event-modal input[name="type-event-index"]').val('');
                            $('#type-event-modal input[name="type-event-desig"]').css('display', 'none');
                            $('#type-event-modal select[name="type-event-desig"]').css('display', 'inline');
                            editType.css('display', 'inline-block');
                            createType.css('display', 'inline-block');
                            eventModal.modal();
                        },
                        500: function (response) {
                            alert(response.msg);
                        }
                    }
                });
            } else {
                validateInputs(desigmsg, 'Introduza uma designação!');
            }
        }

        function deleteTypeEvent() {
            $.ajax({
                type: 'POST',
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'events',
                    function: 'deleteTypeEvent',
                    typeEvent: $('#type-event-modal input[name="type-event-index"]').val()
                },
                statusCode: {
                    200: function (response) {
                        var typeEventModal = $('#type-event-modal');
                        typeEventModal.modal('hide');
                    },
                    500: function (response) {
                        validateInputs($('#designmsg'), 'Não pode ter eventos associados a este tipo criados!');
                        console.log(response.msg);
                    }
                }

            });
        }

        function validateEvent(event) {
            var count = 0;
            var name = $('#event-modal input[name="event-name"]');
            var namemsg = $('#eventmsg');
            var location = $('#event-modal input[name="event-location"]');
            var locationmsg = $('#locationmsg');
            var priceAssociate = $('#event-modal input[name="event-price-associate"]');
            var priceAmsg = $('#priceAmsg');
            var price = $('#event-modal input[name="event-price"]');
            var pricemsg = $('#pricemsg');
            var description = $('#event-modal input[name="event-description"]');
            var descriptionmsg = $('#descriptionmsg');
            var vacancies = $('#event-modal input[name="event-vacancies"]');
            var vacanciesmsg = $('#vacanciesmsg');
            var hours = $('#event-modal input[name="event-hour"]');
            var hoursmsg = $('#hoursmsg');
            var duration = $('#event-modal input[name="event-duration"]');
            var durationmsg = $('#durationmsg');
            var type = $('#event-modal select[name="event-type"]');
            var typemsg = $('#typemsg');
            re1 = /[0-9]/;
            re2 = /^[a-zA-Z àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ]{2,30}$/;
            re3 = /[a-z]/;
            re4 = /^[0-9]+$/;
            //validate event name
            if (name.val() === "") {
                validateInputs(namemsg, 'Introduza um nome!');
            } else {
                hideValidation(namemsg);
                count = count + 1;
            }
            //validate location
            if (location.val() === "") {
                validateInputs(locationmsg, 'Introduza um local!');
            } else {
                hideValidation(locationmsg);
                count = count + 1;
            }
            //validate Associate price
            if (priceAssociate.val() === "") {
                validateInputs(priceAmsg, 'Introduza um preço!');
            } else {
                hideValidation(priceAmsg);
                count = count + 1;
            }
            //validate price
            if (price.val() === "") {
                validateInputs(pricemsg, 'Introduza um preço!');
            } else {
                hideValidation(pricemsg);
                count = count + 1;
            }
            //validate description
            if (description.val() === "") {
                validateInputs(descriptionmsg, 'Introduza uma descrição!');
            } else {
                hideValidation(descriptionmsg);
                count = count + 1;
            }
            //Validate vacancies
            if (vacancies.val() === "") {
                validateInputs(vacanciesmsg, 'Introduza o número de vagas!');
            } else if (!re4.test(vacancies.val())) {
                validateInputs(vacanciesmsg, 'Introduza apenas números!');
            } else {
                hideValidation(vacanciesmsg);
                count = count + 1;
            }
            //Validate hours
            if (hours.val() === "") {
                validateInputs(hoursmsg, 'Introduza a hora de inicio do evento!');
            } else {
                hideValidation(hoursmsg);
                count = count + 1;
            }
            //Validate duration
            if (duration.val() === "") {
                validateInputs(durationmsg, 'Introduza a duração do evento!');
            } else if (!re4.test(duration.val())) {
                validateInputs(durationmsg, 'Introduza apenas números!');
            } else {
                hideValidation(durationmsg);
                count = count + 1;
            }
            //Type validation
            if (type.val() === null) {
                validateInputs(typemsg, 'Escolha um tipo!');
            } else {
                hideValidation(typemsg);
                count = count + 1;
            }

            if (count == 9) {
                addEditEvents(event);
                var modal = $('#event-modal');
                modal.modal('hide');
            }
        }
    }
));

