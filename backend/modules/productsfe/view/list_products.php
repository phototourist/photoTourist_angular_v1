<!--Se cambia la extension del archivo a un simple html-->
<script type="text/javascript" src="<?php echo PRODUCTS_JS_PATH ?>jquery.bootpag.min.js"></script>
<script type="text/javascript" src="<?php echo PRODUCTS_JS_PATH ?>list_products.js" ></script>

<div id="main">

        <h2>LISTADO DE FOTOGRAFIAS</h2>
        <p class="lead">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

        <!-- No vamos a utilizar modal ya que da problemas-->

        <center>
          <form name="search_prod" id="search_prod" class="search_prod">
          <input type="text" value="" placeholder="Search Product ..." class="input_search" id="keyword" list="datalist">
    <!-- <div id="results_keyword"></div> -->
          <input value="Search" name="Submit" id="Submit" class="button_search" type="button" />
          </form>
        </center>

        <br>
        <br>
        <div id="results"></div>
        <br>
        <br>
        <center>
            <div class="pagination"> </div>
        </center>

        <section >

        <div class="media">
            <div class="pull-left">
                <div id="img_product" class="img_product"></div>
            </div>
            <div class="media-body">
                <div id="text-product">
                <h3 class="media-heading title-product"  id="nom_product"></h3>
                <p class="text-limited" id="desc_product" ></p>
                <br>
                <h5 > <strong  id="price_product"></strong> </h5>
                </div>

            </div>
        </div>

</section>

</div>
<!-- Tweet -->
<div id="tweet">
  <div class="container">
    <section>
      <blockquote>&ldquo;In posuere eleifend odio. Quisque semper augue mattis wisi. Maecenas ligula. Pellentesque viverra vulputate enim. Aliquam erat volutpat.&rdquo;</blockquote>
    </section>
  </div>
</div>
<!-- /Tweet -->
