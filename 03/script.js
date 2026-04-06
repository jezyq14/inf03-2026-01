const $ = (sel) => document.querySelector(sel);

/* Skrypt 1 */
function change(image) {
    $(".big-image").setAttribute("src", image);
}

/* Skrypt 2 */
function count() {
    const currentImage = $(".big-image").getAttribute("src");

    const a = parseFloat($("#a").value);
    const b = parseFloat($("#b").value);

    let output = a * b;
    if (currentImage == "1d.bmp") output /= 2;

    $(".output").textContent = output;
}
