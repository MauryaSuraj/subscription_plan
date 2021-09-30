$(document).ready(function(){
   alert('dsfsdsd');
        $.ajax({
            url: "ajax.php",
            type: 'post',
            async: true,
            data: {
                grade: 1,
                student: 1
            },
            //dataType:'text',
            success: function (result) {
          alert(result);   
                if (result == 'email_not_valid') {
                  var email_not_valid = document.getElementById("email_not_valid");
                  email_not_valid.classList.remove("hidden");
        // document.getElementById('student_name').classList.remove('hidden');
        setTimeout(function() {
          email_not_valid.classList.add("hidden");

      }, 3000)

    } 
}
});
//    var current_fs, next_fs, previous_fs;
//
//// No BACK button on first screen
//if($(".show").hasClass("first-screen")) {
//    $(".prev").css({ 'display' : 'none' });
//}
//
//// Next button
//$(".next-button").click(function(){
//
//
//    current_fs = $(this).parent().parent();
//    next_fs = $(this).parent().parent().next();
//
//    $(".prev").css({ 'display' : 'block' });
//
//    $(current_fs).removeClass("show");
//    $(next_fs).addClass("show");
//
//    $("#progressbar li").eq($(".card2").index(next_fs)).addClass("active");
//
//    current_fs.animate({}, {
//        step: function() {
//
//            current_fs.css({
//                'display': 'none',
//                'position': 'relative'
//            });
//
//            next_fs.css({
//                'display': 'block'
//            });
//        }
//    });
//});
//
//// Previous button
//$(".prev").click(function(){
//
//    var element = document.getElementById("slot_span");
//    element.classList.add("hidden");
//    var element1 = document.getElementById("date_span");
//    element1.classList.add("hidden");
//
//    current_fs = $(".show");
//    previous_fs = $(".show").prev();
//
//    $(current_fs).removeClass("show");
//    $(previous_fs).addClass("show");
//
//    $(".prev").css({ 'display' : 'block' });
//
//    if($(".show").hasClass("first-screen")) {
//        $(".prev").css({ 'display' : 'none' });
//    }
//
//    $("#progressbar li").eq($(".card2").index(current_fs)).removeClass("active");
//
//    current_fs.animate({}, {
//        step: function() {
//
//            current_fs.css({
//                'display': 'none',
//                'position': 'relative'
//            });
//
//            previous_fs.css({
//                'display': 'block'
//            });
//        }
//    });
//});
//$('.cst-tb1').click(function(){
//    $(this).addClass('active');
//    $('.cst-tb2').removeClass('active');
//});
//$('.cst-tb2').click(function(){
//    $(this).addClass('active');
//    $('.cst-tb1').removeClass('active');
//});
//$('.wht-alertBox label').click(function(){
//    $('.wht-alertBox label').removeClass('active');
//    $(this).addClass('active');
//});
//$('.or-alertBox label').click(function(){
//    $('.or-alertBox label').removeClass('active');
//    $(this).addClass('active');
//});
//
//$(".submitbutton_first").click(function() {
//
//    var subject = $('.li_subject').find('label.active').attr('data-value');
//    var kidsgrade = $('.kids_data').find('label.active').attr('data-value');
//    var laptop = $("input[type='radio'][name='laptop']:checked").val();
//    $.post("ajax.php", {subject:subject, kidsgrade:kidsgrade});
//    $.ajax({
//        url: "ajax.php",
//        type: 'post',
//        async: true,
//        data: {
//            type: 'firstpage',
//            subject: subject,
//            kidsgrade: kidsgrade,
//            laptop: laptop
//        },
//        dataType:'text',
//        success: function (result) {
//
//        }
//    });
//
//});
//$(".dates").click(function() {
//
//    document.getElementById('date_name_chnages').innerHTML = "";
//    var input = $(this).find('input').attr('data-value');
//    document.getElementById('date_name_chnages').innerHTML = input;
//
//});
//$(".submitbutton_final").click(function() {
//
//    // alert('hiiiiiiiii');
//
//    // var date_value = $('.dates').find('input').val();
//    var date_value = $('.dates_div').find('label.active').attr('data-value');
//    var slot = $('.slot_data').find('label.active span input').attr('data-value');
//    var c_code =  document.getElementById("co_code").value;
//    var contect_number =  document.getElementById("contect").value;
//    var student_name =  document.getElementById("student_name").value;
//    var parent_name =  document.getElementById("parent_name").value;
//    var email =  document.getElementById("email").value;
//
//    if (date_value == undefined) {
//      var element = document.getElementById("date_span");
//      element.classList.remove("hidden");
//
//  } else if (slot == undefined) {
//
//      var element = document.getElementById("slot_span");
//      element.classList.remove("hidden");
//
//  } else if (student_name == '') {
//      var element = document.getElementById("student_name_span");
//      element.classList.remove("hidden");
//        // document.getElementById('student_name').classList.remove('hidden');
//        setTimeout(function() {
//          element.classList.add("hidden");
//
//      }, 3000)
//    } else if (parent_name == '') {
//      var element = document.getElementById("parent_name_span");
//      element.classList.remove("hidden");
//        // document.getElementById('student_name').classList.remove('hidden');
//        setTimeout(function() {
//          element.classList.add("hidden");
//
//      }, 3000)
//    } else if (email == '') {
//      var element = document.getElementById("email_span");
//      element.classList.remove("hidden");
//        // document.getElementById('student_name').classList.remove('hidden');
//        setTimeout(function() {
//          element.classList.add("hidden");
//
//      }, 3000)
//    } else {
//        // alert(subject);
//        $.ajax({
//            url: "ajax.php",
//            type: 'post',
//            async: true,
//            
//            data: {
//                grade: 1,
//                stdent: 1
//               
//            },
//            //dataType:'text',
//            success: function (result) {
//              
//                if (result == 'email_not_valid') {
//                  var email_not_valid = document.getElementById("email_not_valid");
//                  email_not_valid.classList.remove("hidden");
//        // document.getElementById('student_name').classList.remove('hidden');
//        setTimeout(function() {
//          email_not_valid.classList.add("hidden");
//
//      }, 3000)
//
//    } else if (result == 'success') {
//     $("#getCodeModal").modal('show');
//     setTimeout(function() {
//      location.reload();
//
//  }, 5000)
// }
//
//}
//});
//    }
//
//});
});


