/**
 * Created by Kamguia on 27/09/2018.
 */
//let dev = jQuery.noConflict();
$(document).on('change', '#appbundle_etablissements_country, #appbundle_etablissements_regions, #appbundle_etablissements_departments',
    function(){
     let $field = $(this);
     let $countryField = $('#appbundle_etablissements_country');
     let $form = $field.closest('form');
     let target = '#' + $field.attr('id').replace('departments', 'city').replace('regions', 'departments').replace('country', 'regions');
     let data = {};
        data[$countryField.attr('name')] = $countryField.val();
        data[$field.attr('name')] = $field.val();
        //debugger
        $.post($form.attr('action'), data).then(function (data) {
            //debugger
            let $input = $(data).find(target);
            $(target).replaceWith($input);
        })
    });
