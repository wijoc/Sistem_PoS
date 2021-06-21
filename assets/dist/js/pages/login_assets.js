$(document).ready(function(){
    $("#form-login").on("submit", function(event) {
        event.preventDefault();
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $(this).serialize(),
            datatype    : 'json',
            beforeSend  : function(){
                $(this).prop("disabled", true)
            },
            success     : function(result){
                if(result.error){
                    /** Error username */
                        if(result.errorUsername){
                            $("#input-username").addClass('is-invalid')
                            $("#error-username").css("display", "block")
                            $("#error-username").html(result.errorUsername)
                        } else {
                            $("#input-username").removeClass('is-invalid')
                            $("#error-username").css("display", "none")
                        }
                    
                    /** Error Password */
                        if(result.errorPassword){
                            $("#input-password").addClass('is-invalid')
                            $("#error-password").css("display", "block")
                            $("#error-password").html(result.errorPassword)
                        } else {
                            $("#input-password").removeClass('is-invalid')
                            $("#error-password").css("display", "none")
                        }
                } else {
                    window.location.replace(result.redirect);
                }
            },
            error: function(jqxhr, status, exception) {
                alert('Exception:', exception);
            }
        })
    })
})