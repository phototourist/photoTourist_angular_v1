var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'ui.bootstrap', 'ngCookies', 'facebook']);

app.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider
                // Home
                .when("/", {templateUrl: "frontend/modules/main/view/main.view.html", controller: "mainCtrl"})
                
                //cookies
                .when("/cookies", {templateUrl: "frontend/modules/cookies/view/cookies.view.html", controller: "cookiesCtrl"})
                
                // Pages
                .when("/trabaja", {templateUrl: "frontend/modules/main/view/trabaja.view.html", controller: "mainCtrl"})
                .when("/aviso", {templateUrl: "frontend/modules/main/view/aviso.view.html", controller: "mainCtrl"})
                .when("/terminos", {templateUrl: "frontend/modules/main/view/terminos.view.html", controller: "mainCtrl"})
                .when("/politica", {templateUrl: "frontend/modules/main/view/politica.view.html", controller: "mainCtrl"})
                
                // Contact
                .when("/contact", {templateUrl: "frontend/modules/contact/view/contact.view.html", controller: "contactCtrl"})
                
                // Ofertas
                .when("/ofertas", {
                    templateUrl: "frontend/modules/ofertas/view/main.view.html",
                    controller: "ofertasCtrl",
                    resolve: {
                        ofertas: function (services) {
                            return services.get('ofertas', 'maploader');
                        }
                    }
                })
                .when("/ofertas/:id", {
                    templateUrl: "frontend/modules/ofertas/view/oferta.view.html",
                    controller: "detailsCtrl",
                    resolve: {
                        data: function (services, $route) {
                            return services.get('ofertas', 'getOffer', $route.current.params.id);
                        }
                    }
                })
                
                //Signup
                .when("/user/alta/", {
                    templateUrl: "frontend/modules/user/view/signup.view.html",
                    controller: "signupCtrl"
                })
                //Activar Usuario
                .when("/user/activar/:token", {
                    templateUrl: "frontend/modules/main/view/main.view.html",
                    controller: "verifyCtrl"
                })
                
                //Restore
                .when("/user/recuperar", {
                    templateUrl: "frontend/modules/user/view/restore.view.html",
                    controller: "restoreCtrl"
                })
                //ChangePass
                .when("/user/cambiarpass/:token", {
                    templateUrl: "frontend/modules/user/view/changepass.view.html",
                    controller: "changepassCtrl"
                })
                
                //Perfil
                .when("/user/profile/", {
                    templateUrl: "frontend/modules/user/view/profile.view.html",
                    controller: "profileCtrl",
                    resolve: {
                        user: function (services, cookiesService) {
                            var user = cookiesService.GetCredentials();
                            if (user) {
                                return services.get('user', 'profile_filler', user.usuario);
                            }
                            return false;
                        }
                    }
                })
                
                //admin
                .when("/admin/", {
                    templateUrl: "frontend/modules/admin/view/admin.view.html",
                    controller: "adminCtrl"
                })
                .when("/admin/list", {
                    templateUrl: "frontend/modules/admin/view/adminUsers.view.html",
                    controller: "listCtrl",
                    resolve: {
                        user: function (services) {
                            return services.get('user', 'profile_filler', '%%');
                        }
                    }
                })
                .when("/admin/edit/:username", {
                    templateUrl: "frontend/modules/user/view/profile.view.html",
                    controller: "profileCtrl",
                    resolve: {
                        user: function (services,$route) {
                            return services.get('user', 'profile_filler', $route.current.params.username);
                        }
                    }
                })

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
