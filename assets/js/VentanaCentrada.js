function ventanaCentrada(url, titulo, ancho, alto) {
    var left = (screen.width / 2) - (ancho / 2);
    var top = (screen.height / 2) - (alto / 2);
    return window.open(url, titulo, "width=" + ancho + ",height=" + alto + ",top=" + top + ",left=" + left);
}
