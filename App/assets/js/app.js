/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');
require('jquery');
require('bootstrap');
require('@fortawesome/fontawesome-free/css/all.min.css');
/*require('../css/app.css');
require('@fortawesome/fontawesome-free/css/all.css');
require('@fortawesome/fontawesome-free/js/all.js');
// loads the jquery package from node_modules*/
var $ = require('jquery');
require('popper.js');
require('bootstrap-star-rating');
require('infinite-scroll');
$(document).ready(function(){
    $('.js-datepicker').datepicker({
        format: 'yyyy/mm/dd',
        todayHighlight: true
    });
    $('.dropdown-toggle').dropdown();
});



$('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
});

//Dès lors qu'on modifie le 'selected list'
//Si la valeur est Freelancer alors on affiche les champs le concernant et on les rend obligatoire
$(document).ready(function(){
    $('#user_role').change(function() {
        if ($('option:selected', $(this)).html() === 'Freelancer') {
            $('.freelancerField').css("display", "block");
            $('#user_nomSociete').attr('required', true);
            $('#user_titreFreelancer').attr('required', true);
            $('#user_tarifHoraireFreelancer').attr('required', true);
            $('#user_presentationFreelancer').attr('required', true);
            $('.js-multiple-select').attr('required', true);
        }else{
            console.log("Je suis un Porteur de projet");
            $('.freelancerField').css("display", "none");
            $('#user_nomSociete').attr('required', false);
            $('#user_titreFreelancer').attr('required', false);
            $('#user_tarifHoraireFreelancer').attr('required', false);
            $('#user_presentationFreelancer').attr('required', false);
            $('.js-multiple-select').attr('required', false);
        }
    });


});