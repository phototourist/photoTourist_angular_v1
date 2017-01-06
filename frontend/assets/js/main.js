function amigable(url) {
    var link="";
    url = url.replace("?", "");
    url = url.split("&");

    for (var i=0;i<url.length;i++) {
        var aux = url[i].split("=");
        link +=  "/"+aux[1];
    }

    return "https://projects.com/photoTourist_framework_v2_prettyurls" + link;

  //  return "https://phototourist.josando.tk/photoTourist_framework_v2_prettyurls" + link;

}
