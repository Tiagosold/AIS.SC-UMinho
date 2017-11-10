/**
 * Created by tiago on 11/06/2017.
 */

//Open Registration Table
$(document).ready(function () {
    $('#open-registrations').css("display", "none");
    $("#registrations_view").on('click', function () {
        if ($('#open-registrations').css('display') == 'inline-block') {
            $('#open-registrations').css("display", "none");
        } else {
            $('#calendar-appears').css('display', "none");
            $('#open-associates').css('display','none');
            $('#registration-heading').empty();
            $("#registrations_table").empty();
            $("#registration-body").empty();
        }
    });
});

//
function getRegistrations(event){
    $.ajax({
        type: 'POST',
        url: "/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'registration',
            function: 'getRegistrations',
            idEvent: event.idEvent
        },
        statusCode:{
            200: function(response){
                $('#calendar-appears').css('display', "none");
                $('#registration-heading').empty();
                $("#registrations_table").empty();
                $("#registration-body").empty();
                $('#registration-heading').append('<h3 class="panel-title">Inscrições</h3>');
                $("#registration-body").append('<table id="registrations_table" class="table table-striped table-hover"></table>');
                $("#registrations_table").append('<thead><tr id="tr-registrations"></tr></thead>');
                var titles = ['Nome', 'NºAluno', 'Email', 'Telemóvel', 'Curso', 'Ano', 'Sócio', 'Data Inscrição', 'Pago',  'Modificar'];
                for (i = 0; i < titles.length; i++) {
                    $('#tr-registrations').append('<th>' + titles[i] + '</th>');
                }
                var counting = 0;
                var foo;
                var email;
                var name;
                var student;
                var tel;
                var year;
				var curso;
				var course;
				var registrationDate;
                $("#registrations_table").append('<tbody id=tbody-registration></tbody>');
                for (i = 0; i < response.length; i++) {
                    $('#tbody-registration').append('<tr id="registration' + counting + '"></tr>');
                    if(response[i].Utilizador_idUtilizador > 0) {
						if(response[i].idCurso == 1){
							curso = 'MIEGSI'; 
						}else if(response[i].curso == 2){
							curso = 'MIEGSI-PL'; 
						}else if(response[i].curso == 3){
							curso = 'MSI'; 
						}else{
							curso = 'PDTSI'; 
						}
                        name = '<td style="width:17.5%">' + response[i].nomeUtilizador + '</td>';
                        student = '<td style="width:6%">' + response[i].num + '</td>';
                        email = '<td style="width:22.5%">' + response[i].mail + '</td>';
                        tel = '<td style="width:9%">' + response[i].tel + '</td>';
						course =  '<td style="width:9%">' + curso + '</td>';
                        year = '<td style="width:9%">' + response[i].an + 'º</td>';
                        foo = '<td style="width:5%">Sim</td>';
						registrationDate = '<td style="width:5%">'+response[i].dataInscricao+'</td>';
                        var modifyState ='<button id="modifyState"' + counting + ' type="button" onclick="changePaymentState(' + counting + ',0,'+response[i].estado+','+event.idEvent+')">' +
                            '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>';
                        var deleteRegistration ='<button id="deleteRegistration"' + counting + ' type="button" onclick="deleteRegistration(' + counting + ',0'+event.idEvent+')">' +
                            '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                        $('#registration' + counting).append('<input id="associate-id' + counting + '" type="hidden" value="' + response[i].Utilizador_idUtilizador + '"/>');
                    }else {
                        name = '<td style="width:17.5%">' + response[i].nome + '</td>';
                        student = '<td style="width:6%">' + response[i].numeroAluno + '</td>';
                        email = '<td id="email'+counting+'" style="width:22.5%">' + response[i].email + '</td>';
                        tel = '<td style="width:9%">' + response[i].telemovel + '</td>';
						course = '<td style="width:9%">' + response[i].curso + '</td>';
                        year = '<td style="width:9%">'+response[i].ano+'º</td>';
                        foo = '<td style="width:5%">Não</td>';
						registrationDate = '<td style="width:5%">'+response[i].dataInscricao+'</td>';
                        var modifyState ='<button id="modifyState"' + counting + ' type="button" onclick="changePaymentState(' + counting + ',1,'+response[i].estado+', '+event.idEvent+')">' +
                            '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>';
                        var deleteRegistration ='<button id="deleteRegistration"' + counting + ' type="button" onclick="deleteRegistration(' + counting + ',1,'+event.idEvent+')">' +
                            '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                    $('#registration' + counting).append(name);
                    $('#registration' + counting).append(student);
                    $('#registration' + counting).append(email);
                    $('#registration' + counting).append(tel);
					$('#registration' + counting).append(course);
                    $('#registration' + counting).append(year);
                    $('#registration' + counting).append(foo);
					$('#registration' + counting).append(registrationDate);
                    if(response[i].estado == 0){
                        $('#registration' + counting).append('<td style="width:5%">Não</td>');
                    }else {
                        $('#registration' + counting).append('<td style="width:5%">Sim</td>')
                    }
                    $('#registration' + counting).append('<td style="width:7%">' + modifyState + ' ' + deleteRegistration + '</td>');
                    counting++;
                }
                $('#registrations_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'print','excel'

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
                $('#open-registrations').css("display", "inline-block");

            },
            500: function(response){
                alert(response.msg);
            }
        }
    });
}

//Function to change payment state
function changePaymentState(count,params,state,event){
    var foo;
    if(state == 0){
        foo = 1;
    }else {
        foo = 0;
    }
    $.ajax({
        type: 'POST',
        url: "/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'registration',
            function: 'changePaymentState',
            id: params,
            idEvent: event,
            idAssociate: $('#associate-id' + count).val(),
            state: foo,
            email: $('#email'+count).text()
        },
        statusCode: {
            201: function(){
                var eventt = {
                    idEvent: event
                };
                getRegistrations(eventt);
            },
            500: function(response){
                console.log(response.msg);
            }
        }
    });
}

//function to delete a registration
function deleteRegistration(count,params,event){
    $.ajax({
        type: 'POST',
        url: "/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'registration',
            function: 'deleteRegistration',
            id: params,
            idEvent: event,
            idAssociate: $('#associate-id' + count).val(),
            email: $('#email'+count).text()
        },
        statusCode: {
            200: function(){
                var eventt = {
                    idEvent: event
                };
                getRegistrations(eventt);
            },
            500: function(response){
                console.log(response.msg);
            }
        }
    });
}

//Function to show events that users can register
function showEvents(){
    $.ajax({
        type: 'POST',
        url: "/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'events',
            function: 'getEvent'
        },
        statusCode: {
            200: function(response){
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
                for (i=0; i<response.length; i++) {
                    var eventDate = response[i].data_inicio;
                    var year = eventDate.substr(6, 4);
                    var month = eventDate.substr(3, 2);
                    var day = eventDate.substr(0, 2);
                    eventDate = year + '/' + month + '/' + day;
                    var desigMonth = getMonth(month);
                    if (today <= eventDate) {
                        if(response[i].link != null && response[i].link != ''){
                            var image = '<img alt="" src="' + response[i].link + '"/>';
                        }else {
                            var image = '';
                        }
                        //$('#check-events').append('<p><a href="/?page_id='+response[i].pageID+'">'+response[i].designacao+'</a></p>');
                        $('#event-list').append('<li><time>' +
                            '<span class="day">'+day+'</span>' +
                            '<span class="month">'+desigMonth+'</span> ' +
                            '<span class="year">'+year+'</span>' +
                            '<span class="time">12:00 AM</span>' +
                            '</time>' +
                                image +
                            '<div class="info"> ' +
                            '<h2 class="title"><a href="/?page_id='+response[i].pageID+'/">'+response[i].designacao+'</a></h2> ' +
                            '<p class="desc">'+response[i].descricao+'</p> ' +
                            '<ul>' +
                            '<li style="width:50%;">'+response[i].desig+' <span class="glyphicon glyphicon-info-sign"></span></li>' +
                            '<li style="width:50%;">'+response[i].hora+'h <span class="glyphicon glyphicon-time"></span></li>' +
                            '</ul>' +
                            '</div>' +
                            '</li>');
                    }
                }

            }
        }
    });
}

$(document).ready(function(){
   $('#save-registration').click(function(){
       var associate;
       var id;
       if($('#user-type').val() == 2) {
           associate = $('#hiddenAssociateId').val();
           id = 0;
           saveRegistration(associate,id,'','','','');
       }else {
           associate = 0;
           id = 1;
           $('#registration-modal').modal('show');
       }
   });
});

function saveRegistration(associate,id,name,number,email,phone,year,course){
     $.ajax({
            type: 'POST',
            url:"/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'registration',
            function: 'addRegistration',
            id: id,
            idEvent: $('#event-id').val(),
            idAssociate: associate,
            name: name,
            number: number,
            email: email,
            phone: phone,
            year: year,
			course: course
        },
        statusCode: {
            201: function(){
                $('#registration-modal').modal('hide');
                alert('Inscrição efetuada com sucesso!');
                hideValidation($('#regist-email-msg'));
                hideValidation($('#regist-error-msg'));
            },
            500: function(response){
                $('#registration-modal').modal('hide');
                console.log(response.msg);
            },
            501: function(){
                validateInputs($('#regist-email-msg'), 'Introduza um email válido!');
            },
            502: function(){
                $('#registration-modal').modal('hide');
                hideValidation($('#regist-validate-msg'));
                validateInputs($('#regist-error-msg'), 'Já se inscreveu neste evento!');
				alert('Já se inscreveu neste evento!');
            }
        }
    });
}

$(document).ready(function(){
    $('#save-user-registration').click(function(){
        if($('#event-id-reg').val() == '') {
            var count = 0;
            re1 = /[0-9]/;
            re2 = /^[a-z\s]+$/i;
            re3 = /[a-z]/;
            re4 = /^[0-9]+$/;
            re5 = /^[1-5]+$/;
            var name;
            var studentNumber;
            var email;
            var phone;
            var year;
            //validate name
            if ($('#regist-name').val() === '') {
                validateInputs($('#regist-name-msg'), 'Introduza o seu nome!');
            } else if (!re2.test($('#regist-name').val())) {
                validateInputs($('#regist-name-msg'), 'Nome não pode conter números ou carateres especiais!');
            } else {
                hideValidation($('#regist-name-msg'));
                count = count + 1;
            }
            //validate student number
            if (!re1.test($('#regist-number').val())) {
                validateInputs($('#regist-number-msg'), 'Introduza um número de aluno válido!');
            } else {
                hideValidation($('#regist-number-msg'));
                count = count + 1;
            }
            //validate email
            if ($('#regist-email').val() === "") {
                validateInputs($('#regist-email-msg'), 'Introduza um email!');
            } else {
                hideValidation($('#regist-email-msg'));
                count = count + 1;
            }
            //validate phone number
            if (!re4.test($('#regist-phone').val())) {
                validateInputs($('#regist-phone-msg'), 'Introduza um número de telemóvel válido!');
            } else {
                hideValidation($('#regist-phone-msg'));
                count = count + 1;
            }
            //validate year
           if ($('#year-event-regist').val() === '0') {
                validateInputs($('#regist-year-msg'), 'Selecione o ano que frequenta!');
            } else {
                hideValidation($('#regist-year-msg'));
                count = count + 1;
            }
			if ($('#course-event-regist').val() === '0') {
                validateInputs($('#course-year-msg'), 'Selecione o curso!');
            } else {
                hideValidation($('#course-year-msg'));
                count = count + 1;
            }
            
            if (count == 6) {
                name = $('#regist-name').val();
                studentNumber = $('#regist-number').val();
                email = $('#regist-email').val();
                phone = $('#regist-phone').val();
                year = $('#year-event-regist').val();
				course = $('#course-event-regist').val();
                saveRegistration(0, 1, name, studentNumber, email, phone, year, course);
            }
        }else {
            var count = 0;
            re1 = /[0-9]/;
            re2 = /^[a-z\s]+$/i;
            re3 = /[a-z]/;
            re4 = /^[0-9]+$/;
            re5 = /^[1-5]+$/;
            var name;
            var studentNumber;
            var email;
            var phone;
            var year;
            //validate name
            if ($('#regist-name').val() === '') {
                validateInputs($('#regist-name-msg'), 'Introduza o seu nome!');
            } else if (!re2.test($('#regist-name').val())) {
                validateInputs($('#regist-name-msg'), 'Nome não pode conter números ou carateres especiais!');
            } else {
                hideValidation($('#regist-name-msg'));
                count = count + 1;
            }
            //validate student number
            if (!re1.test($('#regist-number').val())) {
                validateInputs($('#regist-number-msg'), 'Introduza um número de aluno válido!');
            } else {
                hideValidation($('#regist-number-msg'));
                count = count + 1;
            }
            //validate email
            if ($('#regist-email').val() === "") {
                validateInputs($('#regist-email-msg'), 'Introduza um email!');
            } else {
                hideValidation($('#regist-email-msg'));
                count = count + 1;
            }
            //validate phone number
            if (!re4.test($('#regist-phone').val())) {
                validateInputs($('#regist-phone-msg'), 'Introduza um número de telemóvel válido!');
            } else {
                hideValidation($('#regist-phone-msg'));
                count = count + 1;
            }
            //validate year
            if ($('#year-event-regist').val() === '0') {
                validateInputs($('#regist-year-msg'), 'Selecione o ano que frequenta!');
            } else {
                hideValidation($('#regist-year-msg'));
                count = count + 1;
            }
			//validate course
			if ($('#course-event-regist').val() === '0') {
                validateInputs($('#course-year-msg'), 'Selecione o curso!');
            } else {
                hideValidation($('#course-year-msg'));
                count = count + 1;
            }
            if (count == 6) {
                name = $('#regist-name').val();
                studentNumber = $('#regist-number').val();
                email = $('#regist-email').val();
                phone = $('#regist-phone').val();
                year = $('#year-event-regist').val();
				course = $('#course-event-regist').val();
                $.ajax({
                    type: 'POST',
                    url:"/wp-content/themes/illdy/bd/",
                    dataType: 'json',
                    data: {
                        object: 'registration',
                        function: 'addRegistration',
                        id: 1,
                        idEvent: $('#event-id-reg').val(),
                        name: name,
                        number: studentNumber,
                        email: email,
                        phone: phone,
                        year: year,
						course: course
                    },
                    statusCode: {
                        201: function(){
                            $('#registration-modal').modal('hide');
							alert('Inscrição efetuada com sucesso!');
                            validateInputs($('#regist-validate-msg'), 'Inscrição efetuada com sucesso!');
                            hideValidation($('#regist-email-msg'));
                            hideValidation($('#regist-error-msg'));
							
                        },
                        500: function(response){
                            $('#registration-modal').modal('hide');
                            console.log(response.msg);
                        },
                        501: function(){
                            validateInputs($('#regist-email-msg'), 'Introduza um email válido!');
                        },
                        502: function(){
                            $('#registration-modal').modal('hide');
                            hideValidation($('#regist-validate-msg'));
                            validateInputs($('#regist-error-msg'), 'Já se inscreveu neste evento!');
							alert('Já se inscreveu neste evento!');
                        }
                    }
                });
                $('#event-id-reg').val('');
            }
        }
    });
});

function getRegistrationsAssociate(){
   $.ajax({
       type: 'POST',
       url: "/wp-content/themes/illdy/bd/",
       dataType: 'json',
       data: {
           object: 'registration',
           function: 'checkRegistration',
           idAssociate: $('#hiddenAssociateId').val()
       },
       statusCode: {
           200: function(response){
               $('#associate-heading').empty();
               $("#associate-body").empty();
               $("#registrationsAss_table").empty();
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
               $('#associate-heading').append('<h3 class="panel-title">Histórico Inscrições</h3>');
               $("#associate-body").append('<table id="registrationsAss_table" class="table table-striped table-hover"></table>');
               $("#registrationsAss_table").append('<thead><tr id="tr-regist-ass"></tr></thead>');
               var titles = ['Nome','Data Evento', 'Data Inscrição', 'Autorizada', 'Inscrição aberta','Apagar Inscrição'];
               var counting = 0;
               for (i = 0; i < titles.length; i++) {
                   $('#tr-regist-ass').append('<th>' + titles[i] + '</th>');
               }
               $("#registrationsAss_table").append('<tbody id=tbody-regist-ass></tbody>');
               for (i = 0; i < response.length; i++) {
                   var initialDate = response[i].data_inicio;
                   var year = initialDate.substr(6,4);
                   var month = initialDate.substr(3,2);
                   var day = initialDate.substr(0,2);
                   initialDate = year + '/' + month + '/' + day;
                   $('#tbody-regist-ass').append('<tr id="associateR' + counting + '"></tr>');
                   $('#associateR' + counting).append('<input id="id-associateR' + counting + '" type="hidden" value="' + response[i].Evento_idEvento + '"/>');
                   $('#associateR' + counting).append('<td>' + response[i].designacao + '</td>');
                   $('#associateR' + counting).append('<td>' + initialDate + '</td>');
				   $('#associateR' + counting).append('<td>' + response[i].dataInscricao + '</td>');
					if(response[i].estado == 0){
					   	$('#associateR' + counting).append('<td>Não</td>');
				   }else{
						$('#associateR' + counting).append('<td>Sim</td>');
				   }
					if(initialDate < today){
                       $('#associateR' + counting).append('<td>Não</td>');
                       $('#associateR' + counting).append('<td>N/A</td>');
					}else if((initialDate >= today) && (response[i].aberto == 1)){
                       $('#associateR' + counting).append('<td>Sim</td>');
                       $('#associateR' + counting).append('<td><button id="button-regist" type="button" onclick="removeRegistration(' + counting + ')">' +
                           '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>');
					}else if ((initialDate >= today) && (response[i].aberto == 0)){
                       $('#associateR' + counting).append('<td>Não</td>');
                       $('#associateR' + counting).append('<td><button id="button-regist" type="button" onclick="removeRegistration(' + counting + ')">' +
                           '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>');
					}
                   counting++;
               }
               $('#registrationsAss_table').DataTable({
                   dom: 'Bfrtip',
                   buttons: [
                       'print','excel','pdf'
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
               },
           404: function(){

           }
       }
   });
}

function removeRegistration(counting){
    $.ajax({
        type: 'POST',
        url: "/wp-content/themes/illdy/bd/",
        dataType: 'json',
        data: {
            object: 'registration',
            function: 'deleteRegistration',
            id: 0,
            idEvent: $('#id-associateR' + counting).val(),
            idAssociate: $('#hiddenAssociateId').val()
        },
        statusCode: {
            200: function(){
                getRegistrationsAssociate();
            },
            500: function(response){
                console.log(response.msg);
            }
        }
    });
}


