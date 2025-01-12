/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!****************************!*\
  !*** ./resources/media.js ***!
  \****************************/
__webpack_require__.r(__webpack_exports__);
jQuery('body').on('click', '.media-selector', function (event) {
  event.preventDefault();
  var multiple = 'true' === event.target.dataset.multiple;
  var media = wp.media({
    multiple: multiple
  }).open().on('select', function () {
    document.querySelector(event.target.dataset.inputSelector).value = multiple ? JSON.stringify(media.state().get('selection').map(function (attachment) {
      return attachment.id;
    })) : media.state().get('selection').first().toJSON().id;
  });
});
/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoibWVkaWEuYWU0ZjJmOWMuanMiLCJtYXBwaW5ncyI6Ijs7VUFBQTtVQUNBOzs7OztXQ0RBO1dBQ0E7V0FDQTtXQUNBLHVEQUF1RCxpQkFBaUI7V0FDeEU7V0FDQSxnREFBZ0QsYUFBYTtXQUM3RDs7Ozs7Ozs7O0FDTkFBLE1BQU0sQ0FBQyxNQUFNLENBQUMsQ0FBQ0MsRUFBRSxDQUFDLE9BQU8sRUFBRSxpQkFBaUIsRUFBRSxVQUFVQyxLQUFLLEVBQUU7RUFDM0RBLEtBQUssQ0FBQ0MsY0FBYyxDQUFDLENBQUM7RUFFdEIsSUFBTUMsUUFBUSxHQUFHLE1BQU0sS0FBS0YsS0FBSyxDQUFDRyxNQUFNLENBQUNDLE9BQU8sQ0FBQ0YsUUFBUTtFQUN6RCxJQUFNRyxLQUFLLEdBQUdDLEVBQUUsQ0FBQ0QsS0FBSyxDQUFDO0lBQUNILFFBQVEsRUFBRUE7RUFBUSxDQUFDLENBQUMsQ0FBQ0ssSUFBSSxDQUFDLENBQUMsQ0FBQ1IsRUFBRSxDQUFDLFFBQVEsRUFBRSxZQUFNO0lBQ25FUyxRQUFRLENBQUNDLGFBQWEsQ0FBQ1QsS0FBSyxDQUFDRyxNQUFNLENBQUNDLE9BQU8sQ0FBQ00sYUFBYSxDQUFDLENBQUNDLEtBQUssR0FBR1QsUUFBUSxHQUN2RVUsSUFBSSxDQUFDQyxTQUFTLENBQUNSLEtBQUssQ0FBQ1MsS0FBSyxDQUFDLENBQUMsQ0FBQ0MsR0FBRyxDQUFDLFdBQVcsQ0FBQyxDQUFDQyxHQUFHLENBQUMsVUFBQUMsVUFBVTtNQUFBLE9BQUlBLFVBQVUsQ0FBQ0MsRUFBRTtJQUFBLEVBQUMsQ0FBQyxHQUMvRWIsS0FBSyxDQUFDUyxLQUFLLENBQUMsQ0FBQyxDQUFDQyxHQUFHLENBQUMsV0FBVyxDQUFDLENBQUNJLEtBQUssQ0FBQyxDQUFDLENBQUNDLE1BQU0sQ0FBQyxDQUFDLENBQUNGLEVBQUU7RUFDMUQsQ0FBQyxDQUFDO0FBQ04sQ0FBQyxDQUFDLEMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9zYWdlL3dlYnBhY2svYm9vdHN0cmFwIiwid2VicGFjazovL3NhZ2Uvd2VicGFjay9ydW50aW1lL21ha2UgbmFtZXNwYWNlIG9iamVjdCIsIndlYnBhY2s6Ly9zYWdlLy4vcmVzb3VyY2VzL21lZGlhLmpzIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIFRoZSByZXF1aXJlIHNjb3BlXG52YXIgX193ZWJwYWNrX3JlcXVpcmVfXyA9IHt9O1xuXG4iLCIvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG5cdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuXHR9XG5cdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG59OyIsImpRdWVyeSgnYm9keScpLm9uKCdjbGljaycsICcubWVkaWEtc2VsZWN0b3InLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICBldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgY29uc3QgbXVsdGlwbGUgPSAndHJ1ZScgPT09IGV2ZW50LnRhcmdldC5kYXRhc2V0Lm11bHRpcGxlO1xuICAgIGNvbnN0IG1lZGlhID0gd3AubWVkaWEoe211bHRpcGxlOiBtdWx0aXBsZX0pLm9wZW4oKS5vbignc2VsZWN0JywgKCkgPT4ge1xuICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKGV2ZW50LnRhcmdldC5kYXRhc2V0LmlucHV0U2VsZWN0b3IpLnZhbHVlID0gbXVsdGlwbGUgP1xuICAgICAgICAgICAgSlNPTi5zdHJpbmdpZnkobWVkaWEuc3RhdGUoKS5nZXQoJ3NlbGVjdGlvbicpLm1hcChhdHRhY2htZW50ID0+IGF0dGFjaG1lbnQuaWQpKSA6XG4gICAgICAgICAgICBtZWRpYS5zdGF0ZSgpLmdldCgnc2VsZWN0aW9uJykuZmlyc3QoKS50b0pTT04oKS5pZDtcbiAgICB9KTtcbn0pO1xuIl0sIm5hbWVzIjpbImpRdWVyeSIsIm9uIiwiZXZlbnQiLCJwcmV2ZW50RGVmYXVsdCIsIm11bHRpcGxlIiwidGFyZ2V0IiwiZGF0YXNldCIsIm1lZGlhIiwid3AiLCJvcGVuIiwiZG9jdW1lbnQiLCJxdWVyeVNlbGVjdG9yIiwiaW5wdXRTZWxlY3RvciIsInZhbHVlIiwiSlNPTiIsInN0cmluZ2lmeSIsInN0YXRlIiwiZ2V0IiwibWFwIiwiYXR0YWNobWVudCIsImlkIiwiZmlyc3QiLCJ0b0pTT04iXSwic291cmNlUm9vdCI6IiJ9