var searchInput = document.getElementById('search-input');
var searchButton = document.getElementById('search-button');

searchInput.addEventListener('hover', function () {
    searchButton.classList.add('focused-search');
});
searchInput.addEventListener('blur', function () {
    searchButton.classList.remove('focused-search');
});