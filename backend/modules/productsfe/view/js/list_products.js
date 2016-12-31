function validate_search(search_value) {
    if (search_value.length > 0) {
        var regexp = /^[a-zA-Z0-9 .,]*$/;
        return regexp.test(search_value);
    }
    return false;
}

function refresh() {
    $('.pagination').html = '';
    $('.pagination').val = '';
}

function search(keyword) {
//changes the url to avoid creating another different function
//"index.php?module=products_FE&function=view_error&view_error=false"
    //var urlbase = "modules/products_FE/controller/controller_products_FE.class.php";

    //    url = "../../products_FE/num_pages/", {'num_pages': true}; //index.php?module=products_FE&function=num_pages&num_pages=true";//urlbase + "&num_pages=true";
  //  else
        //url = "../../products_FE/num_pages/", {'num_pages': true, 'keyword': keyword}; //"index.php?module=products_FE&function=num_pages&num_pages=true&keyword=" + keyword;//urlbase + "&num_pages=true&keyword=" + keyword;

    $.post("../productsfe/num_pages/", {'num_pages': true, 'keyword': keyword}, function (data, status) {

    alert(data);
        var json = JSON.parse(data);
        var pages = json.pages;
      //  alert(json.hola);
        //alert(json.o);
        //console.log(pages);
      //  if (!keyword)
        //    url = "index.php?module=products_FE&function=idProduct";
        //else
          //  url = "index.php?module=products_FE&function=idProduct&keyword=" + keyword;
            $("#results").load("../productsfe/idProduct/", {'keyword': keyword});
        //$("#results").load("../../products/idProduct/", {'page_num': num, 'keyword': keyword});

        if (pages !== 0) {
            refresh();

            $(".pagination").bootpag({
                total: pages,
                page: 1,
                maxVisible: 5,
                next: 'next',
                prev: 'prev'
            }).on("page", function (e, num) {
                e.preventDefault();

                  $("#results").load("../productsfe/idProduct/", {'page_num': num, 'keyword': keyword});
/*
                if (!keyword)
                    $("#results").load("index.php?module=products_FE&function=idProduct", {'page_num': num});
                else
                    $("#results").load("index.php?module=products_FE&function=idProduct", {'page_num': num, 'keyword': keyword});
*/
                reset();
            });
        } else {
          $("#results").load("../productsfe/view_error/", {'view_error': false});
          //  $("#results").load("index.php?module=products_FE&function=view_error&view_error=false"); //view_error=false
            $('.pagination').html('');
            reset();
        }
        reset();

    }).fail(function (xhr) {
      alert("error");

        $("#results").load("../productsfe/view_error/", {'view_error': true});
        //$("#results").load("index.php?module=products_FE&function=view_error&view_error=true");
        $('.pagination').html('');
        reset();
    });
}



function search_product(keyword) {
    $.post("../productsfe/nom_product/", {'nom_product': keyword}, function (data, status) {
      //alert("jorddd " + data);
        var json = JSON.parse(data);
        var product = json.product_autocomplete;

        $('#results').html('');
        $('.pagination').html('');

        var img_product = document.getElementById('img_product');
        img_product.innerHTML = '<img src="../../' + product[0].Avatar + '" class="img-product"> ';
        var nom_product = document.getElementById('nom_product');
        nom_product.innerHTML = product[0].Products_name;
        var desc_product = document.getElementById('desc_product');
        desc_product.innerHTML = product[0].Description;
        var price_product = document.getElementById('price_product');
        price_product.innerHTML = "Precio: " + product[0].Price + " €";
        price_product.setAttribute("class", "special");

    }).fail(function (xhr) {
        $("#results").load("../productsfe/view_error_false/", {'view_error': false});//"modules/products_FE/controller/controller_products_FE.class.php?view_error=false");
        $('.pagination').html('');
        reset();
    });
}

function count_product(keyword) {
//  alert(keyword);
    $.post("../productsfe/count_product/", {'count_product': keyword}, function (data, status) {
      //alert("lalala " +data);
        var json = JSON.parse(data);
        var num_products = json.num_products;
        //alert(json.loadmodel);
        //alert("criteria"+json.criteria);
      //  alert("colums"+json.colums);
      //  alert("like"+json.like);
      //  alert("load"+json.loadmodel);
        //alert("num_products: " + num_products);

        if (num_products == 0) {
          //alert("0");
            $("#results").load("../productsfe/view_error/", {'view_error': false});
          //  $("#results").load("index.php?module=products_FE&function=view_error&view_error=false"); //view_error=false
            $('.pagination').html('');
            reset();
        }
        if (num_products == 1) {
          //alert("=1");
            search_product(keyword);
        }
        if (num_products > 1) {
          //alert(">1");
            search(keyword);
        }
    }).fail(function () {
        $("#results").load("../productsfe/view_error/", {'view_error': true});
      //  $("#results").load("index.php?module=products_FE&function=view_error&view_error=true"); //view_error=false
        $('.pagination').html('');
        reset();
    });
}

function reset() {
    $('#img_product').html('');
    $('#nom_product').html('');
    $('#desc_product').html('');
    $('#price_product').html('');
    //$('#price_product').removeClass("special");

    $('#keyword').val('');
}


$(document).ready(function () {
    ////////////////////////// inici carregar pàgina /////////////////////////


    if (getCookie("search")) {
        var keyword=getCookie("search");
        count_product(keyword);
        alert("carrega pagina getCookie(search): " + getCookie("search"));
       //("#keyword").val(keyword) if we don't use refresh(), this way we could show the search param
        setCookie("search","",1);
    } else {
        search();
    }


    $("#search_prod").submit(function (e) {
        var keyword = document.getElementById('keyword').value;
        var v_keyword = validate_search(keyword);
        if (v_keyword)
            setCookie("search", keyword, 1);
        alert("getCookie(search): " + getCookie("search"));
        location.reload(true);


        //si no ponemos la siguiente línea, el navegador nos redirecciona a index.php
        e.preventDefault(); //STOP default action
    });

    $('#Submit').click(function () {
        var keyword = document.getElementById('keyword').value;
        var v_keyword = validate_search(keyword);
        if (v_keyword)
            setCookie("search", keyword, 1);
        alert("getCookie(search): " + getCookie("search"));
        location.reload(true);

    });//"index.php?module=users&function=load_users&load=true"
//modules/products_FE/controller/controller_products_FE.class.php?

    $.post("../productsfe/autocomplete/", {'autocomplete': true}, function (data, status) {
    //$.get("index.php?module=products_FE&function=autocomplete&autocomplete=true", function (data, status) {
  //alert(data);
        var json = JSON.parse(data);

        var nom_productos = json.nom_productos;

        //console.log(nom_productos);

        var suggestions = new Array();
        for (var i = 0; i < nom_productos.length; i++) {
            suggestions.push(nom_productos[i].Products_name);
        }
        //alert(suggestions);
        //console.log(suggestions);

        $("#keyword").autocomplete({
            source: suggestions,
            minLength: 1,
            select: function (event, ui) {
                //alert(ui.item.label);

                var keyword = ui.item.label;
                //alert("product");
                count_product(keyword);
            }
        });
    }).fail(function (xhr) {
        $("#results").load("../productsfe/view_error/", {'view_error': true});
        //$("#results").load("index.php?module=products_FE&function=view_error&view_error=false"); //view_error=false
        $('.pagination').html('');
        reset();
    });

});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1);
        if (c.indexOf(name) == 0)
            return c.substring(name.length, c.length);
    }
    return 0;
}


//comparacion lo que teniamos antes con lo de ahora que esta todo en funciones
/*
$(document).ready(function () {
    $.get("modules/products_FE/controller/controller_products_FE.class.php?num_pages=true", function (data, status) {
        var json = JSON.parse(data);
        var pages = json.pages;
        console.log(json);
          console.log(json);


        $("#results").load("modules/products_FE/controller/controller_products_FE.class.php"); //load initial records

        // init bootpag
        $(".pagination").bootpag({
            total: pages,
            page: 1,
            maxVisible: 3,
            next: 'next',
           prev: 'prev'
        }).on("page", function (e, num) {
            //alert(num);
            e.preventDefault();
            //$("#results").prepend('<div class="loading-indication"><img src="modules/services/view/img/ajax-loader.gif" /> Loading...</div>');
            $("#results").load("modules/products_FE/controller/controller_products_FE.class.php", {'page_num': num});

            // ... after content load
            /*$(this).bootpag({
             total: pages,
             maxVisible: 7
             });*/
             /*
        });

    }).fail(function (xhr) {
        //console.log(xhr.status);
        //die();
        //var json = JSON.parse(xhr.responseText);
        //alert(json.error);

        //if (xhr.responseText !== undefined && xhr.responseText !== null) {
        //var json = JSON.parse(xhr.responseText);
        //if (json.error !== undefined && json.error !== null) {
        //$("#results").text(json.error);

        //if  we already have an error 404
        if(xhr.status  === 404){
            $("#results").load("modules/products_FE/controller/controller_products_FE.class.php?view_error=false");
        }else{
            $("#results").load("modules/products_FE/controller/controller_products_FE.class.php?view_error=true");
        }

        //}
        //}
    });
});
*/
