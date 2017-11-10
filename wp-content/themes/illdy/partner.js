/**
 * Created by Vitor on 22/05/2017.
 */

function getPartners() {
    $.ajax({
        type: "POST",
        url: "/wordpress/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'partners',
            function: 'getPartners',
            id: 1
        },
        statusCode: {
            200: function (response) {
                var modify;
                $('#partners-heading').append('<h3 class="panel-title">Parceiros</h3>');
                $("#partners-body").append('<table id="partners_table" class="table table-striped table-hover"></table>');
                $("#partners_table").append('<thead><tr id="tr-partner"></tr></thead>');
                var titles = ['Nome', 'Inicio', 'Fim', 'Observações', 'Montante', 'Prestações', 'Modificar'];
                var counting = 0;
                for (i = 0; i < titles.length; i++) {
                    $('#tr-partner').append('<th>' + titles[i] + '</th>');
                }
                $("#partners_table").append('<tbody id="tbody-partner"></tbody>');
                for (i = 0; i < response.length; i++) {
                    $('#tbody-partner').append('<tr id="partners' + counting + '"></tr>');
                    $('#partners' + counting).append('<td style="width:9%">' + response[i].nomeParceiro + '</td>');
                    $('#partners' + counting).append('<td style="width:5%">' + response[i].dataInicio + '</td>');
                    $('#partners' + counting).append('<td style="width:5%">' + response[i].dataFim + '</td>');
                    $('#partners' + counting).append('<td style="width:9%">' + response[i].observacoes + '</td>');
                    $('#partners' + counting).append('<td style="width:5%">' + response[i].montante + '</td>');
                    $('#partners' + counting).append('<td style="width:5%">' + response[i].prestacoes + '</td>');
                    modify = '<button id="modify"' + counting + ' type="button" onclick="getPartner(' + counting + ')">' +
                        '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>';
                    $('#partners' + counting).append('<td style="width:7%">' + ' ' + modify + '</td>');
                    $('#partners' + counting).append('<input id="id-partner' + counting + '" type="hidden" value="' + response[i].idParceria + '"/>')

                    counting++;
                }
                $('#partners_table').DataTable({
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
                $('#open-partners').css("display", "inline-block");
            },
            500: function (response) {
                window.alert(response.msg);
            }
        }
    });
}

function getPartner(counting) {
    $.ajax({
        type: "POST",
        url: "/wordpress/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'partners',
            function: 'getPartners',
            id: 2,
            idPartner: $('#id-partner'+counting).val()
        },
        statusCode: {
             200: function(response){
                 $('#delete-partner').css('display', 'inline');
                 $('#partner-modal input[name="partner-index"]').val(response[0].idParceria);
                 $('#partner-modal input[name="partner-name"]').val(response[0].nomeParceiro);
                 $('#partner-modal input[name= "partner-start-date"]').datepicker({
                     dateFormat: "dd-mm-yy",
                     beforeShow: function () {
                         setTimeout(function() {
                             $('.ui-datepicker').css('z-index', 99999999999999);
                         }, 0);
                     }
                 });
                 $('#partner-modal input[name="partner-start-date"]').datepicker('setDate', response[0].dataInicio);
                 $('#partner-modal input[name= "partner-end-date"]').datepicker({
                     dateFormat: "dd-mm-yy",
                     beforeShow: function () {
                         setTimeout(function() {
                             $('.ui-datepicker').css('z-index', 99999999999999);
                         }, 0);
                     }
                 });
                 $('#partner-modal input[name="partner-end-date"]').datepicker('setDate', response[0].dataFim);
                 $('#partner-modal input[name="partner-observation"]').val(response[0].observacoes);
                 $('#partner-modal input[name="partner-amount"]').val(response[0].montante);
                 $('#partner-modal input[name="partner-benefits"]').val(response[0].prestacoes);
                 $('#partner-modal').modal();
             }
        }
    });
}

function editPartner() {
    $.ajax({
        type: "POST",
        url: "/wordpress/wp-content/themes/illdy/bd/",
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
                $('#partner-modal').modal('hide');
                $('#partners-heading').empty();
                $("#partners_table").empty();
                $("#partners-body").empty();
                getPartners();
            },
            500: function(response){
                alert(response.msg);
            }
        }

    });
}
function addPartner(){
    $.ajax({
        type: "POST",
        url: "/wordpress/wp-content/themes/illdy/bd/",
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
                $('#partner-modal').modal('hide');
                $('#partners-heading').empty();
                $("#partners_table").empty();
                $("#partners-body").empty();
                getPartners();

            },
            500: function(response){
                alert(response.msg);
            }
        }

    });

}
function deletePartner() {
    $.ajax({
        type: "POST",
        url: "/wordpress/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'partners',
            function: 'deletePartners',
            idPartner: $('#partner-modal input[name="partner-index"]').val()
        },
        statusCode: {
            200: function () {
                $('#partner-modal').modal('hide');
                $('#partners-heading').empty();
                $("#partners_table").empty();
                $("#partners-body").empty();
                getPartners();

            },
            500: function (response) {
                alert(response.msg);
            }
        }


    });
}

function validatePartner() {
    var designation = $('#partner-modal input[name="partner-name"]').val();
    var startDate = $('#partner-modal input[name="partner-start-date"]').val();
    var finishDate = $('#partner-modal input[name="partner-end-date"]').val();
    var observation = $('#partner-modal input[name="partner-observation"]').val();
    var amount = $('#partner-modal input[name="partner-amount"]').val();
    var benefits = $('#partner-modal input[name="partner-benefits"]').val();
    var count = 0;
    re1 = /[0-9]/;
    re2 = /^[a-zA-Z àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ]{2,30}$/;
    re3 = /[a-z]/;
    re4 = /^[0-9]+$/;

//validate designation
    if (designation === '') {
        validateInputs($('#partner-msg-name'), 'Introduza uma designação!');
    } else if (!re2.test(designation)) {
        validateInputs($('#partner-msg-name'), 'A designação não pode conter números ou carateres especiais!');
    } else {
        hideValidation($('#partner-msg-name'));
        count = count + 1;
    }

//validate start date
        if (startDate === '') {
            validateInputs($('#partner-msg-startDate'), 'Introduza uma data de inicio da parceria!');
        } else{
            hideValidation($('#partner-msg-startDate'));
            count = count + 1;
        }
// validate finish date
    if (finishDate === '') {
        validateInputs($('#partner-msg-finishDate'), 'Introduza uma data de fim da parceria!');
    } else{
        hideValidation($('#partner-msg-finishDate'));
        count = count + 1;
    }
// validate observation
    if (observation === '') {
        validateInputs($('#partner-msg-observation'), 'Introduza uma observação!');
    } else if (!re2.test(observation)) {
        validateInputs($('#partner-msg-observation'), 'A observação não pode conter números ou carateres especiais!');
    } else {
        hideValidation($('#partner-msg-observation'));
        count = count + 1;
    }
// validate amount
    if (!re4.test(amount)) {
        validateInputs($('#partner-msg-amount'), 'Introduza um Montante válido');
    } else {
        hideValidation($('#partner-msg-amount'));
        count = count + 1;
    }
// validate benefits
    if (!re4.test(benefits)) {
        validateInputs($('#partner-msg-benefits'), 'Introduza um número de prestações válido!');
    } else {
        hideValidation($('#partner-msg-benefits'));
        count = count + 1;
    }
    if (count == 6) {
        if($('#partner-modal input[name="partner-index"]').val()== ''){
            addPartner();
        }else {
            editPartner();
        }
    }
}
//Save Partner
$(document).ready(function(){
    $('#save-partner').click(function () {
     validatePartner();
    });
})


$(document).ready(function(){
    $('#add-partner-button').click(function () {
        $('#delete-partner').css('display', 'none');
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
                setTimeout(function() {
                    $('.ui-datepicker').css('z-index', 99999999999999);
                }, 0);
            }
        });
        $('#partner-modal input[name= "partner-end-date"]').datepicker({
            dateFormat: "dd-mm-yy",
            beforeShow: function () {
                setTimeout(function() {
                    $('.ui-datepicker').css('z-index', 99999999999999);
                }, 0);
            }
        });
        $('#partner-modal').modal('show');
    });
})

$(document).ready(function(){
    $('#delete-partner').click(function () {
        deletePartner();
    });
})


