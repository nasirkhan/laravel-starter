// Enable tooltips everywhere
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new coreui.Tooltip(tooltipTriggerEl)
})

// Fix to Select 2 focus issue
// https://github.com/select2/select2/issues/5993
// $(document).ready(function () {
//     document.querySelector('.select2-container--open .select2-search__field').focus();
// });

// document.querySelector('.select2-container--open .select2-search__field').focus();