//we do this so that  details_prod don't appear
//$("#details_prod").hide();
$(document).ready(function () {
    $('.product_name').click(function () {
        var id = this.getAttribute('id');
        //alert(id);
        console.log(id);
          $.post("../productsfe/idProduct/", {'idProduct': id}, function (data, status) {
        //$.get("index.php?module=products_FE&function=idProduct&idProduct=" + id, function (data, status) {
            var json = JSON.parse(data);
            var product = json.product;
            //alert(product.name);
            console.log(id);
            console.log(product);

            $('#results').html('');
            $('.pagination').html('');

            var img_product = document.getElementById('img_product');
            img_product.innerHTML = '<img src="../' + product.Avatar + '" class="img-product"> ';

            var nom_product = document.getElementById('nom_product');
            nom_product.innerHTML = product.Products_name;
            var desc_product = document.getElementById('desc_product');
            desc_product.innerHTML = product.Description;
            var price_product = document.getElementById('price_product');
            price_product.innerHTML = "Precio: " + product.Price + " €";
            price_product.setAttribute("class", "special");



        })
                .fail(function (xhr) {
                    //if  we already have an error 404
                    if (xhr.status === 404) {
                        $("#results").load("../productsfe/view_error/", {'view_error': false});
                    } else {
                        $("#results").load("../productsfe/view_error/", {'view_error': true});
                    }
                    ;
                });
    });
});
