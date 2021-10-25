/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/message.js ***!
  \*********************************/
var receiverListItemClick = function receiverListItemClick() {
  $(this).addClass('bg-primary-500-light shadow-md').removeClass('hover:bg-white');
};

$(document).ready(function () {
  $('.receiver-list-item').on('click', receiverListItemClick);
});
/******/ })()
;