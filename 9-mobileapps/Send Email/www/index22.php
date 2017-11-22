<!DOCTYPE html>
<html>
  <head>
    <title>My App</title>
    <meta name="viewport" content="width=device-width,
                                   initial-scale=1.0,
                                   maximum-scale=1.0,
                                   user-scalable=no,
                                   minimal-ui">
    <link rel="stylesheet" href="app.min.css">
    <style>
      #contactList, #contactList ul li  {
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="app-page" data-page="home"> <!-- Start Contacts Page -->
      <div class="app-topbar">
          <div class="app-title">Send An Email</div>
      </div>
      <div class="app-content">
        <div class="app-section">
            <p>Click below to send an email!</p>
        </div>
        <div id="contactList"></div>
        <div class="app-section">
            <div id="btnNewUser" class="app-button" onclick="clearEmail()" data-target="email">Send to new user</div>
        </div>
      </div>
    </div> <!-- End Contacts Page -->

    <div class="app-page" data-page="email"> <!-- Start Email Page -->
      <div class="app-topbar">
          <div class="app-button" data-target="home">Go back</div>
          <div class="app-title">Send Email</div>
      </div>
      <div class="app-content">
        <div id="errors"></div>
        <form id="sendEmail">
            <div class="app-section">
              <p>From:</p>
              <input id="fromEmail" class="app-input" placeholder="From email">
            </div>
            <div class="app-section">
              <p>To:</p>
              <input id="toEmail" class="app-input" placeholder="To email">
            </div>
            <div class="app-section">
              <input id="emailSubject" class="app-input" placeholder="Subject">
              <textarea id="emailMessage" class="app-input" placeholder="Message"></textarea>
              <div class="app-button green" id="submitForm">Send</div>
            </div>
        </form>
      </div>
    </div> <!-- End Email Page -->



    <script src="zepto.js"></script>
    <script src="app.min.js"></script>
    <script>
        
        var contactEmail = ""; 

        function clearEmail() {
            contactEmail = "";
        }

        function setEmail() {

            // contactEmail = $(this).text();
            // console.log(contactEmail);

        }



        // Start home page app controller end.
        App.controller('home', function (page) {

            if (localStorage.getItem("contactList")) {

                var contactListArray = JSON.parse(localStorage.getItem("contactList"));

                var contactListSection = [];

                for (email in contactListArray) {

                    contactListSection += "<li class='app-button email'>" + contactListArray[email] + "</li>";

                }

                $(page).find('#contactList').html("<div class='app-section'><p>Contact list:</p><ul class='app-list'>" + contactListSection + "</ul></div>");

            }


            // <div id="btnNewUser" class="app-button" onclick="clearEmail()" data-target="email">Send to new user</div>




            // Set email variable to the email that was clicked. This email will prepopulate the to: in the send email page. 
            // $(page).find('.email').click(function () {
               
            //     contactEmail = $(this).text();

            // });

        }); 
        // End home page app controller end.


        // Start email page app controller end.
        App.controller('email', function (page) {

            $(page).find("#toEmail").val(contactEmail);

            $(page).find('#submitForm').click(function() {

                if ($("#fromEmail").val() == "" || $("#toEmail").val() == "" || $("#emailSubject").val() == "" || $("#emailMessage").val() == "") {

                    $("#errors").html("<div class='app-section'><p>Please complete every field.</p></div>");

                } else {

                    var fromEmail = $("#fromEmail").val();
                    var toEmail = $("#toEmail").val();
                    var emailSubject = $("#emailSubject").val();
                    var emailMessage = $("#emailMessage").val();

                    $.ajax({
                        url: "http://miyazaki-wb-com.stackstaging.com/9-mobileapps/sendemail.php",
                        type: "POST",
                        data: 
                            { 
                                fromEmail: fromEmail, 
                                toEmail: toEmail,
                                emailSubject: emailSubject, 
                                emailMessage: emailMessage 
                            },
                        success: function(data) {

                            var resultJson = JSON.parse(data);

                            if (resultJson.result == "success") {

                                $("#errors").html("<div class='app-section'><p>Your email was sent successfully!</p></div>");

                                // CLear form

                                $("#toEmail").val("");
                                $("#emailSubject").val("");
                                $("#emailMessage").val("");

                                // Check if contactList is already in local storage

                                if (!localStorage.getItem("contactList")) {

                                    var contactList = [];

                                    var contactList = JSON.stringify(contactList);

                                    localStorage.setItem("contactList", contactList);

                                }

                                var contactListArray = JSON.parse(localStorage.getItem("contactList"));

                                var emailToAdd = toEmail;

                                // Add email to local storage if it doesn't already exist. 

                                if ($.inArray(emailToAdd,contactListArray) == -1) {

                                    contactListArray.push(emailToAdd);

                                    contactListJson = JSON.stringify(contactListArray);

                                    localStorage.setItem("contactList", contactListJson);

                                }

                            } else {

                                $("#errors").html("<div class='app-section'><p>An error occurred. Please try again.</p></div>");

                            }

                        }

                    });

                }

            })

        }); 
        // End email page app controller end.



        App.load('home');





    </script>
  </body>
</html>