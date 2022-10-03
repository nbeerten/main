/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/js/pages/TMASigns.js ***!
  \****************************************/
window.TMASigns = {
  updatePreview: function updatePreview(_ref) {
    var text = _ref.text,
        subtext = _ref.subtext,
        size = _ref.size;
    if (text == '' || size == '') return; // Not indented for better code syntax for jsondebug card

    var postData = "{ \n    \"format\": \"jpg\", \n    \"size\": ".concat(size, ", \n    \"text\": \"").concat(text, "\", \n    \"subtext\": \"").concat(subtext, "\" \n}");
    var jsondebug = document.querySelector("#jsondebug");
    jsondebug.textContent = postData;
    var previewImage = document.querySelector('#previewImage');
    var Headers = {
      'Content-Type': 'application/json'
    };
    fetch('/api/tmasigns', {
      method: 'POST',
      headers: Headers,
      body: postData
    }).then(function (response) {
      return response.blob();
    }).then(function (imageBlob) {
      var objectURL = URL.createObjectURL(imageBlob);
      previewImage.src = objectURL;
    });
  },
  downloadTGA: function downloadTGA(_ref2) {
    var text = _ref2.text,
        subtext = _ref2.subtext,
        size = _ref2.size;
    if (text == '' || size == '') return;
    var downloadButton = document.querySelector('#downloadButton');
    downloadButton.download = "tma_sign".concat(size, "x1_").concat(text, ".zip");
    var postData = "{ \n            \"format\": \"tga\", \n            \"size\": ".concat(size, ", \n            \"text\": \"").concat(text, "\", \n            \"subtext\": \"").concat(subtext, "\" \n        }");
    var Headers = {
      'Content-Type': 'application/json'
    };
    fetch('/api/tmasigns', {
      method: 'POST',
      headers: Headers,
      body: postData
    }).then(function (response) {
      return response.blob();
    }).then(function (imageBlob) {
      var objectURL = URL.createObjectURL(imageBlob);
      downloadButton.href = objectURL;
      downloadButton.click();
      URL.revokeObjectURL(objectURL);
    });
  }
};
/******/ })()
;