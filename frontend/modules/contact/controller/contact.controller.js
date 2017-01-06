app.controller('contactCtrl', function($scope, services) {
    $scope.contact = {
        inputName: "",
        inputEmail: "",
        inputSubject: "",
        inputMessage: ""
    };

    $scope.loader = {
loading: false,
 };

    $scope.SubmitContact = function() {
        var data = {
            "inputName": $scope.contact.inputName,
            "inputEmail": $scope.contact.inputEmail,
            "inputSubject": $scope.contact.inputSubject,
            "inputMessage": $scope.contact.inputMessage,
            "token": 'contact_form'
        };
        var contact_form = JSON.stringify(data);
        $scope.loader.loading = true ;
        services.post('contact', 'process_contact', contact_form).then(function(response) {
            response = response.split("|");
            console.log(response[0]);
            $scope.message = response[1];
            if (response[0] == "true") {
                $scope.class = 'alert alert-error';
            } else {
              $scope.class = 'alert alert-success';
            }
            $scope.loader.loading = false;
        });

    };
});
