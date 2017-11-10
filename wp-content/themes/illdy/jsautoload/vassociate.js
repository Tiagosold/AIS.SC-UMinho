/**
 * Created by tiago on 31/03/2017.
 */

// IIFE - Immediately Invoked Function Expression
(function (yourcode) {

    // The global jQuery object is passed as a parameter
    yourcode(window.jQuery, window, document);

}(function ($, window, document) {

        // The $ is now locally scoped
        $(function () {

            var associates = $('#open-associates');
            var view = $('#associate_view');
            associates.css("display", "none");
            view.on('click', function () {
                if (associates.css('display') == 'inline-block') {
                    associates.css("display", "none");
                } else {
                    $('#calendar-appears').css('display', "none");
                    $('#open-registrations').css("display", "none");
                    $('#open-partners').css('display', "none");
                    $('#open-transactions').css("display", "none");
                    $("#panel-body").empty();
                    getAssociates();
                }
            });

            $('form').ajaxForm(function () {
                $('#hiddenControl').val('hello');
                $('#profile-information').hide();
                $('#change-image').css('display', 'none');
                $('#image-selected').text('');
                getUserInfo();
            });

            //Bring edit Associate for USER ASSOCIATE
            $('#edit-button').on('click', function () {
                $('#hiddenControl').val('something');
                var userBody = $('#userBody');
                var panel = $('.panel-title');
                var name = $('.panel-title').text();
                var email = $('#emaile_register').text();
                var course = $('#hiddenCourse').val();
                var numberS = $('#studente_number').text();
                var year = $('#hiddenYear').val();
                var phone = $('#registe_phone').text();
                var attach = '';
                $('#confirm-info').css('display', 'inline');
                $('#edit-clear').css('display', 'none');
                panel.empty();
                panel.append('<input id="completee_name" type="text" value="' + name + '"><div id="namemsg" style="color:Red; font-size:75%; display:none"></div>');
                userBody.empty();
                attach += '<tr><td style="vertical-align:middle;">Email:</td><td><input id="emaile_register" type="email" value="' + email + '"><div id="emailmsg" style="color:Red; font-size:75%; display:none"></div> </td></tr>';
                attach += '<tr><td style="vertical-align:middle;">Curso:</td><td id="coursee_register"><div class="select-style"><select id="courseea_register"> <option value="0">Selecione o curso que frequenta</option> <option value="1">MIEGSI</option> <option value="2">MIEGSI-PL</option> <option value="3">MSI</option> <option value="4">PDTSI</option> </select></div>    <div id="coursemsg" style="color:Red; font-size:75%; display:none"></div> </td></tr>';
                attach += '<tr><td style="vertical-align:middle;">NºEstudante:</td><td><input id="studente_number" type="text" value="' + numberS + '"> <div id="studentmsg" style="color:Red; font-size:75%; display:none"></div> </td></tr>';
                attach += '<tr><td style="vertical-align:middle;">Ano:</td><td id="yearr_register"><div class="select-style"><select id="yeare_register" placeholder="Ano" name="ano"><option value="0">Ano que frequenta</option><option value="1">1º</option><option value="2">2º</option><option value="3">3º</option><option value="4">4º</option> <option value="5">5º</option></select></div>    <div id="yearmsg" style="color:Red; font-size:75%; display:none"></div> </td></tr>';
                attach += '<tr><td style="vertical-align:middle;">Telemóvel:</td><td><input id="registe_phone" type="tel" value="' + phone + '"><div id="phonemsg" style="color:Red; font-size:75%; display:none"></div></td> </tr>';
                userBody.append(attach);
                $('#courseea_register').val(course);
                $('#yeare_register').val(year);
                bringYear($('#course_register'), $('#year_register'));
                confirmation(1);
            });

            //update associate information ADMIN SIDE
            $("#update").on('click', function () {
                validateAssociateAdmin(2);
            });

            //Go back to profile
            $('#profile-again').click(function () {
                $('#profile-information').hide();
                $('#edit-clear').css('display', 'inline');
                getUserInfo();
            });

            //Change image
            $(document).on('change', ':file', function () {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });

            $('#image-selected').empty();
            $(':file').on('fileselect', function (event, numFiles, label) {
                if (numFiles == 1) {
                    $('#image-selected').text(label);
                    $('#change-image').css('display', 'inline');
                } else {
                    alert('Selecione só um ficheiro!');
                }
            });


            $('#renew').on('click', function () {
                renewQuotas();
            });

            //Bring User profile
            $('.perfil.menu-item a').on('click', function () {
                $('.responsive-menu').hide();
                $('#edit-clear').css('display', 'inline');
                getUserInfo();
                $('body').prepend('<div class="profile_overlay"></div>');
                $('[data-toggle="tooltip"]').tooltip();
                $('div.profile_overlay').on('click', function () {
                    $('div.profile_overlay').remove();
                    $('#profile-information').hide();
                });
            });

        });

        function updateAssociate(int) {
            if (int == 2) {
                $.ajax({
                    type: "POST",
                    url: "/wp-content/themes/illdy/bd/",
                    dataType: 'json',
                    data: {
                        object: 'login',
                        function: 'addEditAssociate',
                        id: '2',
                        idAssociate: $('#hiddenID').val(),
                        email: $('#update-email').val(),
                        name: $('#update-name').val(),
                        phone: $('#update-phone').val(),
                        student_number: $('#update-number').val(),
                        initialDate: $('#initial_date').val(),
                        finalDate: $('#final_date').val(),
                        course: $('#course_register').val(),
                        year: $('#year_register').val()
                    },
                    statusCode: {
                        201: function () {
                            $('#panel-heading').empty();
                            $("#associates_table").empty();
                            $("#panel-body").empty();
							$('#update-modal').modal('hide');
                            getAssociates();
                        },
                        500: function () {
                            validateInputs($('#update-email-msg'), 'Erro no registo!');
                            console.log("BD Error");
                        },
                        501: function () {
                            validateInputs($('#update-email-msg'), 'Introduziu um email inválido!');
                        },
                        502: function () {
                            validateInputs($('#update-email-msg'), 'Email já existe!');
                        }
                    }
                });
            } else if (int == 1) {
                $.ajax({
                    type: "POST",
                    url: "/wp-content/themes/illdy/bd/",
                    dataType: 'json',
                    data: {
                        object: 'login',
                        function: 'addEditAssociate',
                        id: '1',
                        idAssociate: $('#hiddenAssociateId').val(),
                        email: $('#emaile_register').val(),
                        name: $('#completee_name').val(),
                        phone: $('#registe_phone').val(),
                        student_number: $('#studente_number').val(),
                        course: $('#courseea_register').val(),
                        year: $('#yeare_register').val()
                    },
                    statusCode: {
                        201: function () {
                            $('div.profile_overlay').remove();
                            $('#profile-information').hide();
                            $('#userBody').empty();
                            $('.panel-title').empty();
                            $('body').prepend('<div class="profile_overlay"></div>');
                            $('#edit-clear').css('display', 'inline');
                            $('#confirm-info').css('display', 'none');
                            $('div.profile_overlay').on('click', function () {
                                $('div.profile_overlay').remove();
                                $('#profile-information').hide();
                            });
                            getUserInfo();
                        },
                        500: function () {
                            validateInputs($('#yearmsg'), 'Erro no registo!');
                            console.log("BD Error");
                        },
                        501: function () {
                            validateInputs($('#emailmsg'), 'Introduziu um email inválido!');
                        },
                        502: function () {
                            validateInputs($('#emailmsg'), 'Email já existe!');
                        }
                    }
                });
            }
        }

        //For user Associate
        function getUserInfo() {
            var jsonData;
            if ($('#hiddenControl').val() != '') {
                $('#userBody').empty();
                $('#image-place').empty();
                $.ajax({
                    type: "POST",
                    url: "/wp-content/themes/illdy/bd/",
                    dataType: 'json',
                    data: {
                        object: 'associate',
                        function: 'getAssociates',
                        id: '2',
                        idAssociate: $('#hiddenAssociateId').val()
                    },
                    statusCode: {
                        200: function (response) {
                            jsonData = response[0];
                            $('.panel-title').text(jsonData.nomeUtilizador);
                            if (jsonData.imagem != null && jsonData.imagem != '') {
                                $('#image-place').append('<img alt="Profile pic" src="../wp-content/themes/illdy/uploads/' + jsonData.imagem + '" class="img-circle img-responsive" style="width:80px; height:80px">')
                            } else {
                                $('#image-place').append('<img alt="User Pic" src="../wp-content/themes/illdy/uploads/default.png" class="img-circle img-responsive" style="width:80px; height:80px">');
                            }
                            $('#userBody').append('<tr><td>Email:</td><td id="emaile_register">' + jsonData.email + '</td></tr>');
                            $('#userBody').append('<tr><td>Curso:</td><td id="coursee_register"><input hidden id="hiddenCourse" value="' + jsonData.idCurso + '">' + jsonData.designacao + '</td></tr>');
                            $('#userBody').append('<tr><td>NºEstudante:</td><td id="studente_number">' + jsonData.numeroAluno + '</td></tr>');
                            $('#userBody').append('<tr><td>Ano:</td><td id="yearr_register"><input hidden id="hiddenYear" value="' + jsonData.ano + '">' + jsonData.ano + 'º ano</td></tr>');
                            $('#userBody').append('<tr><td>Telemóvel:</td><td id="registe_phone">' + jsonData.telemovel + '</td></tr>');
                            $('#userBody').append('<tr><td>Sócio desde:</td><td>' + jsonData.dataInicio + '</td></tr>');
                            $('#userBody').append('<tr><td>Sócio até:</td><td>' + jsonData.dataFinal + '</td></tr>');
                            $('#confirm-info').css('display', 'none');
                            $('#profile-information').fadeIn(500);
                            $('#hiddenControl').val('');
                        },
                        500: function () {
                            alert('Não foi possivel carregar os dados');
                        }
                    }
                });
            } else {
                $('#profile-information').fadeIn(500);
            }
        }

        //Validate associate update fields
        function validateAssociate(int) {
            var email = $('#emaile_register');
            var name = $('#completee_name');
            var count = 0;
            re1 = /[0-9]/;
            re2 = /^[a-zA-Z àáâäãèéêëîïíóõôœùúûüÿçÀÃÁÂÄÈÉÊËÎÍÏÓÕÔŒÙÛÚÜŸÇ]{2,30}$/;
            re3 = /[a-z]/;
            re4 = /^[0-9]+$/;
            //validate email
            if (email.val() === "") {
                validateInputs($('#emailmsg'), 'Introduza um email!');
            } else {
                hideValidation($('#emailmsg'));
                count = count + 1;
            }
            //validate name
            if (name.val() === '') {
                validateInputs($('#namemsg'), 'Introduza o seu nome!');
            } else if (!re2.test(name.val())) {
                validateInputs($('#namemsg'), 'Nome não pode conter números ou carateres especiais!');
            } else {
                hideValidation($('#namemsg'));
                count = count + 1;
            }
            //validate phone number
            if (!re4.test($('#registe_phone').val())) {
                validateInputs($('#phonemsg'), 'Introduza um número de telemóvel válido!');
            } else {
                hideValidation($('#phonemsg'));
                count = count + 1;
            }
            //validate student number
            if (!re1.test($('#studente_number').val())) {
                validateInputs($('#studentmsg'), 'Introduza um número de aluno válido!');
            } else {
                hideValidation($('#studentmsg'));
                count = count + 1;
            }
            //validate course
            if ($('#courseea_register').val() === '0') {
                validateInputs($('#coursemsg'), 'Selecione o curso!');
            } else {
                hideValidation($('#coursemsg'));
                count = count + 1;
            }
            //validate year
            if ($('#yeare_register').val() === '0') {
                validateInputs($('#yearmsg'), 'Selecione o ano que frequenta!');
            } else {
                hideValidation($('#yearmsg'));
                count = count + 1;
            }
            if (count == 6) {
                updateAssociate(int);
            }
        }

		function validateAssociateAdmin(int) {
            var email = $('#update-email');
            var name = $('#update-name');
            var count = 0;
            re1 = /[0-9]/;
            re2 = /^[a-zA-Z àáâäãèéêëîïíóõôœùúûüÿçÀÃÁÂÄÈÉÊËÎÍÏÓÕÔŒÙÛÚÜŸÇ]{2,30}$/;
            re3 = /[a-z]/;
            re4 = /^[0-9]+$/;
            //validate email
            if (email.val() === "") {
                validateInputs($('#update-email-msg'), 'Introduza um email!');
            } else {
                hideValidation($('#update-email-msg'));
                count = count + 1;
            }
            //validate name
            if (name.val() === '') {
                validateInputs($('#update-name-msg'), 'Introduza o seu nome!');
            } else if (!re2.test(name.val())) {
                validateInputs($('#update-name-msg'), 'Nome não pode conter números ou carateres especiais!');
            } else {
                hideValidation($('#update-name-msg'));
                count = count + 1;
            }
            //validate phone number
            if (!re4.test($('#update-phone').val())) {
                validateInputs($('#update-phone-msg'), 'Introduza um número de telemóvel válido!');
            } else {
                hideValidation($('#update-phone-msg'));
                count = count + 1;
            }
            //validate student number
            if (!re1.test($('#update-number').val())) {
                validateInputs($('#update-number-msg'), 'Introduza um número de aluno válido!');
            } else {
                hideValidation($('#update-number-msg'));
                count = count + 1;
            }
            //validate course
            if ($('#course_register').val() === '0') {
                validateInputs($('#coursemsg'), 'Selecione o curso!');
            } else {
                hideValidation($('#coursemsg'));
                count = count + 1;
            }
            //validate year
            if ($('#year_register').val() === '0') {
                validateInputs($('#yearmsg'), 'Selecione o ano que frequenta!');
            } else {
                hideValidation($('#yearmsg'));
                count = count + 1;
            }
            if (count == 6) {
                updateAssociate(int);
            }
        }
		
        //confirm changes ASSOCIATE SIDE
        function confirmation(int) {
            $('body').confirmation({
                selector: '[data-toggle="confirmation"]',
                title: 'Tens a certeza?',
                placement: 'left',
                btnOkLabel: 'Sim',
                btnCancelLabel: 'Não',
                onConfirm: function (event) {
                    validateAssociate(int)
                }
            });
        }

        

        //Function to renew associate quotas
        function renewQuotas() {
            hideValidation($('#qerrormsg'));
            hideValidation($('#qemailmsg'));
            if ($('#quotas-renew').val() == 0) {
                validateInputs($('#qerrormsg'), 'Selecione o número de cotas que pretende');
            } else {
                $.ajax({
                    type: "POST",
                    url: "/wp-content/themes/illdy/bd/",
                    dataType: 'json',
                    data: {
                        object: 'associate',
                        function: 'renewQuotas',
                        email: $('#email-quotas').val(),
                        pass: $('#password-quotas').val(),
                        quotas: $('#quotas-renew').val()
                    },
                    statusCode: {
                        201: function (response) {
                            validateInputs($('#qokmsg'), 'Conta renovada com sucesso, aguarde um pouco!');
                            $.post("/confirmar-registo", {
                                    renew: 0,
                                    email: $('#email-quotas').val(),
                                    random: response.random
                                },
                                function () {
                                    $('#renew-msg').append('Enviamos-lhe um email para renovar a sua conta!');
                                    window.location.href = '/confirmar-registo?fo=1';
                                });
                        },
                        500: function () {
                            validateInputs($('#qerrormsg'), 'Dados incorretos');
                        },
                        501: function () {
                            validateInputs($('#qerrormsg'), 'Dados incorretos');
                        },
                        502: function () {
                            validateInputs($('#qemailmsg'), 'Já fez um pedido de renovação');
                        }
                    }
                });
            }
        }

    }
));

function changeState(cont) {
    var email;
    $.ajax(
        {
            type: "POST",
            url: "/wp-content/themes/illdy/bd/",
            dataType: 'json',
            data: {
                object: 'associate',
                function: 'changeAssociateState',
                id: '1',
                idAssociate: $('#id-associate' + cont).val(),
                quotas: $('#quotas_admin' + cont).val()
            },
            statusCode: {
                200: function () {
                    email = $('#email-associate' + cont).text();
                    $("#panel-body").empty();
                    $.post("/admin", {
                        validate: '0',
                        email: email
                    });
                    getAssociates();
                    $('#dialogOK').text('Sócio confirmado com sucesso!');
                    $("#dialogOK").dialog({
                        buttons: {
                            Ok: function () {
                                $(this).dialog("close");
                            }
                        }
                    })
                },
                500: function () {
                    alert('Erro na BD');
                }
            }
        });
}

//Update associate info
function getAssociate(cont) {
    $.ajax({
        type: "POST",
        url: "/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'associate',
            function: 'getAssociates',
            id: '2',
            idAssociate: $('#id-associate' + cont).val(),
        },
        statusCode: {
            200: function (response) {
				$('#update-modal').modal();
                var course = $('#course_register');
                var year = $('#year_register');
                $('#update-email').val(response[0].email);
                $('#update-name').val(response[0].nomeUtilizador);
                $('#update-phone').val(response[0].telemovel);
                $(function () {
                    $("#initial_date").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "dd/mm/yy"
                    });
                    $("#final_date").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "dd/mm/yy"
                    });

                });
                $('#hiddenID').val($('#id-associate' + cont).val());
                $('#initial_date').val(response[0].dataInicio);
                $('#final_date').val(response[0].dataFinal);
                $('#course_register').val(response[0].idCurso);
                $('#year_register').val(response[0].ano);
                bringYear(course, year);
                $('#update-number').val(response[0].numeroAluno);
            },
            500: function () {
                window.alert('Erro na BD');
            }
        }
    });
}


function getAssociates() {
    var estado;
    var teste;
    var modify;
    $.ajax({
        type: "POST",
        url: "/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'associate',
            function: 'getAssociates',
            id: 1
        },
        statusCode: {
            200: function (response) {
                var attach = '';
                //Get today´s date
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1; //January is 0!
                var yyyy = today.getFullYear();
                if (dd < 10) {
                    dd = '0' + dd
                }
                if (mm < 10) {
                    mm = '0' + mm
                }
                today = yyyy + '/' + mm + '/' + dd;

                attach += '<table id="associates_table" class="table table-striped table-hover"><thead><tr>';
                var titles = ['Nome', 'NºAluno', 'Email', 'Telemóvel', 'Ano', 'Curso', 'Inicio', 'Fim', 'Modificar'];
                var counting = 0;
                $.each(titles, function (index, value) {
                    attach += '<th>' + value + '</th>';
                });
                attach += '</tr></thead><tbody>';
                $.each(response, function (index, value) {
                    var startDate = value.dataInicio;
                    var yearS = startDate.substr(6, 4);
                    var monthS = startDate.substr(3, 2);
                    var dayS = startDate.substr(0, 2);
                    var finalDate = value.dataFinal;
                    var year = finalDate.substr(6, 4);
                    var month = finalDate.substr(3, 2);
                    var day = finalDate.substr(0, 2);
                    startDate = yearS + '/' + monthS + '/' + dayS;
                    finalDate = year + '/' + month + '/' + day;
                    //Check if associates partnership expired
                    if (value.estado == 1 && (value.expirado == 0) && (today > finalDate)) {
                        expiredAssociate(value.idUtilizador);
                        attach += '<tr id="associate' + counting + '" style="background-color: red">';
                    } else if (value.expirado == 1) {
                        attach += '<tr id="associate' + counting + '" style="background-color: red">';
                    } else {
                        attach += '<tr id="associate' + counting + '">';
                    }
                    attach += '<input id="id-associate' + counting + '" type="hidden" value="' + value.idUtilizador + '"/>';
                    attach += '<td id="hellooo" style="width:17.5%">' + value.nomeUtilizador + '</td>';
                    attach += '<td style="width:6%">' + value.numeroAluno + '</td>';
                    attach += '<td id="email-associate' + counting + '" style="width:22.5%">' + value.email + '</td>';
                    attach += '<td style="width:9%">' + value.telemovel + '</td>';
                    attach += '<td style="width:5%">' + value.ano + 'º</td>';
                    attach += '<td style="width:8%">' + value.designacao + '</td>';
                    attach += '<td style="width:9%">' + startDate + '</td>';
                    attach += '<td style="width:9%">' + finalDate + '</td>';
                    if (value.estado === '1') {
                        estado = '<span class="glyphicon glyphicon-ok" aria-hidden="true">';
                    } else {
                        estado = '<button id="validateAssociate"' + counting + ' type="button" onclick="changeState(' + counting + ')">' +
                            '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                    modify = '<button id="modify"' + counting + ' type="button" onclick="getAssociate(' + counting + ')">' +
                        '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>';
                    attach += '<td style="width:7%">' + estado + ' ' + modify + '</td>';
                    attach += '<input id="' + counting + '" type="hidden" value="' + counting + '"/>';
                    attach += '<input id="quotas_admin' + counting + '" type="hidden" value="' + value.numeroCotas + '"/>';
                    counting++;
                });
                attach += '</tr></tbody></table>';
                $('#panel-body').append(attach);

                $('#associates_table').DataTable({
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
                $('#open-associates').css("display", "inline-block");
            },
            500: function (response) {
                window.alert(response.msg);
            }
        }
    });
}

function expiredAssociate(idAssociate) {
            $.ajax(
                {
                    type: "POST",
                    url: "/wp-content/themes/illdy/bd/",
                    dataType: 'json',
                    data: {
                        object: 'associate',
                        function: 'changeAssociateState',
                        id: '3',
                        idAssociate: idAssociate
                    },
                    statusCode: {
                        200: function () {

                        },
                        500: function () {
                            console.log('Erro na BD');
                        }
                    }
                });
        }
		
 function bringYear(course, year) {
            course.change(function () {
                year.empty();
                year.append('<option value="0">Ano que frequenta</option>');
                if (course.val() === '1' || course.val() === '2') {
                    year.append('<option value=1>1º</option>');
                    year.append('<option value=2>2º</option>');
                    year.append('<option value=3>3º</option>');
                    year.append('<option value=4>4º</option>');
                    year.append('<option value=5>5º</option>');
                } else if (course.val() === '3') {
                    year.append('<option value=1>1º</option>');
                    year.append('<option value=2>2º</option>');
                } else if (course.val() === '4') {
                    year.append('<option value=1>1º</option>');
                    year.append('<option value=2>2º</option>');
                    year.append('<option value=3>3º</option>');
                    year.append('<option value=4>4º</option>');
                }
            });
        }