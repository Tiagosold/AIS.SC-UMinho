/**
 * Created by Vitor on 22/05/2017.
 */

// IIFE - Immediately Invoked Function Expression
(function (yourcode) {

    // The global jQuery object is passed as a parameter
    yourcode(window.jQuery, window, document);

}(function ($, window, document) {

        // The $ is now locally scoped
        $(function () {

            //Open Partners Table
            var partners = $('#open-partners');
            var view = $('#partners-view');
            var deletePart = $('#delete-partner');
            partners.css("display", "none");
            view.on('click', function () {
                if (partners.css('display') == 'inline-block') {
                    partners.css("display", "none");
                } else {
                    var calendar = $('#calendar-appears');
                    var associates = $('#open-associates');
                    var registrations = $('#open-registrations');
                    var transactions = $('#open-transactions');
                    var partBody = $('#partners-body');
                    calendar.css('display', "none");
                    associates.css('display', 'none');
                    registrations.css("display", "none");
                    transactions.css("display", "none");
                    partBody.empty();
                    getPartners();
                }
            });
            //

            //Save Partner
            var save = $('#save-partner');
            save.on('click',function () {
                validatePartner();
            });
            //

            //Button to add Partner
            var partButton = $('#add-partner-button');
            partButton.on('click', function () {
                var modal = $('#partner-modal');
                var datepicker = $('.ui-datepicker');
                deletePart.css('display', 'none');
                $('#partner-modal input[name="partner-index"]').val('');
                $('#partner-modal input[name="partner-name"]').val('');
                $('#partner-modal input[name="partner-start-date"]').val('');
                $('#partner-modal input[name="partner-end-date"]').val('');
                $('#partner-modal input[name="partner-observation"]').val('');
                $('#partner-modal input[name="partner-amount"]').val('');
                $('#partner-modal input[name="partner-benefits"]').val('');
                $('#partner-modal input[name="partner-image"]').val('');
                $('#partner-modal input[name= "partner-start-date"]').datepicker({
                    dateFormat: "dd-mm-yy",
                    beforeShow: function () {
                        setTimeout(function () {
                            $('.ui-datepicker').css('z-index', 99999999999999);
                        }, 0);
                    }
                });
                $('#partner-modal input[name= "partner-end-date"]').datepicker({
                    dateFormat: "dd-mm-yy",
                    beforeShow: function () {
                        setTimeout(function () {
                            $('.ui-datepicker').css('z-index', 99999999999999);
                        }, 0);
                    }
                });
                modal.modal('show');
            });
            //

            //Delete Partner
            deletePart.on('click',function () {
                deletePartner();
            });
            //
        });

        function editPartner() {
            $.ajax({
                type: "POST",
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'partners',
                    function: 'addEditPartner',
                    id: 1,
                    idPartner: $('#partner-modal input[name="partner-index"]').val(),
                    namePartner: $('#partner-modal input[name="partner-name"]').val(),
                    startDate: $('#partner-modal input[name="partner-start-date"]').val(),
                    endDate: $('#partner-modal input[name="partner-end-date"]').val(),
                    observation: $('#partner-modal input[name="partner-observation"]').val(),
                    amount: $('#partner-modal input[name="partner-amount"]').val(),
                    benefits: $('#partner-modal input[name="partner-benefits"]').val(),
                    image: $('#partner-modal input[name="partner-image"]').val()
                },
                statusCode: {
                    201: function () {
                        var modal = $('#partner-modal');
                        var partBody = $('#partners-body');
                        modal.modal('hide');
                        partBody.empty();
                        getPartners();
                    },
                    500: function (response) {
                        alert(response.msg);
                    }
                }

            });
        }

        function getPartners() {
            $.ajax({
                type: "POST",
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'partners',
                    function: 'getPartners',
                    id: 1
                },
                statusCode: {
                    200: function (response) {
                        var attach = "";
                        var modify;
                        var counting = 0;
                        attach += '<table id="partners_table" class="table table-striped table-hover"><thead><tr>';
                        var titles = ['Nome', 'Inicio', 'Fim', 'Observações', 'Montante', 'Prestações', 'Modificar'];
                        $.each(titles, function (index, value) {
                            attach += '<th>' + value + '</th>';
                        });
                        attach += '</tr></thead><tbody>';
                        $.each(response, function (index, value) {
                            var startDate = value.dataInicio;
                            var yearS = startDate.substr(6, 4);
                            var monthS = startDate.substr(3, 2);
                            var dayS = startDate.substr(0, 2);
                            var finalDate = value.dataFim;
                            var year = finalDate.substr(6, 4);
                            var month = finalDate.substr(3, 2);
                            var day = finalDate.substr(0, 2);
                            startDate = yearS + '/' + monthS + '/' + dayS;
                            finalDate = year + '/' + month + '/' + day;
                            attach += '<tr id="partners' + counting + '">';
                            attach += '<td style="width:9%">' + value.nomeParceiro + '</td>';
                            attach += '<td style="width:5%">' + startDate + '</td>';
                            attach += '<td style="width:5%">' + finalDate + '</td>';
                            attach += '<td style="width:9%">' + value.observacoes + '</td>';
                            attach += '<td style="width:5%">' + value.montante + '</td>';
                            attach += '<td style="width:5%">' + value.prestacoes + '</td>';
                            modify = '<button id="modify"' + counting + ' type="button" onclick="getPartner(' + counting + ')">' +
                                '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>';
                            attach += '<td style="width:7%">' + ' ' + modify + '</td>';
                            attach += '<input id="id-partner' + counting + '" type="hidden" value="' + value.idParceria + '"/>';
                            counting++;
                        });
                        attach += '</tr></tbody></table>';
                        var partBody = $('#partners-body');
                        var partners = $('#open-partners');
                        partBody.append(attach);
                        $('#partners_table').DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'print', 'excel'
                            ],
                            "pageLength": 10,
                            "language": {
                                "lengthMenu": "Mostrar _MENU_ registos por página",
                                "zeroRecords": "Nenhum registo encontrado",
                                "info": "Página _PAGE_ de _PAGES_",
                                "infoEmpty": "Nenhum registo disponivel",
                                "infoFiltered": "(Filtrado de _MAX_ registos)",
                                "paginate": {
                                    "previous": "Anterior",
                                    "next": "Próximo"
                                },
                                "search": "Pesquisa"
                            }
                        });
                        partners.css("display", "inline-block");
                    },
                    500: function (response) {
                        window.alert(response.msg);
                    }
                }
            });
        }

        function addPartner() {
            $.ajax({
                type: "POST",
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'partners',
                    function: 'addEditPartner',
                    id: 0,
                    namePartner: $('#partner-modal input[name="partner-name"]').val(),
                    startDate: $('#partner-modal input[name="partner-start-date"]').val(),
                    endDate: $('#partner-modal input[name="partner-end-date"]').val(),
                    observation: $('#partner-modal input[name="partner-observation"]').val(),
                    amount: $('#partner-modal input[name="partner-amount"]').val(),
                    benefits: $('#partner-modal input[name="partner-benefits"]').val(),
                    image: $('#partner-modal input[name="partner-image"]').val()
                },
                statusCode: {
                    201: function () {
                        var modal = $('#partner-modal');
                        var partBody = $('#partners-body');
                        modal.modal('hide');
                        partBody.empty();
                        getPartners();
						updateLayout();
                    },
                    500: function (response) {
                        alert(response.msg);
                    }
                }
            });
        }

        function deletePartner() {
            $.ajax({
                type: "POST",
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'partners',
                    function: 'deletePartners',
                    idPartner: $('#partner-modal input[name="partner-index"]').val()
                },
                statusCode: {
                    200: function () {
                        var modal = $('#partner-modal');
                        var partBody = $('#partners-body');
                        modal.modal('hide');
                        partBody.empty();
                        getPartners();
						updateLayout();
                    },
                    500: function (response) {
                        alert(response.msg);
                    }
                }
            });
        }

        function validatePartner() {
            var designation = $('#partner-modal input[name="partner-name"]').val();
            var desigmsg = $('#partner-msg-name');
            var startDate = $('#partner-modal input[name="partner-start-date"]').val();
            var startDatemsg = $('#partner-msg-startDate');
            var finishDate = $('#partner-modal input[name="partner-end-date"]').val();
            var finishDatemsg = $('#partner-msg-finishDate');
            var observation = $('#partner-modal input[name="partner-observation"]').val();
            var observationmsg = $('#partner-msg-observation');
            var amount = $('#partner-modal input[name="partner-amount"]').val();
            var amountmsg = $('#partner-msg-amount');
            var benefits = $('#partner-modal input[name="partner-benefits"]').val();
            var benefitsmsg = $('#partner-msg-benefits');
            var count = 0;
            re1 = /[0-9]/;
            re2 = /^[a-zA-Z àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ]{2,30}$/;
            re3 = /[a-z]/;
            re4 = /^[0-9]+$/;

//validate designation
            if (designation === '') {
                validateInputs(desigmsg, 'Introduza uma designação!');
            } else {
                hideValidation(desigmsg);
                count = count + 1;
            }

//validate start date
            if (startDate === '') {
                validateInputs(startDatemsg, 'Introduza uma data de inicio da parceria!');
            } else {
                hideValidation(startDatemsg);
                count = count + 1;
            }
// validate finish date
            if (finishDate === '') {
                validateInputs(finishDatemsg, 'Introduza uma data de fim da parceria!');
            } else {
                hideValidation(finishDatemsg);
                count = count + 1;
            }
// validate observation
            if (observation === '') {
                validateInputs(observationmsg, 'Introduza uma observação!');
            } else {
                hideValidation(observationmsg);
                count = count + 1;
            }
// validate amount
            if (!re4.test(amount)) {
                validateInputs(amountmsg, 'Introduza um Montante válido');
            } else {
                hideValidation(amountmsg);
                count = count + 1;
            }
// validate benefits
            if (!re4.test(benefits)) {
                validateInputs(benefitsmsg, 'Introduza um número de prestações válido!');
            } else {
                hideValidation(benefitsmsg);
                count = count + 1;
            }
            if (count == 6) {
                if ($('#partner-modal input[name="partner-index"]').val() == '') {
                    addPartner();
                } else {
                    editPartner();
                }
            }
        }

    }
));

function getPartner(counting) {
    $.ajax({
        type: "POST",
        url: "/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'partners',
            function: 'getPartners',
            id: 2,
            idPartner: $('#id-partner' + counting).val()
        },
        statusCode: {
            200: function (response) {
                var deletePart = $('#delete-partner');
                var modal = $('#partner-modal');
                deletePart.css('display', 'inline');
                $('#partner-modal input[name="partner-index"]').val(response[0].idParceria);
                $('#partner-modal input[name="partner-name"]').val(response[0].nomeParceiro);
                $('#partner-modal input[name= "partner-start-date"]').datepicker({
                    dateFormat: "dd-mm-yy",
                    beforeShow: function () {
                        setTimeout(function () {
                            $('.ui-datepicker').css('z-index', 99999999999999);
                        }, 0);
                    }
                });
                $('#partner-modal input[name="partner-start-date"]').datepicker('setDate', response[0].dataInicio);
                $('#partner-modal input[name= "partner-end-date"]').datepicker({
                    dateFormat: "dd-mm-yy",
                    beforeShow: function () {
                        setTimeout(function () {
                            $('.ui-datepicker').css('z-index', 99999999999999);
                        }, 0);
                    }
                });
                $('#partner-modal input[name="partner-end-date"]').datepicker('setDate', response[0].dataFim);
                $('#partner-modal input[name="partner-observation"]').val(response[0].observacoes);
                $('#partner-modal input[name="partner-amount"]').val(response[0].montante);
                $('#partner-modal input[name="partner-benefits"]').val(response[0].prestacoes);
                $('#partner-modal input[name="partner-image"]').val(response[0].imagem);
                modal.modal();
            }
        }
    });
}









