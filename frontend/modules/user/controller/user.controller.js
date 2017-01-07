app.controller('menuCtrl', function ($scope, $uibModal, UserService, $rootScope, $anchorScroll) {
    UserService.login();
    $rootScope.bannerV = false;
    $rootScope.bannerText = "";
/*
    $scope.open = function () {
        var modalInstance = $uibModal.open({
            animation: 'true',
            templateUrl: 'frontend/modules/user/view/modal.view.html',
            controller: 'modalWindowCtrl',
            size: "lg"
        });
    };
*/
    $scope.logout = function () {
        UserService.logout();
    };

    //scrollup está en footer.php
    //en arriba.js visualiza scrollup
    //redirigir scrollup al top de la pagina
    $scope.toTheTop = function () {
        $anchorScroll();
    };

});


app.controller('signupCtrl', function ($scope, services, $location, $timeout, CommonService) {
  console.log(CommonService);
    $scope.signup = {
        inputEmail: "",
        inputPass: ""
        //inputType: "client"
    };

    $scope.error = function() {
        $scope.signup.email_error = "";
        $scope.signup.pass_error = "";
    };

    $scope.change_signup = function () {
        $scope.signup.email_error = "";
        $scope.signup.pass_error = "";
    };
/*
    $('.modal').remove();
    $('.modal-backdrop').remove();
    $("body").removeClass("modal-open");
*/
    $scope.SubmitSignUp = function () {
      console.log("singup");
        var data = {"email": $scope.signup.inputEmail,"pass": $scope.signup.inputPass,
            };
        var data_users_JSON = JSON.stringify(data);
        services.post('users', 'signup_user', data_users_JSON).then(function (response) {
            console.log(response);
            if (response.success) {
                $timeout(function () {
                    $location.path('/');
                    CommonService.banner("El usuario se ha dado de alta correctamente, revisa su correo para activarlo", "");
                }, 2000);
            } else {
                if (response.typeErr === "Name") {
                    $scope.AlertMessage = true;
                    $timeout(function () {
                        $scope.AlertMessage = false;
                    }, 5000);
                    $scope.signup.user_error = response.error;

                } else if (response.typeErr === "Email") {
                    $scope.AlertMessage = true;
                    $timeout(function () {
                        $scope.AlertMessage = false;
                    }, 5000);
                    $scope.signup.email_error = response.error;

                } else if (response.typeErr === "error") {
                    console.log(response.error.error.pass);
                    $scope.AlertMessage = true;
                    $timeout(function () {
                        $scope.AlertMessage = false;
                    }, 5000);
                    $scope.signup.email_error = response.error.error.email;
                    $scope.signup.pass_error = response.error.error.pass;

                } else if (response.typeErr === "error_server"){
                    CommonService.banner("Error en el servidor", "Err");
                }
            }
            console.log(CommonService);
        });
    };
});

app.controller('verifyCtrl', function (UserService, $location, CommonService, $route, services, cookiesService) {
    var token = $route.current.params.token;
    if (token.substring(0, 3) !== 'Ver') {
        CommonService.banner("Ha habido algún tipo de error con la dirección", "Err");
        $location.path('/');
    }
    services.get("users", "activar", token).then(function (response) {
        console.log(response);
        if (response.success) {
            CommonService.banner("Su cuenta ha sido satisfactoriamente verificada", "");
            //cookiesService.SetCredentials(response.user[0]);
            UserService.login();
            $location.path('/');
        } else {
            if (response.datos == 503){
                CommonService.banner("Error, intentelo mas tarde", "Err");
                $location.path("/");
            }else if (response.error == 404){
                CommonService.banner("Error, intentelo mas tarde", "Err");
                $location.path("/");
            }
        }
    });
});
