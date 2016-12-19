/**
 * Created by mzh on 10/15/16.
 */
// when the user clicks on the a li,
// toggle between hiding and showing the dropdown content
var dropdowns = document.getElementsByClassName("dropdown");

function toggleDropdown(i, n) {
    // console.log("i=" + i + "; window.dropdowns[i]=" + window.dropdowns[i]);
    window.dropdowns[i].classList.toggle("open");
    // hide other dropdown windows
    for (j = 0; j < n; j++) {
        if (j == i) {
            continue;
        }
        window.dropdowns[j].classList.remove("open");
    }
}
for (var i = 0; i < dropdowns.length; i++) {
    dropdowns[i].onclick = function(i, n) {
        return function () {
            toggleDropdown(i, n);
        }
    }(i, dropdowns.length);
}

// close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.caret') &&
        !event.target.matches('.dropdown-toggle')) {
        // console.log(event.target);
        var dropdowns = document.getElementsByClassName("dropdown");
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('open')) {
                openDropdown.classList.remove('open');
            }
        }
    }
}
