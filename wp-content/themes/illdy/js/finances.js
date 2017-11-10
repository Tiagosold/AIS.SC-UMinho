/**
 * Created by Vitor on 29/06/2017.
 */
// IIFE - Immediately Invoked Function Expression
(function (yourcode) {
    // The global jQuery object is passed as a parameter
    yourcode(window.jQuery, window, document);

}(function ($, window, document) {
        // The $ is now locally scoped
        $(function () {
            //Open Transactions Table
            var transactions = $('#open-transactions');
            var transBody = $('#transactions-body');
            transactions.css("display", "none");
            $('#transactions-view').on('click', function () {
                if (transactions.css('display') == 'inline-block') {
                    transactions.css("display", "none");
                } else {
                    $('#calendar-appears').css('display', "none");
                    $('#open-registrations').css("display", "none");
                    $('#open-associates').css('display', 'none');
                    $('#open-partners').css('display', 'none');
                    transBody.empty();
                    getTransactions();
                }
            });
            //

            getBalance();

            //Delete Transaction
            $('#delete-transaction').on('click', function () {
                deleteTransaction();
            });
            //

            //Save Transaction
            $('#save-transaction').on('click', function () {
                validateTransaction();
            });
            //

            //When clicking add transaction
            $('#add-transaction-button').on('click', function () {
                $('#delete-transaction').css('display', 'none');
                $('#transaction-modal input[name="transaction-description"]').val('');
                $('#transaction-modal input[name="transaction-date"]').val('');
                $('#transaction-modal input[name="transaction-value"]').val('');
                $('#transaction-modal select[name="transaction-account"]').val(1);
                $('#transaction-modal select[name="transaction-type"]').val(1);
                $('#transaction-modal input[name="transaction-date"]').datepicker({
                    dateFormat: "dd-mm-yy",
                    beforeShow: function () {
                        setTimeout(function () {
                            $('.ui-datepicker').css('z-index', 99999999999999);
                        }, 0);
                    }
                });
                $('#transaction-modal').modal('show');
            });
            //

            //Saldo Conta bancária
            $('#banc-acc').on('click', function () {
                bankAccount();
            });
            //

            //Saldo Cofre
            $('#safe-acc').on('click', function () {
                vault();
            });
            //

            //Saldo Total
            $('#total-acc').on('click', function () {
                getBalance();
            });
            //

        });

        function getTransactions() {
            return $.ajax({
                type: "POST",
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'finances',
                    function: 'getTransactions',
                    id: 1
                },
                statusCode: {
                    200: function (response) {
                        var transBody = $('#transactions-body');
                        var transactions = $('#open-transactions');
                        var attach = "";
                        var modifyTrans;
                        attach += '<table id="transactions_table" class="table table-striped table-hover">';
                        attach += '<thead><tr>';
                        var titles = ['Descrição', 'Data de movimento', 'Conta', 'Tipo do Movimento', 'Montante', 'Modificar'];
                        var counting = 0;

                        $.each(titles, function (index, value) {
                            attach += '<th>' + value + '</th>';
                        });
                        attach += '</tr></thead><tbody>';

                        $.each(response, function (index, value) {
                            var movDate = value.dataMovimento;
                            var year = movDate.substr(6, 4);
                            var month = movDate.substr(3, 2);
                            var day = movDate.substr(0, 2);
                            movDate = year + '/' + month + '/' + day;
                            if (value.tipoMovimento == 1) {
                                attach += '<tr id="transactions' + counting + '" style="background-color: red;">';
                            } else {
                                attach += '<tr id="transactions' + counting + '">';
                            }
                            attach += '<td style="width:9%">' + value.descricao + '</td>';
                            attach += '<td style="width:5%">' + movDate + '</td>';
                            attach += '<td style="width:5%">' + value.Designacao + '</td>';
                            attach += '<td style="width:5%">' + value.desig + '</td>';
                            attach += '<td style="width:9%">' + value.valor + ' €' + '</td>';
                            modifyTrans = '<button id="modifyTrans"' + counting + ' onclick="editFinances(' + counting + ')">' +
                                '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>';
                            attach += '<td style="width:7%">' + ' ' + modifyTrans + '</td>';
                            attach += '<input id="id-transaction' + counting + '" type="hidden" value="' + value.idMovimento + '"/>';
                            counting++;
                        });

                        attach += '</tr></tbody></table>';
                        transBody.append(attach);
                        $('#transactions_table').DataTable({
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
                        transactions.css("display", "inline-block");
                    },
                    500: function (response) {
                        window.alert(response.msg);
                    }
                }
            });
        }


        function getBalance() {
            $.ajax({
                type: "POST",
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'finances',
                    function: 'getTransactions',
                    id: 1
                },
                statusCode: {
                    200: function (response) {
                        var balanceCount = $('#balance-count');
                        var balanceTotal = $('#balance-total');
                        balanceCount.empty();
                        balanceTotal.empty();
                        var total = 0;
                        $.each(response, function (index, value) {
                            if (value.tipoMovimento == 1) {
                                total = parseFloat(total) - parseFloat(value.valor);
                            } else if (value.tipoMovimento == 2) {
                                total = parseFloat(total) + parseFloat(value.valor);
                            }
                        });
                        if (parseFloat(total) > 1000 || parseFloat(total) < -1000) {
                            balanceCount.css('font-size', '22px');
                        }
                        total = total.toFixed(2);
                        balanceCount.text(' ' + parseFloat(total));
                        balanceTotal.text('Saldo Total');

                    },
                    500: function () {
                    }
                }
            });
        }

        function deleteTransaction() {
            $.ajax({
                type: "POST",
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'finances',
                    function: 'deleteTransactions',
                    idTransaction: $('#transaction-modal input[name="transaction-index"]').val()
                },
                statusCode: {
                    200: function () {
                        var modal = $('#transaction-modal');
                        var transBody = $('#transactions-body');
                        var index = $('#transactions-index');
                        modal.modal('hide');
                        transBody.empty();
                        index.empty();
                        $('#transaction-modal input[name="transaction-index"]').val('');
                        getBalance();
                        getTransactions();
                    },
                    500: function (response) {
                        alert(response.msg);
                    }
                }
            });
        }

        function addTransaction() {
            $.ajax({
                type: "POST",
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'finances',
                    function: 'addEditTransaction',
                    id: 0,
                    description: $('#transaction-modal input[name="transaction-description"]').val(),
                    transactionDate: $('#transaction-modal input[name="transaction-date"]').val(),
                    value: $('#transaction-modal input[name="transaction-value"]').val(),
                    typeAccount: $('#transaction-modal select[name="transaction-account"]').val(),
                    typeMovement: $('#transaction-modal select[name="transaction-type"]').val()
                },
                statusCode: {
                    201: function () {
                        var modal = $('#transaction-modal');
                        var transBody = $('#transactions-body');
                        var index = $('#transactions-index');
                        modal.modal('hide');
                        transBody.empty();
                        getBalance();
                        getTransactions();

                    },
                    500: function (response) {
                        alert(response.msg);
                    }
                }

            });
        }

        function editTransaction() {
            $.ajax({
                type: "POST",
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'finances',
                    function: 'addEditTransaction',
                    id: 1,
                    idTransaction: $('#transaction-modal input[name="transaction-index"]').val(),
                    description: $('#transaction-modal input[name="transaction-description"]').val(),
                    transactionDate: $('#transaction-modal input[name="transaction-date"]').val(),
                    value: $('#transaction-modal input[name="transaction-value"]').val(),
                    typeAccount: $('#transaction-modal select[name="transaction-account"]').val(),
                    typeMovement: $('#transaction-modal select[name="transaction-type"]').val(),
                },
                statusCode: {
                    201: function () {
                        var transBody = $('#transactions-body');
                        var modal = $('#transaction-modal');
                        modal.modal('hide');
                        transBody.empty();
                        $('#transaction-modal input[name="transaction-index"]').val('');
                        getBalance();
                        getTransactions();
                    },
                    500: function (response) {
                        alert(response.msg);
                    }
                }
            });
        }

        function validateTransaction() {
            var description = $('#transaction-modal input[name="transaction-description"]').val();
            var descriptionmsg = $('#transaction-msg-description');
            var transactionDate = $('#transaction-modal input[name="transaction-date"]').val();
            var transactionmsg = $('#transaction-msg-date');
            var value = $('#transaction-modal input[name="transaction-value"]').val();
            var valuemsg = $('#transaction-msg-value');
            var count = 0;
            re1 = /[0-9]/;
            re2 = /^[a-z\s]+$/i;
            re3 = /[a-z]/;
            re4 = /^[0-9]+$/;

//validate designation
            if (description === '') {
                validateInputs(descriptionmsg, 'Introduza uma descrição!');
            } else {
                hideValidation(descriptionmsg);
                count = count + 1;
            }

//validate date
            if (transactionDate === '') {
                validateInputs(transactionmsg, 'Introduza uma data valida!');
            } else {
                hideValidation(transactionmsg);
                count = count + 1;
            }


// validate amount
            if (value == '') {
                validateInputs(valuemsg, 'Introduza um montante');
            } else {
                hideValidation(valuemsg);
                count = count + 1;
            }
            if (count == 3) {
                if ($('#transaction-modal input[name="transaction-index"]').val() == '') {
                    addTransaction();
                } else {
                    editTransaction();
                }
            }
        }

        function bankAccount() {
            $.ajax({
                type: "POST",
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'finances',
                    function: 'getTransactions',
                    id: 4
                },
                statusCode: {
                    200: function (response) {
                        var balanceCount = $('#balance-count');
                        var balanceTotal = $('#balance-total');
                        balanceCount.empty();
                        balanceTotal.empty();
                        var totalBanc = 0;
                        $.each(response, function (index, value) {
                            if (value.tipoMovimento == 1) {
                                totalBanc = parseFloat(totalBanc) - parseFloat(value.valor);

                            } else if (value.tipoMovimento == 2) {
                                totalBanc = parseFloat(totalBanc) + parseFloat(value.valor);
                            }
                        });
                        if (parseFloat(totalBanc) > 1000 || parseFloat(totalBanc) < -1000) {
                            balanceCount.css('font-size', '22px');
                        }
                        totalBanc = totalBanc.toFixed(2);
                        balanceCount.text(' ' + parseFloat(totalBanc));
                        balanceTotal.text('Saldo conta Bancaria');
                        balanceTotal.css('font-size', '13px');
                    },
                    500: function () {
                    }
                }
            });
        }

        function vault() {
            $.ajax({
                type: "POST",
                url: "/wp-content/themes/illdy/bd/",
                dataType: 'json',
                data: {
                    object: 'finances',
                    function: 'getTransactions',
                    id: 3
                },
                statusCode: {
                    200: function (response) {
                        var balanceCount = $('#balance-count');
                        var balanceTotal = $('#balance-total');
                        balanceCount.empty();
                        balanceTotal.empty();
                        var totalSafe = 0;
                        $.each(response, function (index, value) {
                            if (value.tipoMovimento == 1) {
                                totalSafe = parseFloat(totalSafe) - parseFloat(value.valor);

                            } else if (value.tipoMovimento == 2) {
                                totalSafe = parseFloat(totalSafe) + parseFloat(value.valor);
                            }
                        });
                        if (parseFloat(totalSafe) > 1000 || parseFloat(totalSafe) < -1000) {
                            balanceCount.css('font-size', '22px');
                        }
                        totalSafe = parseFloat(totalSafe.toFixed(2));
                        balanceCount.text(' ' + totalSafe);
                        balanceTotal.text('Saldo Cofre');

                    },
                    500: function () {
                    }
                }
            });
        }

    }
));

function editFinances(count) {
    $.ajax({
        type: "POST",
        url: "/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'finances',
            function: 'getTransactions',
            id: 2,
            idTransaction: $('#id-transaction' + count).val()
        },
        statusCode: {
            200: function (response) {
                var deleteTrans = $('#delete-transaction');
                var modal = $('#transaction-modal');
                deleteTrans.css('display', 'inline');
                $('#transaction-modal input[name="transaction-index"]').val(response[0].idMovimento);
                $('#transaction-modal input[name="transaction-description"]').val(response[0].descricao);
                $('#transaction-modal input[name="transaction-date"]').datepicker({
                    dateFormat: "dd-mm-yy",
                    beforeShow: function () {
                        setTimeout(function () {
                            $('.ui-datepicker').css('z-index', 99999999999999);
                        }, 0);
                    }
                });
                $('#transaction-modal input[name="transaction-date"]').datepicker('setDate', response[0].dataMovimento);
                $('#transaction-modal input[name="transaction-value"]').val(response[0].valor);
                $('#transaction-modal select[name="transaction-account"]').val(response[0].tipoConta);
                $('#transaction-modal select[name="transaction-type"]').val(response[0].tipoMovimento);
                modal.modal();
            },
            500: function () {
            }
        }
    });
}