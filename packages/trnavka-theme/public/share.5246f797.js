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
  !*** ./resources/share.js ***!
  \****************************/
__webpack_require__.r(__webpack_exports__);
var _script$dataset$url, _script$dataset$view, _script$dataset$onloa, _window$onloadCallbac;
var script = document.currentScript;
var canvas = script.previousElementSibling;
var campaignUrl = (_script$dataset$url = script.dataset["url"]) !== null && _script$dataset$url !== void 0 ? _script$dataset$url : null;
var campaignView = (_script$dataset$view = script.dataset["view"]) !== null && _script$dataset$view !== void 0 ? _script$dataset$view : null;
var onloadCallbackName = (_script$dataset$onloa = script.dataset["onload"]) !== null && _script$dataset$onloa !== void 0 ? _script$dataset$onloa : null;
var onloadCallback = null === onloadCallbackName ? null : (_window$onloadCallbac = window[onloadCallbackName]) !== null && _window$onloadCallbac !== void 0 ? _window$onloadCallbac : null;
if (campaignUrl === null || campaignView === null) {
  console.log("Campaign URL or campaign view is not set.");
} else {
  canvas.innerHTML = '...';
  var url = new URL(script.src);
  var cacheBuster = Math.floor(new Date().getTime() / 300000) * 300;
  fetch("".concat(url.protocol, "//").concat(url.host).concat(campaignUrl, "?view=").concat(campaignView, "&cb=").concat(cacheBuster)).then(function (response) {
    return response.text();
  }).then(function (html) {
    canvas.innerHTML = html;
    if (null !== onloadCallback) {
      onloadCallback(html);
    }
  });
}
/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoic2hhcmUuNTI0NmY3OTcuanMiLCJtYXBwaW5ncyI6Ijs7VUFBQTtVQUNBOzs7OztXQ0RBO1dBQ0E7V0FDQTtXQUNBLHVEQUF1RCxpQkFBaUI7V0FDeEU7V0FDQSxnREFBZ0QsYUFBYTtXQUM3RDs7Ozs7Ozs7OztBQ05BLElBQU1BLE1BQU0sR0FBR0MsUUFBUSxDQUFDQyxhQUFhO0FBQ3JDLElBQU1DLE1BQU0sR0FBR0gsTUFBTSxDQUFDSSxzQkFBc0I7QUFFNUMsSUFBTUMsV0FBVyxJQUFBQyxtQkFBQSxHQUFHTixNQUFNLENBQUNPLE9BQU8sQ0FBQyxLQUFLLENBQUMsY0FBQUQsbUJBQUEsY0FBQUEsbUJBQUEsR0FBSSxJQUFJO0FBQ2pELElBQU1FLFlBQVksSUFBQUMsb0JBQUEsR0FBR1QsTUFBTSxDQUFDTyxPQUFPLENBQUMsTUFBTSxDQUFDLGNBQUFFLG9CQUFBLGNBQUFBLG9CQUFBLEdBQUksSUFBSTtBQUNuRCxJQUFNQyxrQkFBa0IsSUFBQUMscUJBQUEsR0FBR1gsTUFBTSxDQUFDTyxPQUFPLENBQUMsUUFBUSxDQUFDLGNBQUFJLHFCQUFBLGNBQUFBLHFCQUFBLEdBQUksSUFBSTtBQUMzRCxJQUFNQyxjQUFjLEdBQUcsSUFBSSxLQUFLRixrQkFBa0IsR0FBRyxJQUFJLElBQUFHLHFCQUFBLEdBQUlDLE1BQU0sQ0FBQ0osa0JBQWtCLENBQUMsY0FBQUcscUJBQUEsY0FBQUEscUJBQUEsR0FBSSxJQUFLO0FBRWhHLElBQUlSLFdBQVcsS0FBSyxJQUFJLElBQUlHLFlBQVksS0FBSyxJQUFJLEVBQUU7RUFDL0NPLE9BQU8sQ0FBQ0MsR0FBRyxDQUFDLDJDQUEyQyxDQUFDO0FBQzVELENBQUMsTUFBTTtFQUNIYixNQUFNLENBQUNjLFNBQVMsR0FBRyxLQUFLO0VBQ3hCLElBQU1DLEdBQUcsR0FBRyxJQUFJQyxHQUFHLENBQUNuQixNQUFNLENBQUNvQixHQUFHLENBQUM7RUFDL0IsSUFBTUMsV0FBVyxHQUFHQyxJQUFJLENBQUNDLEtBQUssQ0FBQyxJQUFJQyxJQUFJLENBQUMsQ0FBQyxDQUFDQyxPQUFPLENBQUMsQ0FBQyxHQUFHLE1BQU0sQ0FBQyxHQUFHLEdBQUc7RUFFbkVDLEtBQUssSUFBQUMsTUFBQSxDQUFJVCxHQUFHLENBQUNVLFFBQVEsUUFBQUQsTUFBQSxDQUFLVCxHQUFHLENBQUNXLElBQUksRUFBQUYsTUFBQSxDQUFHdEIsV0FBVyxZQUFBc0IsTUFBQSxDQUFTbkIsWUFBWSxVQUFBbUIsTUFBQSxDQUFPTixXQUFXLENBQUUsQ0FBQyxDQUNyRlMsSUFBSSxDQUFDLFVBQUNDLFFBQVEsRUFBSztJQUNoQixPQUFPQSxRQUFRLENBQUNDLElBQUksQ0FBQyxDQUFDO0VBQzFCLENBQUMsQ0FBQyxDQUNERixJQUFJLENBQUMsVUFBQ0csSUFBSSxFQUFLO0lBQ1o5QixNQUFNLENBQUNjLFNBQVMsR0FBR2dCLElBQUk7SUFFdkIsSUFBSSxJQUFJLEtBQUtyQixjQUFjLEVBQUU7TUFDekJBLGNBQWMsQ0FBQ3FCLElBQUksQ0FBQztJQUN4QjtFQUNKLENBQUMsQ0FBQztBQUNWLEMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9zYWdlL3dlYnBhY2svYm9vdHN0cmFwIiwid2VicGFjazovL3NhZ2Uvd2VicGFjay9ydW50aW1lL21ha2UgbmFtZXNwYWNlIG9iamVjdCIsIndlYnBhY2s6Ly9zYWdlLy4vcmVzb3VyY2VzL3NoYXJlLmpzIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIFRoZSByZXF1aXJlIHNjb3BlXG52YXIgX193ZWJwYWNrX3JlcXVpcmVfXyA9IHt9O1xuXG4iLCIvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG5cdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuXHR9XG5cdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG59OyIsImNvbnN0IHNjcmlwdCA9IGRvY3VtZW50LmN1cnJlbnRTY3JpcHQ7XG5jb25zdCBjYW52YXMgPSBzY3JpcHQucHJldmlvdXNFbGVtZW50U2libGluZztcblxuY29uc3QgY2FtcGFpZ25VcmwgPSBzY3JpcHQuZGF0YXNldFtcInVybFwiXSA/PyBudWxsO1xuY29uc3QgY2FtcGFpZ25WaWV3ID0gc2NyaXB0LmRhdGFzZXRbXCJ2aWV3XCJdID8/IG51bGw7XG5jb25zdCBvbmxvYWRDYWxsYmFja05hbWUgPSBzY3JpcHQuZGF0YXNldFtcIm9ubG9hZFwiXSA/PyBudWxsO1xuY29uc3Qgb25sb2FkQ2FsbGJhY2sgPSBudWxsID09PSBvbmxvYWRDYWxsYmFja05hbWUgPyBudWxsIDogKHdpbmRvd1tvbmxvYWRDYWxsYmFja05hbWVdID8/IG51bGwpO1xuXG5pZiAoY2FtcGFpZ25VcmwgPT09IG51bGwgfHwgY2FtcGFpZ25WaWV3ID09PSBudWxsKSB7XG4gICAgY29uc29sZS5sb2coXCJDYW1wYWlnbiBVUkwgb3IgY2FtcGFpZ24gdmlldyBpcyBub3Qgc2V0LlwiKTtcbn0gZWxzZSB7XG4gICAgY2FudmFzLmlubmVySFRNTCA9ICcuLi4nO1xuICAgIGNvbnN0IHVybCA9IG5ldyBVUkwoc2NyaXB0LnNyYyk7XG4gICAgY29uc3QgY2FjaGVCdXN0ZXIgPSBNYXRoLmZsb29yKG5ldyBEYXRlKCkuZ2V0VGltZSgpIC8gMzAwMDAwKSAqIDMwMDtcblxuICAgIGZldGNoKGAke3VybC5wcm90b2NvbH0vLyR7dXJsLmhvc3R9JHtjYW1wYWlnblVybH0/dmlldz0ke2NhbXBhaWduVmlld30mY2I9JHtjYWNoZUJ1c3Rlcn1gKVxuICAgICAgICAudGhlbigocmVzcG9uc2UpID0+IHtcbiAgICAgICAgICAgIHJldHVybiByZXNwb25zZS50ZXh0KCk7XG4gICAgICAgIH0pXG4gICAgICAgIC50aGVuKChodG1sKSA9PiB7XG4gICAgICAgICAgICBjYW52YXMuaW5uZXJIVE1MID0gaHRtbDtcblxuICAgICAgICAgICAgaWYgKG51bGwgIT09IG9ubG9hZENhbGxiYWNrKSB7XG4gICAgICAgICAgICAgICAgb25sb2FkQ2FsbGJhY2soaHRtbCk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xufVxuIl0sIm5hbWVzIjpbInNjcmlwdCIsImRvY3VtZW50IiwiY3VycmVudFNjcmlwdCIsImNhbnZhcyIsInByZXZpb3VzRWxlbWVudFNpYmxpbmciLCJjYW1wYWlnblVybCIsIl9zY3JpcHQkZGF0YXNldCR1cmwiLCJkYXRhc2V0IiwiY2FtcGFpZ25WaWV3IiwiX3NjcmlwdCRkYXRhc2V0JHZpZXciLCJvbmxvYWRDYWxsYmFja05hbWUiLCJfc2NyaXB0JGRhdGFzZXQkb25sb2EiLCJvbmxvYWRDYWxsYmFjayIsIl93aW5kb3ckb25sb2FkQ2FsbGJhYyIsIndpbmRvdyIsImNvbnNvbGUiLCJsb2ciLCJpbm5lckhUTUwiLCJ1cmwiLCJVUkwiLCJzcmMiLCJjYWNoZUJ1c3RlciIsIk1hdGgiLCJmbG9vciIsIkRhdGUiLCJnZXRUaW1lIiwiZmV0Y2giLCJjb25jYXQiLCJwcm90b2NvbCIsImhvc3QiLCJ0aGVuIiwicmVzcG9uc2UiLCJ0ZXh0IiwiaHRtbCJdLCJzb3VyY2VSb290IjoiIn0=