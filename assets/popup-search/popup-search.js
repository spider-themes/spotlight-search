document.addEventListener("keydown", function (e) {
    let x;
    if (e.shiftKey) x = e.keyCode
    let y = document.getElementById("spotlight_popup_search_wrapper");
    if (x === 191) {
        if (y.style.display === "block") {
            y.style.display = "none";
        } else {
            y.style.display = "block";
        }
    } else if (e.keyCode === 27) {
        y.style.display = "none";
    }
})