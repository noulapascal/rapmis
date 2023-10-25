/**
 * Created by Kamguia on 27/09/2018.
 */
//let dev = jQuery.noConflict();
/*
$(document).on('change', '#App_etablissements_country, #App_etablissements_regions, #App_etablissements_departments','#App_etablissements_departments',
    function(){
     let $field = $(this)
     let $form = $field.closest('form')
     let data={}
     data[$field.attr('name')]=$field.val();
     $.post($form.attr('action'),data).then(function(data){
         debugger;
     })
    })
*/
$(document).on('change', '#App_etablissements_country, #App_etablissements_regions, #App_etablissements_departments, #App_etablissements_city',
    function(){
     let $field = $(this);
     let $countryField = $('#App_etablissements_country');
     let $regionField = $('#App_etablissements_regions');
     let $deptField = $('#App_etablissements_departments');
     let $form = $field.closest('form');
     let target = '#' + $field.attr('id').replace('city', 'subdivision').replace('departments', 'city').replace('regions', 'departments').replace('country', 'regions');
     let data = {};
        data[$countryField.attr('name')] = $countryField.val();
        data[$regionField.attr('name')] = $regionField.val();
        data[$deptField.attr('name')] = $deptField.val();
        data[$field.attr('name')] = $field.val();
     // debugger
        $.post($form.attr('action'), data).then(function (data) {
            //debugger
            let $input = $(data).find(target);
            $(target).replaceWith($input);
        })
    });
    
$(document).on('load', '#App_etablissements_country, #App_etablissements_regions, #App_etablissements_departments, #App_etablissements_city',
    function(){
     let $field = $(this);
     let $countryField = $('#App_etablissements_country');
     let $regionField = $('#App_etablissements_regions');
     let $deptField = $('#App_etablissements_departments');
     let $form = $field.closest('form');
     let target = '#' + $field.attr('id').replace('city', 'subdivision').replace('departments', 'city').replace('regions', 'departments').replace('country', 'regions');
     let data = {};
        data[$countryField.attr('name')] = $countryField.val();
        data[$regionField.attr('name')] = $regionField.val();
        data[$deptField.attr('name')] = $deptField.val();
        data[$field.attr('name')] = $field.val();
     // debugger
        $.post($form.attr('action'), data).then(function (data) {
            //debugger
            let $input = $(data).find(target);
            $(target).replaceWith($input);
        })
    });
    

$(document).on('change', '#App_user_country, #App_user_regions, #App_user_departments, #App_user_city',
    function(){
     let $field = $(this);
     let $countryField = $('#App_user_country');
     let $regionField = $('#App_user_regions');
     let $deptField = $('#App_user_departments');
     let $form = $field.closest('form');
  //   let target = '#' + $field.attr('id').replace('city', 'zone').replace('departments', 'city').replace('regions', 'departments').replace('country', 'regions');
  let target = '#' + $field.attr('id').replace('city', 'zone').replace('departments', 'city').replace('regions', 'departments').replace('country', 'regions');

     let data = {};
        data[$countryField.attr('name')] = $countryField.val();
        data[$regionField.attr('name')] = $regionField.val();
        data[$deptField.attr('name')] = $deptField.val();
        data[$field.attr('name')] = $field.val();
        debugger
        $.post($form.attr('action'), data).then(function (data) {
            //debugger
            let $input = $(data).find(target);
            $(target).replaceWith($input);
        })
    });


$(document).on('change', '#App_distinction_classes',
    function(){
     let $field = $(this);
     let $countryField = $('#App_distinction_classes');
  //   let $regionField = $('#App_distinction_student');
    // let $deptField = $('#App_user_departments');
    let $form = $field.closest('form');
    let target = '#' + $field.attr('id').replace('classes', 'student');
    let data = {};
    data[$countryField.attr('name')] = $countryField.val();
    //data[$regionField.attr('name')] = $regionField.val();
    data[$field.attr('name')] = $field.val();
    $.post($form.attr('action'), data).then(function (data) {
        // debugger
        let $input = $(data).find(target);
            $(target).replaceWith($input);
        })
    });


$(document).on('change', '#App_notes_classes',
    function(){
     let $field = $(this);
     let $countryField = $('#App_notes_classes');
  //   let $regionField = $('#App_distinction_student');
    // let $deptField = $('#App_user_departments');
    let $form = $field.closest('form');
    let target = '#' + $field.attr('id').replace('classes', 'students');
    let data = {};
    data[$countryField.attr('name')] = $countryField.val();
    //data[$regionField.attr('name')] = $regionField.val();
    data[$field.attr('name')] = $field.val();
    $.post($form.attr('action'), data).then(function (data) {
        // debugger
        let $input = $(data).find(target);
            $(target).replaceWith($input);
        })
    });


$(document).on('change', '#App_facteurs_disciplinaires_classes',
    function(){
     let $field = $(this);
     let $countryField = $('#App_facteurs_disciplinaires_classes');
  //   let $regionField = $('#App_distinction_student');
    // let $deptField = $('#App_user_departments');
    let $form = $field.closest('form');
    let target = '#' + $field.attr('id').replace('classes', 'students');
    let data = {};
    data[$countryField.attr('name')] = $countryField.val();
    //data[$regionField.attr('name')] = $regionField.val();
    data[$field.attr('name')] = $field.val();
    $.post($form.attr('action'), data).then(function (data) {
        // debugger
        let $input = $(data).find(target);
            $(target).replaceWith($input);
        })
    });




$(document).on('change', '#App_lacunes_classes',
    function(){
     let $field = $(this);
     let $countryField = $('#App_lacunes_classes');
  //   let $regionField = $('#App_distinction_student');
    // let $deptField = $('#App_user_departments');
    let $form = $field.closest('form');
    let target = '#' + $field.attr('id').replace('classes', 'students');
    let data = {};
    data[$countryField.attr('name')] = $countryField.val();
    //data[$regionField.attr('name')] = $regionField.val();
    data[$field.attr('name')] = $field.val();
    $.post($form.attr('action'), data).then(function (data) {
        // debugger
        let $input = $(data).find(target);
            $(target).replaceWith($input);
        })
    });



$(document).on('change', '#App_decisionconseildeclasse_classes',
    function(){
     let $field = $(this);
     let $countryField = $('#App_decisionconseildeclasse_classes');
  //   let $regionField = $('#App_distinction_student');
    // let $deptField = $('#App_user_departments');
    let $form = $field.closest('form');
    let target = '#' + $field.attr('id').replace('classes', 'student');
    let data = {};
    data[$countryField.attr('name')] = $countryField.val();
    //data[$regionField.attr('name')] = $regionField.val();
    data[$field.attr('name')] = $field.val();
    $.post($form.attr('action'), data).then(function (data) {
        // debugger
        let $input = $(data).find(target);
            $(target).replaceWith($input);
        })
    });