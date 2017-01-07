var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'ui.bootstrap', 'ngCookies', 'facebook']);

app.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider
                // Home
                .when("/", {templateUrl: "frontend/modules/main/view/main.view.html", controller: "mainCtrl"})

                // Contact
               .when("/contact", {templateUrl: "frontend/modules/contact/view/contact.view.html", controller: "contactCtrl"})

               // signup
              .when("/signup", {templateUrl: "frontend/modules/user/view/signup.view.html", controller: "signupCtrl"})

              //Activar Usuario
              .when("/user/activar/:token", {templateUrl: "frontend/modules/main/view/main.view.html", controller: "verifyCtrl"})
                // else 404
                .otherwise("/", {templateUrl: "frontend/modules/main/view/main.view.html", controller: "mainCtrl"});
    }]);

    app.config([
        'FacebookProvider',
        function (FacebookProvider) {
            var myAppId = '1737270923197068';
            FacebookProvider.init(myAppId);
        }
    ]);
