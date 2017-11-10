/**
 * Created by tiago on 11/05/2017.
 */

$(document).ready(function(){
    $('.qpp-style input#submit').click(function(){
    });
});

$(document).ready(function(){
   $('#payment-select').change(function(){
        if($('#payment-select').val() == 1 || $('#payment-select').val() == 2){
            $('#paypal-form2').css('display','none');
            $('#paypal-form').css('display','inline-block');
        }else if($('#payment-select').val()== 3){
            $('#paypal-form').css('display','none');
            $('#paypal-form2').css('display','inline-block');
        }else {
            $('#paypal-form').css('display','none');
            $('#paypal-form2').css('display','none');
        }
   });
});