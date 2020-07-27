
//https://www.sitepoint.com/basic-jquery-form-validation-tutorial/
// Validation for CREATE
$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("#customerform").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      cus_name: "required",
      address1: "required",
      email: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true
      },
      phone: {
        required:true,
        number:true,
        maxlength:15
      },
      status: "required"
    },
    
    // Specify validation error messages
    messages: {
      cus_name: "Please enter the customer name",
      address1: "Please provide at least one line of address",
      email: "Please enter a valid email address",
      phone: {
          required: 'Please provide a phone number',
          number: "Please put numbers only, without space",
          maxlength: 'Phone number cannot exceed 15 Characters.'
      }
      
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});
