/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/filedrop.js":
/*!**********************************!*\
  !*** ./resources/js/filedrop.js ***!
  \**********************************/
/***/ (() => {

function formatBytes(bytes) {
  var decimals = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 2;
  if (bytes === 0) return '0 Bytes';
  var k = 1024;
  var dm = decimals < 0 ? 0 : decimals;
  var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
  var i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

function uuidv4() {
  return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, function (c) {
    return (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16);
  });
}

function loadFiles(files, options) {
  jQuery.each(files, function (i, file) {
    var uuid = uuidv4();
    options.render({
      name: file.name,
      size: formatBytes(file.size),
      extension: file.name.substr(file.name.lastIndexOf('.') + 1),
      uuid: uuid
    });
    file.uuid = uuid;
    options.formData.append(options.input.attr('name') + '[' + uuid + ']', file);
  });
}

$.fn.extend({
  filedrop: function filedrop(options) {
    var defaults = {
      input: null,
      render: null,
      callback: null,
      formData: new FormData()
    };
    options = $.extend(defaults, options);
    return this.each(function () {
      var files = [];
      var $this = $(this); // Parar as ações padrão do navegador

      $this.bind('dragover', function (event) {
        event.stopPropagation();
        event.preventDefault();
        $this.addClass('border-dashed border-2 border-primary-500').removeClass('border-0 border-transparent');
      }).bind('dragleave', function (event) {
        event.stopPropagation();
        event.preventDefault();
        $this.removeClass('border-dashed border-2 border-primary-500').addClass('border-0 border-transparent');
      }); // Pega o evento ao soltar

      $this.bind('drop', function (event) {
        // Stop default browser actions
        event.stopPropagation();
        event.preventDefault();
        $this.removeClass('border-dashed border-2 border-primary-500').addClass('border-0 border-transparent'); // Obtém os arquivos que estão sendo soltos

        files = event.originalEvent.target.files || event.originalEvent.dataTransfer.files; // Converta o arquivo carregado em URL de dados e passe o retorno de chamada

        if (options.render) {
          loadFiles(files, options);
        }

        if (options.callback) {
          options.callback(options);
        }

        return false;
      });

      if (options.input) {
        $this.on('click', function () {
          options.input.click();
        });
        options.input.on('change', function () {
          loadFiles(options.input[0].files, options);

          if (options.callback) {
            options.callback(options);
          }
        });
      }
    });
  }
});

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!******************************!*\
  !*** ./resources/js/work.js ***!
  \******************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

__webpack_require__(/*! ./filedrop */ "./resources/js/filedrop.js");

var formData = new FormData($('#form-work')[0]);

var addFileTable = function addFileTable(file) {
  var html = '<tr class="item-file">\n' + '<th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">\n' + file.name + '</th>\n' + '<td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">\n' + file.extension + '</td>\n' + '<td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">\n' + file.size + '</td>\n' + '<td class="w-12 border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">\n' + '<button data-uuid="' + file.uuid + '" type="button" class="remove-file bg-gray-200 text-black font-bold px-2 py-1 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"><i class="fas fa-minus"></i></button>';
  '</td>\n' + '</tr>';
  $('#table-files tbody').append(html);
};

var checkHasFiles = function checkHasFiles() {
  if ($('.remove-file').length > 0) {
    $('#table-files').removeClass('hidden');
  } else {
    $('#table-files').addClass('hidden');
    $('#table-files tbody').html('');
  }
};

var alertErrors = function alertErrors(errors) {
  var keys = Object.keys(errors);
  keys.forEach(function (item) {
    var html = '<small class="error-input text-red-600">' + errors[item] + '</small>';
    $(html).insertAfter('[name="' + item + '"]');
  });
  $([document.documentElement, document.body]).animate({
    scrollTop: $(".error-input").offset().top - 80
  }, 500);
};

$(document).ready(function () {
  $('#students_class_id').on('change', function () {
    var route = $(this).find(':selected').data('teachers'),
        selectTeacher = $('#lesson_id');
    selectTeacher.prop('disabled', true).html('');
    $.get(route).then(function (response) {
      if (response.success) {
        response.lessons.forEach(function (item) {
          selectTeacher.append('<option value="' + item.id + '">' + item.subject.description + '</option>');
        });
      }

      selectTeacher.prop('disabled', false);
    });
  });
  $('#box-input-file').filedrop({
    input: $('#files'),
    render: addFileTable,
    callback: checkHasFiles,
    formData: formData
  });
  $('#form-work').on('submit', function (event) {
    event.preventDefault();
    var form = new FormData($(this)[0]);
    form["delete"]('files');

    var _iterator = _createForOfIteratorHelper(form.entries()),
        _step;

    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var pair = _step.value;
        formData.append(pair[0], pair[1]);
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }

    $.ajax({
      url: $(this).attr('action'),
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      type: 'POST',
      success: function success(response) {
        if (response.success) {
          $(location).attr('href', response.route);
        } else {
          if (response.hasOwnProperty('errors')) {
            alertErrors(response.errors);
          }
        }
      }
    });
  });
  $(document).on('click', '.remove-file', function () {
    formData["delete"]($('#files').attr('name') + '[' + $(this).attr('data-uuid') + ']');
    $(this).parents('tr.item-file').remove();
    checkHasFiles();
  });
  $('.remove-file-uploaded').on('click', function () {
    $(this).parent().append('<input type="hidden" name="deletefile[]" value="' + $(this).data('id') + '"/>');
    $(this).parents('.item-file').hide();
  });
});
})();

/******/ })()
;