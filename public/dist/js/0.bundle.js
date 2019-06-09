(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./public/src/js/modules/ajax-schedule.js":
/*!************************************************!*\
  !*** ./public/src/js/modules/ajax-schedule.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("/**\r\n * ajax for edit and add scheduled class in admin panel\r\n */\r\nif($(\"#edit-schedule\").length){\r\n    (function () {\r\n\r\n        const actionButton           = document.querySelector(\"#button\");\r\n        const $classDuration         = $(\"#class_duration\");\r\n        const $classNumberOfPeople   = $(\"#class_no_people\");\r\n\r\n        $.ajax({\r\n            type: \"POST\",\r\n            data: {cl_id: 107},\r\n            dataType: \"JSON\",\r\n            url: \"../changeSelectedClassDetails\",\r\n            success: function (data) {\r\n                $classDuration.html(data.duration);\r\n                $classNumberOfPeople.html(data.no_people)\r\n            }\r\n        });\r\n\r\n        console.log(\"meow\");\r\n\r\n    })();\r\n}\r\n\r\n\n\n//# sourceURL=webpack:///./public/src/js/modules/ajax-schedule.js?");

/***/ })

}]);