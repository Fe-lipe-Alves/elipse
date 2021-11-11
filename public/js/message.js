/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/message.js ***!
  \*********************************/
var last = 0,
    activeUser = null;

var dateFormat = function dateFormat(stringDate) {
  var date = new Date(stringDate),
      day = date.getDate().toString(),
      dayF = day.length === 1 ? '0' + day : day,
      month = (date.getMonth() + 1).toString(),
      monthF = month.length === 1 ? '0' + month : month,
      yearF = date.getFullYear(),
      hour = date.getHours(),
      minutes = date.getMinutes(),
      seconds = date.getSeconds();
  return dayF + "/" + monthF + "/" + yearF + " " + hour + ":" + minutes + ":" + seconds;
},
    insertMessage = function insertMessage(message) {
  var end = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
  var receiver_id = $('#receiver_id').val(),
      send = message.sender_id !== parseInt(receiver_id),
      content = '',
      created_at = dateFormat(message.created_at);

  if (message.file) {
    if (message.files !== null) {
      var images = ['PNG', 'JPG', 'JPEG', 'GIF'];

      if (images.indexOf(message.files.type.toUpperCase()) > -1) {
        content = '<a href="' + message.files.source + '" target="_blank">' + '<img src="' + message.files.source + '" class="max-w-full" title="' + message.files.name + '" alt="' + message.files.name + '"/>' + '</a>';
      } else {
        content = '<a href="' + message.files.source + '">' + '<span>' + message.files.name + '</span>' + '</a>';
      }
    } else {
      content = '<p><small class="text-sm text-red-300">Erro ao obter arquivo.</small></p>';
    }
  } else {
    content = '<p class="text-sm">' + message.content + '</p>\n';
  }

  var html = '<div class="w-full flex flex-col ' + (send ? 'items-end' : '') + '">\n' + '<div class="w-8/12 px-4 py-2 ml-1 mr-2  rounded-lg shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150 ' + (send ? 'bg-white' : 'bg-primary-500-light') + (last === message.sender_id ? ' mt-1' : 'mt-3') + '">\n' + content + '<small class="text-xxs ' + (send ? 'float-right' : '') + '">' + created_at + '</small>\n' + '</div>\n' + '</div>';

  if (end) {
    $('#history').append(html);
  } else {
    $('#history').prepend(html);
  }
};

receiverListItemClick = function receiverListItemClick() {
  if (!$(this).data('active')) {
    activeUser = $(this).data('id');
    $('.receiver-list-item').each(function (index, item) {
      $(item).removeClass('bg-primary-500-light shadow-md').addClass('hover:bg-white').data('active', false);
    });
    $(this).addClass('bg-primary-500-light shadow-md').removeClass('hover:bg-white').data('active', true);
    $('#receiver_id').val($(this).data('id'));
    $('#history').html('');
    showLoadingHistory();
    $.get($(this).data('route')).then(function (response) {
      if (response.success) {
        response.messages.forEach(function (message) {
          insertMessage(message);
        });
        showHistory();
      }
    });
  }
}, showHistory = function showHistory() {
  $('#newMessage, #history').removeClass('hidden');
  $('#emptyHistory, #loadingHistory').addClass('hidden');
}, showLoadingHistory = function showLoadingHistory() {
  $('#newMessage, #history, #emptyHistory').addClass('hidden');
  $('#loadingHistory').removeClass('hidden');
}, checkContent = function checkContent() {
  return $('#text-new-message').val() !== '' || $('#files')[0].files.length > 0;
}, checkContentSend = function checkContentSend() {
  if (checkContent()) {
    $('#btn-send').removeClass('bg-white').addClass('bg-primary-500').prop('disabled', false);
  } else {
    $('#btn-send').addClass('bg-white').removeClass('bg-primary-500').prop('disabled', true);
  }
}, changeBoxInputFile = function changeBoxInputFile() {
  var boxFile = $('#box-files-name'),
      boxInput = $('#box-input-text'),
      inputFiles = $('#files'),
      countFiles = inputFiles[0].files.length;
  $('#text-new-message').val('');

  if (countFiles > 0) {
    var names = [];
    $(inputFiles[0].files).each(function (index, item) {
      names.push(item.name);
    });
    names = names.join(', ');
    boxInput.addClass('hidden');
    boxFile.removeClass('hidden');
    boxFile.find('#length').text(countFiles);
    boxFile.find('#files-name').html(names).attr('title', names);
  } else {
    boxInput.removeClass('hidden');
    boxFile.addClass('hidden');
  }
}, sendMessage = function sendMessage() {
  var form = $('#newMessage'),
      formData = new FormData(form[0]);
  $('#text-new-message').val('');
  $('#files').val('').change();
  $.ajax({
    url: form.attr('action'),
    type: 'post',
    data: formData,
    async: false,
    cache: false,
    contentType: false,
    enctype: 'multipart/form-data',
    processData: false,
    dataType: 'json',
    success: function success(response) {
      if (response.success) {
        response.messages.forEach(function (message) {
          insertMessage(message, true);
        });
        showHistory();
      }
    }
  });
}, loadMessage = function loadMessage(message) {
  console.log(message);

  if (activeUser !== null && message.sender_id === activeUser) {
    insertMessage(message, true);
  } else {
    $('.receiver-list-item').each(function (index, item) {
      if ($(item).data('id') === message.sender_id) {
        var _parseInt;

        var span = $(item).find('.qtNew'),
            quantity = ((_parseInt = parseInt(span.data('quantity'))) !== null && _parseInt !== void 0 ? _parseInt : 0) + 1;
        span.text(quantity + ' ' + (quantity > 1 ? 'novas' : 'nova'));
        span.data('quantity', quantity);
      }
    });
  }
};
window.addListenersMessage(loadMessage);
$(document).ready(function () {
  $('.receiver-list-item').on('click', receiverListItemClick);
  $('#text-new-message').on('keyup', function () {
    checkContentSend();
  });
  $('#btn-file').on('click', function () {
    $('#files').click();
  });
  $('#files').on('change', function () {
    changeBoxInputFile();
    checkContentSend();
  });
  $('#newMessage').on('submit', function (event) {
    event.preventDefault();
    sendMessage();
  });
});
/******/ })()
;