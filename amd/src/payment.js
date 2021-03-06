define(['jquery', 'core/ajax', 'core/notification', 'core/url'], function ($, ajax, notification, moodleurl) {
    return {
        init: function () {
        
            $("#create").on("click", function (e) {
               
                var amount = $("#amount").val();
                var emails = $("#emails").val();
                var phone = $("#phone").val();
                var message1 = [];
                if (emails == '') {
                    var msg = 'Please enter email!';
                    message1.push(msg);
                    e.preventDefault();
                    $(document).scrollTop(0);
                    notification.addNotification({
                        type: 'error',
                        message: msg
                    });
                }
                 if (phone == '') {
                    var msg = 'Please enter mobile number!';
                    message1.push(msg);
                    e.preventDefault();
                    $(document).scrollTop(0);
                    notification.addNotification({
                        type: 'error',
                        message: msg
                    });
                }
  if (message1.length >= 1) 
                    {
                      
                    } else{ 

                var promises = ajax.call([
                    {
                        methodname: 'local_subscription_payment_link',
                        args: {
                            amount: amount,
                            emails: emails,
                            phone: phone
                         

                        }
                    }
                ]);
                promises[0].done(function (response) {
                    //console.log("Response:"+response);
                  //  alert(response);
                        Swal.fire({
                              position: 'center',
                              icon: 'success',
                              title: 'Payment link has been send to your parent\'s.',
                              showConfirmButton: true,
                              timer: 50000
                          })    
                               //    window.location.href = moodleurl.relativeUrl("/DIY/");
                 
                }).fail(function () {
                    // message = 'ERROR';
                   Swal.fire({
                              position: 'center',
                              icon: 'fail',
                              title: 'Link not create! Something get wrong',
                              showConfirmButton: true,
                              timer: 50000
                          })    
                   //    window.location.href = moodleurl.relativeUrl("/DIY/");
                  
                });
            }
            });//end of click  
        }
    }
});