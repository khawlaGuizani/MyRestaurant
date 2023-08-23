
(function () {
    "use strict";

    let forms = document.querySelectorAll('.php-email-form');

    forms.forEach(function (e) {
        e.addEventListener('submit', function (event) {
            event.preventDefault();
            let thisForm = this;

            thisForm.querySelector('.loading').classList.add('d-block');
            thisForm.querySelector('.error-message').classList.remove('d-block');
            thisForm.querySelector('.sent-message').classList.remove('d-block');

            let checks = {
                name: document.getElementById("name"),
                email: document.getElementById("email"),
                subject: document.getElementById("subject"),
                message: document.getElementById("message")
            },
                error = "";


            // Ajax
            if (error != "") {
                error = "";
            } else {
                let data = new FormData(thisForm);
                for (let k in checks) {
                    data.append(k, checks[k].value);
                }


                fetch("forms/contact.php", {
                    method: "POST",
                    body: data
                })
                    .then(function (response) {
                        if (response.status) {
                            return response.text();
                        }
                    })
                    .then(data => {
                        data.split(thisForm.querySelector('.loading').classList.remove('d-block'));
                        data.split(thisForm.querySelector('.sent-message').classList.add('d-block'));

                    })
                    .catch(error => {
                        displayError(thisForm, error);
                    })
                thisForm.reset(data);

            }
            return false;
        });
    });

    function displayError(thisForm, error) {
        thisForm.querySelector('.loading').classList.remove('d-block');
        thisForm.querySelector('.error-message').innerHTML = error;
        thisForm.querySelector('.error-message').classList.add('d-block');
    }


})();
