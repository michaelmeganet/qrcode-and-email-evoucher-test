
//https://www.sitepoint.com/basic-jquery-form-validation-tutorial/
// Validation for CREATE
$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("#userform").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      name: "required",
      username: {
          required: true,
          minlength: 6
      },
      password: {
        required: true,
        minlength: 8,
        maxlength: 16
      },
      password_confirm:{
          required: true,
          minlength: 8,
          maxlength: 16,
          equalTo: "#password"
      }
    },
    
    // Specify validation error messages
    messages: {
      name: "Please enter the name",
      username: {
          required: "Please provide a username",
          minlength: "Username must have a minimum of 6 characters"
      },
      password: {
          required: "Please provide a password",
          minlength: "Password must have 8-16 Characters",
          maxlength: "Password must have 8-16 Characters"
      },
      password_confirm: {
          required: "Please retype the password",
          minlength: "Password must have 8-16 Characters",
          maxlength: "Password must have 8-16 Characters",
          equalTo: "Password is not the same"
      }
      
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});
