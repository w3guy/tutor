/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/react/front/course/_spotlight.js":
/*!*************************************************!*\
  !*** ./assets/react/front/course/_spotlight.js ***!
  \*************************************************/
/***/ (() => {

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

document.addEventListener('DOMContentLoaded', function (event) {
  /* sidetab tab position */
  var topBar = document.querySelector('.tutor-single-page-top-bar');
  var sideBar = document.querySelector('.tutor-lesson-sidebar');
  sideBar.style.top = topBar.clientHeight + 'px';
  /* sidetab tab position */

  /* sidetab tab */

  var sideBarTabs = document.querySelectorAll('.tutor-sidebar-tab-item');
  sideBarTabs.forEach(function (tab) {
    tab.addEventListener('click', function (event) {
      clearActiveClass();
      event.currentTarget.classList.add('active');
      var id = event.currentTarget.getAttribute('data-sidebar-tab');
      document.getElementById(id).classList.add('active');
    });
  });

  var clearActiveClass = function clearActiveClass() {
    for (var i = 0; i < sideBarTabs.length; i++) {
      sideBarTabs[i].classList.remove('active');
    }

    var sidebarTabItems = document.querySelectorAll('.tutor-lesson-sidebar-tab-item');

    for (var _i = 0; _i < sidebarTabItems.length; _i++) {
      sidebarTabItems[_i].classList.remove('active');
    }
  };
  /* end of sidetab tab */

  /* comment text-area focus arrow style */


  var commentTextarea = document.querySelectorAll('.tutor-comment-textarea textarea');

  if (commentTextarea) {
    commentTextarea.forEach(function (item) {
      item.addEventListener('focus', function () {
        item.parentElement.classList.add('is-focused');
      });
      item.addEventListener('blur', function () {
        item.parentElement.classList.remove('is-focused');
      });
    });
  }
  /* comment text-area focus arrow style */

  /* commenting */


  var parentComments = document.querySelectorAll('.tutor-comments-list.tutor-parent-comment');
  var replyComment = document.querySelector('.tutor-comment-box.tutor-reply-box');

  if (parentComments) {
    _toConsumableArray(parentComments).forEach(function (parentComment) {
      var childComments = parentComment.querySelectorAll('.tutor-comments-list.tutor-child-comment');
      var commentLine = parentComment.querySelector('.tutor-comment-line');
      var childCommentCount = childComments.length;
      var lastCommentHeight = childComments[childCommentCount - 1].clientHeight;
      var heightOfLine = lastCommentHeight + replyComment.clientHeight + 20 - 25 + 50;
      commentLine.style.setProperty('height', "calc(100% - ".concat(heightOfLine, "px)"));
    });
  }
  /* commenting */

  /* Show More Text */


  var showMoreBtn = document.querySelector('.tutor-show-more-btn button');
  showMoreBtn.addEventListener('click', showMore);

  function showMore() {
    var lessText = document.getElementById("short-text");
    var dots = document.getElementById("dots");
    var moreText = document.getElementById("full-text");
    var btnText = document.getElementById("showBtn");
    var contSect = document.getElementById("content-section");
    console.log(lessText, dots, moreText, btnText);

    if (dots.style.display === "none") {
      lessText.style.display = "block";
      dots.style.display = "inline";
      btnText.innerHTML = "<span class='btn-icon ttr-plus-filled color-design-brand'></span><span class='color-text-primary'>Show More</span>";
      moreText.style.display = "none";
      contSect.classList.remove('no-before');
    } else {
      lessText.style.display = "none";
      dots.style.display = "none";
      btnText.innerHTML = "<span class='btn-icon ttr-minus-filled color-design-brand'></span><span class='color-text-primary'>Show Less</span>";
      moreText.style.display = "block";
      contSect.classList.add('no-before');
    }
  }
  /* Show More Text */

});

/***/ }),

/***/ "./assets/react/front/course/_wishlist.js":
/*!************************************************!*\
  !*** ./assets/react/front/course/_wishlist.js ***!
  \************************************************/
/***/ (() => {

window.jQuery(document).ready(function ($) {
  var __ = wp.i18n.__;
  $(document).on('click', '.tutor-course-wishlist-btn', function (e) {
    e.preventDefault();
    var $that = $(this);
    var course_id = $that.attr('data-course-id');
    $.ajax({
      url: _tutorobject.ajaxurl,
      type: 'POST',
      data: {
        course_id: course_id,
        'action': 'tutor_course_add_to_wishlist'
      },
      beforeSend: function beforeSend() {
        $that.addClass('tutor-updating-message tutor-m-0');
      },
      success: function success(data) {
        if (data.success) {
          if (data.data.status === 'added') {
            $that.find('i').addClass('ttr-fav-full-filled').removeClass('ttr-fav-line-filled');
          } else {
            $that.find('i').addClass('ttr-fav-line-filled').removeClass('ttr-fav-full-filled');
          }
        } else {
          window.location = data.data.redirect_to;
        }
      },
      complete: function complete() {
        $that.removeClass('tutor-updating-message tutor-m-0');
      }
    });
  });
});

/***/ }),

/***/ "./assets/react/front/course/index.js":
/*!********************************************!*\
  !*** ./assets/react/front/course/index.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _spotlight__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_spotlight */ "./assets/react/front/course/_spotlight.js");
/* harmony import */ var _spotlight__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_spotlight__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wishlist__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_wishlist */ "./assets/react/front/course/_wishlist.js");
/* harmony import */ var _wishlist__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wishlist__WEBPACK_IMPORTED_MODULE_1__);


window.jQuery(document).ready(function ($) {
  // Login require on enrol purchase click
  $(document).on('click', '.tutor-enrol-require-auth', function (e) {
    e.preventDefault();
    $('.tutor-login-modal').addClass('tutor-is-active');
  });
});

/***/ }),

/***/ "./assets/react/front/dashboard.js":
/*!*****************************************!*\
  !*** ./assets/react/front/dashboard.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _dashboard_mobile_nav__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./dashboard/mobile-nav */ "./assets/react/front/dashboard/mobile-nav.js");
/* harmony import */ var _dashboard_mobile_nav__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_dashboard_mobile_nav__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _dashboard_withdrawal__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./dashboard/withdrawal */ "./assets/react/front/dashboard/withdrawal.js");
/* harmony import */ var _dashboard_withdrawal__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_dashboard_withdrawal__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _dashboard_settings_profile__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./dashboard/settings/profile */ "./assets/react/front/dashboard/settings/profile.js");
/* harmony import */ var _dashboard_settings_profile__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_dashboard_settings_profile__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _dashboard_settings_passowrd_reset__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./dashboard/settings/passowrd-reset */ "./assets/react/front/dashboard/settings/passowrd-reset.js");
/* harmony import */ var _dashboard_settings_passowrd_reset__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_dashboard_settings_passowrd_reset__WEBPACK_IMPORTED_MODULE_3__);





/***/ }),

/***/ "./assets/react/front/dashboard/export-csv.js":
/*!****************************************************!*\
  !*** ./assets/react/front/dashboard/export-csv.js ***!
  \****************************************************/
/***/ (() => {

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

document.addEventListener("DOMContentLoaded", function () {
  var _wp$i18n = wp.i18n,
      __ = _wp$i18n.__,
      _x = _wp$i18n._x,
      _n = _wp$i18n._n,
      _nx = _wp$i18n._nx;
  /**
   * Export purchase history
   *
   * @since v2.0.0
   */

  var exportPurchase = document.querySelectorAll(".tutor-export-purchase-history");

  var _iterator = _createForOfIteratorHelper(exportPurchase),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var purchased = _step.value;

      if (purchased) {
        purchased.onclick = function (e) {
          var target = e.currentTarget;
          var filename = "order-".concat(target.dataset.order, "-purchase-history.csv");
          var data = [{
            "Order ID ": target.dataset.order,
            "Course Name": target.dataset.courseName,
            Price: target.dataset.price,
            Date: target.dataset.date,
            Status: target.dataset.status
          }];
          exportCSV(data, filename);
        };
      }
    }
    /**
     * Export CSV file
     *
     * @param {*} data | data that will be used for generating CSV file
     * @param {*} filename | filename of CSV file
     * @since v2.0.0
     */

  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }

  function exportCSV(data, filename) {
    var keys = Object.keys(data[0]);
    var csvFile = [keys.join(","), data.map(function (row) {
      return keys.map(function (key) {
        return row[key];
      }).join(",");
    }).join("\n")].join("\n"); //generate csv

    var blob = new Blob([csvFile], {
      type: "text/csv;charset=utf-8"
    });
    var url = URL.createObjectURL(blob);
    var link = document.createElement("a");
    link.setAttribute("href", url);
    link.setAttribute("download", filename);
    link.style.visibility = "hidden";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }
});

/***/ }),

/***/ "./assets/react/front/dashboard/mobile-nav.js":
/*!****************************************************!*\
  !*** ./assets/react/front/dashboard/mobile-nav.js ***!
  \****************************************************/
/***/ (() => {

document.addEventListener("DOMContentLoaded", function () {
  // Toggle menu in mobile view
  var $ = window.jQuery;
  $(".tutor-dashboard .tutor-dashboard-menu-toggler").click(function () {
    var el = $(".tutor-dashboard-left-menu");
    el.closest(".tutor-dashboard").toggleClass("is-sidebar-expanded");

    if (el.css("display") !== "none") {
      el.get(0).scrollIntoView({
        block: "start"
      });
    }
  });
});

/***/ }),

/***/ "./assets/react/front/dashboard/settings/passowrd-reset.js":
/*!*****************************************************************!*\
  !*** ./assets/react/front/dashboard/settings/passowrd-reset.js ***!
  \*****************************************************************/
/***/ (() => {

window.jQuery(document).ready(function ($) {
  $('.tutor-settings-pass-field [name="confirm_new_password"]').on('input', function () {
    var original = $('[name="new_password"]');
    var val = (original.val() || '').trim();
    var matched = val && $(this).val() === val;
    $(this).next()[matched ? 'show' : 'hide']();
  });
});

/***/ }),

/***/ "./assets/react/front/dashboard/settings/profile.js":
/*!**********************************************************!*\
  !*** ./assets/react/front/dashboard/settings/profile.js ***!
  \**********************************************************/
/***/ (() => {

window.jQuery(document).ready(function ($) {
  /**
   * Profile Photo and Cover Photo editor
   * 
   * @since  v.1.7.5
  */
  var PhotoEditor = function PhotoEditor(photo_editor) {
    this.dialogue_box = photo_editor.find('#tutor_photo_dialogue_box');

    this.open_dialogue_box = function (name) {
      this.dialogue_box.attr('name', name);
      this.dialogue_box.trigger('click');
    };

    this.validate_image = function (file) {
      return true;
    };

    this.upload_selected_image = function (name, file) {
      if (!file || !this.validate_image(file)) {
        return;
      }

      var nonce = tutor_get_nonce_data(true);
      var context = this;
      context.toggle_loader(name, true); // Prepare payload to upload

      var form_data = new FormData();
      form_data.append('action', 'tutor_user_photo_upload');
      form_data.append('photo_type', name);
      form_data.append('photo_file', file, file.name);
      form_data.append(nonce.key, nonce.value);
      $.ajax({
        url: window._tutorobject.ajaxurl,
        data: form_data,
        type: 'POST',
        processData: false,
        contentType: false,
        error: context.error_alert,
        complete: function complete() {
          context.toggle_loader(name, false);
        }
      });
    };

    this.accept_upload_image = function (context, e) {
      var file = e.currentTarget.files[0] || null;
      context.update_preview(e.currentTarget.name, file);
      context.upload_selected_image(e.currentTarget.name, file);
      $(e.currentTarget).val('');
    };

    this.delete_image = function (name) {
      var context = this;
      context.toggle_loader(name, true);
      $.ajax({
        url: window._tutorobject.ajaxurl,
        data: {
          action: 'tutor_user_photo_remove',
          photo_type: name
        },
        type: 'POST',
        error: context.error_alert,
        complete: function complete() {
          context.toggle_loader(name, false);
        }
      });
    };

    this.update_preview = function (name, file) {
      var renderer = photo_editor.find(name == 'cover_photo' ? '#tutor_cover_area' : '#tutor_profile_area');

      if (!file) {
        renderer.css('background-image', 'url(' + renderer.data('fallback') + ')');
        this.delete_image(name);
        return;
      }

      var reader = new FileReader();

      reader.onload = function (e) {
        renderer.css('background-image', 'url(' + e.target.result + ')');
      };

      reader.readAsDataURL(file);
    };

    this.toggle_profile_pic_action = function (show) {
      var method = show === undefined ? 'toggleClass' : show ? 'addClass' : 'removeClass';
      photo_editor[method]('pop-up-opened');
    };

    this.error_alert = function () {
      alert('Something Went Wrong.');
    };

    this.toggle_loader = function (name, show) {
      photo_editor.find('#tutor_photo_meta_area .loader-area').css('display', show ? 'block' : 'none');
    };

    this.initialize = function () {
      var context = this;
      this.dialogue_box.change(function (e) {
        context.accept_upload_image(context, e);
      });
      photo_editor.find('#tutor_profile_area .tutor_overlay, #tutor_pp_option>div:last-child').click(function () {
        context.toggle_profile_pic_action();
      }); // Upload new

      photo_editor.find('.tutor_cover_uploader').click(function () {
        context.open_dialogue_box('cover_photo');
      });
      photo_editor.find('.tutor_pp_uploader').click(function () {
        context.open_dialogue_box('profile_photo');
      }); // Delete existing

      photo_editor.find('.tutor_cover_deleter').click(function () {
        context.update_preview('cover_photo', null);
      });
      photo_editor.find('.tutor_pp_deleter').click(function () {
        context.update_preview('profile_photo', null);
      });
    };
  };

  var photo_editor = $('#tutor_profile_cover_photo_editor');
  photo_editor.length > 0 ? new PhotoEditor(photo_editor).initialize() : 0;
});

/***/ }),

/***/ "./assets/react/front/dashboard/withdrawal.js":
/*!****************************************************!*\
  !*** ./assets/react/front/dashboard/withdrawal.js ***!
  \****************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var $ = window.jQuery;
  /**
   * Withdraw Form Tab/Toggle
   *
   * @since v.1.1.2
   */

  $('.tutor-dashboard-setting-withdraw input[name="tutor_selected_withdraw_method"]').on('change', function (e) {
    var $that = $(this);
    var form = $that.closest('form');
    form.find('.withdraw-method-form').hide();
    form.find('.withdraw-method-form').hide().filter('[data-withdraw-form="' + $that.val() + '"]').show();
  });
});

/***/ }),

/***/ "./assets/react/front/pages/course-landing.js":
/*!****************************************************!*\
  !*** ./assets/react/front/pages/course-landing.js ***!
  \****************************************************/
/***/ (() => {

window.jQuery(document).ready(function ($) {
  var __ = window.wp.i18n.__;
  /**
   * Retake course
   * 
   * @since v1.9.5
   */

  $('.tutor-course-retake-button').click(function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var course_id = $(this).data('course_id');
    var data = {
      title: __('Override Previous Progress', 'tutor'),
      description: __('Before continue, please decide whether to keep progress or reset.', 'tutor'),
      buttons: {
        reset: {
          title: __('Reset Data', 'tutor'),
          "class": 'tutor-btn tutor-is-outline tutor-is-default',
          callback: function callback(button) {
            $.ajax({
              url: window._tutorobject.ajaxurl,
              type: 'POST',
              data: {
                action: 'tutor_reset_course_progress',
                course_id: course_id
              },
              beforeSend: function beforeSend() {
                button.prop('disabled', true).addClass('tutor-updating-message');
              },
              success: function success(response) {
                if (response.success) {
                  window.location.assign(response.data.redirect_to);
                } else {
                  alert((response.data || {}).message || __('Something went wrong', 'tutor'));
                }
              },
              complete: function complete() {
                button.prop('disabled', false).removeClass('tutor-updating-message');
              }
            });
          }
        },
        keep: {
          title: __('Keep Data', 'tutor'),
          "class": 'tutor-btn',
          callback: function callback() {
            window.location.assign(url);
          }
        }
      }
    };
    new window.tutor_popup($, 'icon-gear', 40).popup(data);
  });
});

/***/ }),

/***/ "./assets/react/front/pages/instructor-list-filter.js":
/*!************************************************************!*\
  !*** ./assets/react/front/pages/instructor-list-filter.js ***!
  \************************************************************/
/***/ (() => {

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

jQuery(document).ready(function ($) {
  /**
   * 
   * Instructor list filter
   * 
   * @since  v.1.8.4
  */
  // Get values on course category selection
  $('.tutor-instructor-filter').each(function () {
    var root = $(this);
    var filter_args = {};
    var time_out;

    function run_instructor_filter(name, value, page_number) {
      // Prepare http payload
      var result_container = root.find('.filter-result-container');
      var html_cache = result_container.html();
      var attributes = root.data();
      attributes.current_page = page_number || 1;
      name ? filter_args[name] = value : filter_args = {};
      filter_args.attributes = attributes;
      filter_args.action = 'load_filtered_instructor'; // Show loading icon

      result_container.html('<div style="text-align:center"><img src="' + window._tutorobject.loading_icon_url + '"/></div>');
      $.ajax({
        url: window._tutorobject.ajaxurl,
        data: filter_args,
        type: 'POST',
        success: function success(r) {
          result_container.html(r);
        },
        error: function error() {
          result_container.html(html_cache);
          tutor_toast('Failed', 'Request Error', 'error');
        }
      });
    }

    root.on('change', '.course-category-filter [type="checkbox"]', function () {
      var values = {};
      $(this).closest('.course-category-filter').find('input:checked').each(function () {
        values[$(this).val()] = $(this).parent().text();
      }); // Show selected cat list

      var cat_parent = root.find('.selected-cate-list').empty();
      var cat_ids = Object.keys(values);
      cat_ids.forEach(function (value) {
        cat_parent.append('<span>' + values[value] + ' <span class="tutor-icon-line-cross" data-cat_id="' + value + '"></span></span>');
      });
      cat_ids.length ? cat_parent.append('<span data-cat_id="0">Clear All</span>') : 0;
      run_instructor_filter($(this).attr('name'), cat_ids);
    }).on('click', '.tutor-instructor-ratings i', function (e) {
      var rating = e.target.dataset.value;
      run_instructor_filter('rating_filter', rating);
    }).on('change', "#tutor-instructor-relevant-sort", function (e) {
      var short_by = e.target.value;
      run_instructor_filter('short_by', short_by);
    }).on('click', '.selected-cate-list [data-cat_id]', function () {
      var id = $(this).data('cat_id');
      var inputs = root.find('.mobile-filter-popup [type="checkbox"]');
      id ? inputs = inputs.filter('[value="' + id + '"]') : 0;
      inputs.prop('checked', false).trigger('change');
    }).on('input', '.filter-pc [name="keyword"]', function () {
      // Get values on search keyword change
      var val = $(this).val();
      time_out ? window.clearTimeout(time_out) : 0;
      time_out = window.setTimeout(function () {
        run_instructor_filter('keyword', val);
        time_out = null;
      }, 500);
    }).on('click', '[data-page_number]', function (e) {
      // On pagination click
      e.preventDefault();
      run_instructor_filter(null, null, $(this).data('page_number'));
    }).on('click', '.clear-instructor-filter', function () {
      // Clear filter
      var root = $(this).closest('.tutor-instructor-filter');
      root.find('input[type="checkbox"]').prop('checked', false);
      root.find('[name="keyword"]').val('');
      var stars = document.querySelectorAll(".tutor-instructor-ratings i"); //remove star selection

      var _iterator = _createForOfIteratorHelper(stars),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var star = _step.value;

          if (star.classList.contains('active')) {
            star.classList.remove('active');
          }

          if (star.classList.contains('ttr-star-full-filled')) {
            star.classList.remove('ttr-star-full-filled');
            star.classList.add('ttr-star-line-filled');
          }
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }

      rating_range.innerHTML = "";
      run_instructor_filter();
    }).on('click', '.mobile-filter-container i', function () {
      // Open mobile screen filter
      $(this).parent().next().addClass('is-opened');
    }).on('click', '.mobile-filter-popup button', function () {
      $('.mobile-filter-popup [type="checkbox"]').trigger('change'); // Close mobile screen filter

      $(this).closest('.mobile-filter-popup').removeClass('is-opened');
    }).on('input', '.filter-mobile [name="keyword"]', function () {
      // Sync keyword with two screen
      root.find('.filter-pc [name="keyword"]').val($(this).val()).trigger('input');
    }).on('change', '.mobile-filter-popup [type="checkbox"]', function (e) {
      if (e.originalEvent) {
        return;
      } // Sync category with two screen


      var name = $(this).attr('name');
      var val = $(this).val();
      var checked = $(this).prop('checked');
      root.find('.course-category-filter [name="' + name + '"]').filter('[value="' + val + '"]').prop('checked', checked).trigger('change');
    }).on('mousedown touchstart', '.expand-instructor-filter', function (e) {
      var window_height = $(window).height();
      var el = root.find('.mobile-filter-popup>div');
      var el_top = window_height - el.height();
      var plus = ((e.originalEvent.touches || [])[0] || e).clientY - el_top;
      root.on('mousemove touchmove', function (e) {
        var y = ((e.originalEvent.touches || [])[0] || e).clientY;
        var height = window_height - y + plus;
        height > 200 && height <= window_height ? el.css('height', height + 'px') : 0;
      });
    }).on('mouseup touchend', function () {
      root.off('mousemove touchmove');
    }).on('click', '.mobile-filter-popup>div', function (e) {
      e.stopImmediatePropagation();
    }).on('click', '.mobile-filter-popup', function (e) {
      $(this).removeClass('is-opened');
    }).on('click', '.tutor-instructor-category-show-more > .text-medium-caption', function (e) {
      //show more @since v2.0.0
      var term_id = e.target.parentNode.dataset.id;
      console.log(e.target.tagName);
      console.log(term_id);
      $.ajax({
        url: window._tutorobject.ajaxurl,
        type: 'POST',
        data: {
          action: 'show_more',
          term_id: term_id
        },
        beforeSend: function beforeSend() {
          $(".tutor-show-more-loading").html("<img src='".concat(window._tutorobject.loading_icon_url, "'>"));
        },
        success: function success(response) {
          console.log(response);

          if (response.success && response.data.categories.length) {
            $(".tutor-instructor-category-show-more").css("display", "block");

            var _iterator2 = _createForOfIteratorHelper(response.data.categories),
                _step2;

            try {
              for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
                var res = _step2.value;
                var wrapper = $(".tutor-instructor-categories-wrapper .course-category-filter");
                $(".tutor-instructor-category-show-more .text-medium-caption").attr('data-id', res.term_id);
                wrapper.append("<div class=\"tutor-form-check tutor-mb-25\">\n                                    <input\n                                        id=\"item-a\"\n                                        type=\"checkbox\"\n                                        class=\"tutor-form-check-input tutor-form-check-square\"\n                                        name=\"category\"\n                                        value=\"".concat(res.term_id, "\"/>\n                                    <label for=\"item-a\">\n                                        ").concat(res.name, "\n                                    </label>\n                                </div>\n                                "));
              }
            } catch (err) {
              _iterator2.e(err);
            } finally {
              _iterator2.f();
            }
          }

          if (false === response.data.show_more) {
            $(".tutor-instructor-category-show-more").css("display", "none");

            if (document.querySelector(".course-category-filter").classList.contains('tutor-show-more-blur')) {
              document.querySelector(".course-category-filter").classList.remove("tutor-show-more-blur");
            }
          }
        },
        complete: function complete() {
          $(".tutor-show-more-loading").html("");
        },
        error: function error(err) {
          alert(err);
        }
      });
    });
  });
  /**
   * Show start active as per click
   * 
   * @since v2.0.0
   */

  var stars = document.querySelectorAll(".tutor-instructor-ratings i");
  var rating_range = document.querySelector(".tutor-instructor-rating-filter");

  var _iterator3 = _createForOfIteratorHelper(stars),
      _step3;

  try {
    for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
      var star = _step3.value;

      star.onclick = function (e) {
        //remove active if has
        var _iterator4 = _createForOfIteratorHelper(stars),
            _step4;

        try {
          for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
            var _star = _step4.value;

            if (_star.classList.contains('active')) {
              _star.classList.remove('active');
            }

            if (_star.classList.contains('ttr-star-full-filled')) {
              _star.classList.remove('ttr-star-full-filled');

              _star.classList.add('ttr-star-line-filled');
            }
          } //show stars active as click

        } catch (err) {
          _iterator4.e(err);
        } finally {
          _iterator4.f();
        }

        var length = e.target.dataset.value;

        for (var i = 0; i < length; i++) {
          stars[i].classList.add('active');
          stars[i].classList.remove('ttr-star-line-filled');
          stars[i].classList.add('ttr-star-full-filled');
        }

        rating_range.innerHTML = "0.0 - ".concat(length, ".0");
      };
    }
  } catch (err) {
    _iterator3.e(err);
  } finally {
    _iterator3.f();
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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!*******************************************!*\
  !*** ./assets/react/front/tutor-front.js ***!
  \*******************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _dashboard__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./dashboard */ "./assets/react/front/dashboard.js");
/* harmony import */ var _pages_instructor_list_filter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./pages/instructor-list-filter */ "./assets/react/front/pages/instructor-list-filter.js");
/* harmony import */ var _pages_instructor_list_filter__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_pages_instructor_list_filter__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _pages_course_landing__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./pages/course-landing */ "./assets/react/front/pages/course-landing.js");
/* harmony import */ var _pages_course_landing__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_pages_course_landing__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _course_index__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./course/index */ "./assets/react/front/course/index.js");
/* harmony import */ var _dashboard_export_csv__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./dashboard/export-csv */ "./assets/react/front/dashboard/export-csv.js");
/* harmony import */ var _dashboard_export_csv__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_dashboard_export_csv__WEBPACK_IMPORTED_MODULE_4__);





jQuery(document).ready(function ($) {
  'use strict';
  /**
   * wp.i18n translateable functions 
   * @since 1.9.0
  */

  var _wp$i18n = wp.i18n,
      __ = _wp$i18n.__,
      _x = _wp$i18n._x,
      _n = _wp$i18n._n,
      _nx = _wp$i18n._nx;
  /**
   * Initiate Select2
   * @since v.1.3.4
   */

  if (jQuery().select2) {
    $('.tutor_select2').select2({
      escapeMarkup: function escapeMarkup(markup) {
        return markup;
      }
    });
  } //END: select2

  /*!
   * jQuery UI Touch Punch 0.2.3
   *
   * Copyright 2011–2014, Dave Furfero
   * Dual licensed under the MIT or GPL Version 2 licenses.
   *
   * Depends:
   *  jquery.ui.widget.js
   *  jquery.ui.mouse.js
   */


  !function (a) {
    function f(a, b) {
      if (!(a.originalEvent.touches.length > 1)) {
        a.preventDefault();
        var c = a.originalEvent.changedTouches[0],
            d = document.createEvent("MouseEvents");
        d.initMouseEvent(b, !0, !0, window, 1, c.screenX, c.screenY, c.clientX, c.clientY, !1, !1, !1, !1, 0, null), a.target.dispatchEvent(d);
      }
    }

    if (a.support.touch = "ontouchend" in document, a.support.touch) {
      var e,
          b = a.ui.mouse.prototype,
          c = b._mouseInit,
          d = b._mouseDestroy;
      b._touchStart = function (a) {
        var b = this;
        !e && b._mouseCapture(a.originalEvent.changedTouches[0]) && (e = !0, b._touchMoved = !1, f(a, "mouseover"), f(a, "mousemove"), f(a, "mousedown"));
      }, b._touchMove = function (a) {
        e && (this._touchMoved = !0, f(a, "mousemove"));
      }, b._touchEnd = function (a) {
        e && (f(a, "mouseup"), f(a, "mouseout"), this._touchMoved || f(a, "click"), e = !1);
      }, b._mouseInit = function () {
        var b = this;
        b.element.bind({
          touchstart: a.proxy(b, "_touchStart"),
          touchmove: a.proxy(b, "_touchMove"),
          touchend: a.proxy(b, "_touchEnd")
        }), c.call(b);
      }, b._mouseDestroy = function () {
        var b = this;
        b.element.unbind({
          touchstart: a.proxy(b, "_touchStart"),
          touchmove: a.proxy(b, "_touchMove"),
          touchend: a.proxy(b, "_touchEnd")
        }), d.call(b);
      };
    }
  }(jQuery);
  /**
   * END jQuery UI Touch Punch
   */

  var videoPlayer = {
    ajaxurl: window._tutorobject.ajaxurl,
    nonce_key: window._tutorobject.nonce_key,
    video_data: function video_data() {
      var video_track_data = $('#tutor_video_tracking_information').val();
      return video_track_data ? JSON.parse(video_track_data) : {};
    },
    track_player: function track_player() {
      var that = this;

      if (typeof Plyr !== 'undefined') {
        var player = new Plyr(this.player_DOM);
        var video_data = that.video_data();
        player.on('ready', function (event) {
          var instance = event.detail.plyr;
          var best_watch_time = video_data.best_watch_time;

          if (best_watch_time > 0 && instance.duration > Math.round(best_watch_time)) {
            instance.media.currentTime = best_watch_time;
          }

          that.sync_time(instance);
        });
        var tempTimeNow = 0;
        var intervalSeconds = 30; //Send to tutor backend about video playing time in this interval

        player.on('timeupdate', function (event) {
          var instance = event.detail.plyr;
          var tempTimeNowInSec = tempTimeNow / 4; //timeupdate firing 250ms interval

          if (tempTimeNowInSec >= intervalSeconds) {
            that.sync_time(instance);
            tempTimeNow = 0;
          }

          tempTimeNow++;
        });
        player.on('ended', function (event) {
          var video_data = that.video_data();
          var instance = event.detail.plyr;
          var data = {
            is_ended: true
          };
          that.sync_time(instance, data);

          if (video_data.autoload_next_course_content) {
            that.autoload_content();
          }
        });
      }
    },
    sync_time: function sync_time(instance, options) {
      var post_id = this.video_data().post_id; //TUTOR is sending about video playback information to server.

      var data = {
        action: 'sync_video_playback',
        currentTime: instance.currentTime,
        duration: instance.duration,
        post_id: post_id
      };
      data[this.nonce_key] = _tutorobject[this.nonce_key];
      var data_send = data;

      if (options) {
        data_send = Object.assign(data, options);
      }

      $.post(this.ajaxurl, data_send);
    },
    autoload_content: function autoload_content() {
      var post_id = this.video_data().post_id;
      var data = {
        action: 'autoload_next_course_content',
        post_id: post_id
      };
      data[this.nonce_key] = _tutorobject[this.nonce_key];
      $.post(this.ajaxurl, data).done(function (response) {
        if (response.success && response.data.next_url) {
          location.href = response.data.next_url;
        }
      });
    },
    init: function init(element) {
      this.player_DOM = element;
      this.track_player();
    }
  };
  /**
   * Fire TUTOR video
   * @since v.1.0.0
   */

  $('.tutorPlayer').each(function () {
    videoPlayer.init(this);
  });
  $(document).on('change keyup paste', '.tutor_user_name', function () {
    $(this).val(tutor_slugify($(this).val()));
  });

  function tutor_slugify(text) {
    return text.toString().toLowerCase().replace(/\s+/g, '-') // Replace spaces with -
    .replace(/[^\w\-]+/g, '') // Remove all non-word chars
    .replace(/\-\-+/g, '-') // Replace multiple - with single -
    .replace(/^-+/, '') // Trim - from start of text
    .replace(/-+$/, ''); // Trim - from end of text
  }

  $(document).on('click', '.tutor_question_cancel', function (e) {
    e.preventDefault();
    $('.tutor-add-question-wrap').toggle();
  });
  /**
   * Quiz attempt
   */

  var $tutor_quiz_time_update = $('#tutor-quiz-time-update');
  var attempt_settings = null;

  if ($tutor_quiz_time_update.length) {
    attempt_settings = JSON.parse($tutor_quiz_time_update.attr('data-attempt-settings'));
    var attempt_meta = JSON.parse($tutor_quiz_time_update.attr('data-attempt-meta'));

    if (attempt_meta.time_limit.time_limit_seconds > 0) {
      //No time Zero limit for
      var countDownDate = new Date(attempt_settings.attempt_started_at).getTime() + attempt_meta.time_limit.time_limit_seconds * 1000;
      var time_now = new Date(attempt_meta.date_time_now).getTime();
      var tutor_quiz_interval = setInterval(function () {
        var distance = countDownDate - time_now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor(distance % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
        var minutes = Math.floor(distance % (1000 * 60 * 60) / (1000 * 60));
        var seconds = Math.floor(distance % (1000 * 60) / 1000);
        var countdown_human = '';

        if (days) {
          countdown_human += days + "d ";
        }

        if (hours) {
          countdown_human += hours + "h ";
        }

        if (minutes) {
          countdown_human += minutes + "m ";
        }

        if (seconds) {
          countdown_human += seconds + "s ";
        }

        if (distance < 0) {
          clearInterval(tutor_quiz_interval);
          countdown_human = "EXPIRED"; //Set the quiz attempt to timeout in ajax

          if (_tutorobject.quiz_options.quiz_when_time_expires === 'autosubmit') {
            /**
             * Auto Submit
             */
            $('form#tutor-answering-quiz').submit();
          } else if (_tutorobject.quiz_options.quiz_when_time_expires === 'autoabandon') {
            /**
             *
             * @type {jQuery}
             *
             * Current attempt will be cancel with attempt status attempt_timeout
             */
            var quiz_id = $('#tutor_quiz_id').val();
            var tutor_quiz_remaining_time_secs = $('#tutor_quiz_remaining_time_secs').val();
            var quiz_timeout_data = {
              quiz_id: quiz_id,
              action: 'tutor_quiz_timeout'
            };
            var att = $("#tutor-quiz-time-expire-wrapper").attr('data-attempt-remaining'); //disable buttons

            $(".tutor-quiz-answer-next-btn, .tutor-quiz-submit-btn, .tutor-quiz-answer-previous-btn").prop('disabled', true); //add alert text

            $(".time-remaining span").css('color', '#F44337');
            $.ajax({
              url: _tutorobject.ajaxurl,
              type: 'POST',
              data: quiz_timeout_data,
              success: function success(data) {
                var attemptAllowed = $("#tutor-quiz-time-expire-wrapper").data('attempt-allowed');
                var attemptRemaining = $("#tutor-quiz-time-expire-wrapper").data('attempt-remaining');
                var alertDiv = "#tutor-quiz-time-expire-wrapper .tutor-alert";
                $(alertDiv).addClass('tutor-alert-show');

                if (att > 0) {
                  $("".concat(alertDiv, " .text")).html(__('Your time limit for this quiz has expired, please reattempt the quiz. Attempts remaining: ' + attemptRemaining + '/' + attemptAllowed, 'tutor'));
                } else {
                  $(alertDiv).addClass('tutor-alert-danger');
                  $("#tutor-start-quiz").hide();
                  $("".concat(alertDiv, " .text")).html("".concat(__('Unfortunately, you are out of time and quiz attempts. ', 'tutor')));
                }
              },
              complete: function complete() {}
            });
          }
        }

        time_now = time_now + 1000;
        $tutor_quiz_time_update.html(countdown_human);
      }, 1000);
    } else {
      $tutor_quiz_time_update.closest('.time-remaining').remove();
    }
  }

  var $quiz_start_form = $('#tutor-quiz-body form#tutor-start-quiz');

  if ($quiz_start_form.length) {
    if (_tutorobject.quiz_options.quiz_auto_start === '1') {
      $quiz_start_form.submit();
    }
  } // Quiz Review : Tooltip


  $(".tooltip-btn").on("hover", function (e) {
    $(this).toggleClass("active");
  }); // tutor course content accordion

  /**
  * Toggle topic summery
  * @since v.1.6.9
  */

  $('.tutor-course-title h4 .toggle-information-icon').on('click', function (e) {
    $(this).closest('.tutor-topics-in-single-lesson').find('.tutor-topics-summery').slideToggle();
    e.stopPropagation();
  });
  $('.tutor-course-topic.tutor-active').find('.tutor-course-lessons').slideDown();
  $('.tutor-course-title').on('click', function () {
    var lesson = $(this).siblings('.tutor-course-lessons');
    $(this).closest('.tutor-course-topic').toggleClass('tutor-active');
    lesson.slideToggle();
  });
  $(document).on('click', '.tutor-topics-title h3 .toggle-information-icon', function (e) {
    $(this).closest('.tutor-topics-in-single-lesson').find('.tutor-topics-summery').slideToggle();
    e.stopPropagation();
  });
  /**
   * Check if lesson has classic editor support
   * If classic editor support, stop ajax load on the lesson page.
   *
   * @since v.1.0.0
   *
   * @updated v.1.4.0
   */

  if (!_tutorobject.enable_lesson_classic_editor) {
    $(document).on('click', '.tutor-single-lesson-a', function (e) {
      e.preventDefault();
      var $that = $(this);
      var lesson_id = $that.attr('data-lesson-id');
      var $wrap = $('#tutor-single-entry-content');
      $.ajax({
        url: _tutorobject.ajaxurl,
        type: 'POST',
        data: {
          lesson_id: lesson_id,
          'action': 'tutor_render_lesson_content'
        },
        beforeSend: function beforeSend() {
          var page_title = $that.find('.lesson_title').text();
          $('head title').text(page_title);
          window.history.pushState('obj', page_title, $that.attr('href'));
          $wrap.addClass('loading-lesson');
          $('.tutor-single-lesson-items').removeClass('active');
          $that.closest('.tutor-single-lesson-items').addClass('active');
        },
        success: function success(data) {
          $wrap.html(data.data.html);
          videoPlayer.init();
          $('.tutor-lesson-sidebar').css('display', '');
          window.dispatchEvent(new window.Event('tutor_ajax_lesson_loaded')); // Some plugins like h5p needs notification on ajax load
        },
        complete: function complete() {
          $wrap.removeClass('loading-lesson');
        }
      });
    });
    $(document).on('click', '.sidebar-single-quiz-a', function (e) {
      e.preventDefault();
      var $that = $(this);
      var quiz_id = $that.attr('data-quiz-id');
      var page_title = $that.find('.lesson_title').text();
      var $wrap = $('#tutor-single-entry-content');
      $.ajax({
        url: _tutorobject.ajaxurl,
        type: 'POST',
        data: {
          quiz_id: quiz_id,
          'action': 'tutor_render_quiz_content'
        },
        beforeSend: function beforeSend() {
          $('head title').text(page_title);
          window.history.pushState('obj', page_title, $that.attr('href'));
          $wrap.addClass('loading-lesson');
          $('.tutor-single-lesson-items').removeClass('active');
          $that.closest('.tutor-single-lesson-items').addClass('active');
        },
        success: function success(data) {
          $wrap.html(data.data.html);
          init_quiz_builder();
          $('.tutor-lesson-sidebar').css('display', '');
        },
        complete: function complete() {
          $wrap.removeClass('loading-lesson');
        }
      });
    });
  }
  /**
   * @date 05 Feb, 2019
   */


  $(document).on('click', '.tutor-lesson-sidebar-hide-bar', function (e) {
    e.preventDefault();
    $('.tutor-lesson-sidebar').toggle();
    $('#tutor-single-entry-content').toggleClass("sidebar-hidden");
  });
  $(".tutor-tabs-btn-group a").on('click touchstart', function (e) {
    e.preventDefault();
    var $that = $(this);
    var tabSelector = $that.attr('href');
    $('.tutor-lesson-sidebar-tab-item').hide();
    $(tabSelector).show();
    $('.tutor-tabs-btn-group a').removeClass('active');
    $that.addClass('active');
  });
  /**
   * @date 18 Feb, 2019
   * @since v.1.0.0
   */

  function init_quiz_builder() {
    if (jQuery().sortable) {
      $(".tutor-quiz-answers-wrap").sortable({
        handle: ".answer-sorting-bar",
        start: function start(e, ui) {
          ui.placeholder.css('visibility', 'visible');
        },
        stop: function stop(e, ui) {//Sorting Stopped...
        }
      }).disableSelection();
      $(".quiz-draggable-rand-answers, .quiz-answer-matching-droppable").sortable({
        connectWith: ".quiz-answer-matching-droppable",
        placeholder: "drop-hover"
      }).disableSelection();
    }
  }

  init_quiz_builder();
  /**
   * Quiz view
   * @date 22 Feb, 2019
   * @since v.1.0.0
   */

  $(document).on('click', '.tutor-quiz-answer-next-btn, .tutor-quiz-answer-previous-btn', function (e) {
    e.preventDefault(); // Show previous quiz if press previous button

    if ($(this).hasClass('tutor-quiz-answer-previous-btn')) {
      $(this).closest('.quiz-attempt-single-question').hide().prev().show();
      return;
    }

    var $that = $(this);
    var $question_wrap = $that.closest('.quiz-attempt-single-question');
    /**
     * Validating required answer
     * @type {jQuery}
     *
     * @since v.1.6.1
     */

    var validated = tutor_quiz_validation($question_wrap);

    if (!validated) {
      return;
    }

    var feedBackNext = feedback_response($question_wrap);

    if (!feedBackNext) {
      return;
    }

    var question_id = parseInt($that.closest('.quiz-attempt-single-question').attr('id').match(/\d+/)[0], 10);
    var next_question_id = $that.closest('.quiz-attempt-single-question').attr('data-next-question-id');

    if (next_question_id) {
      var $nextQuestion = $(next_question_id);

      if ($nextQuestion && $nextQuestion.length) {
        /**
         * check if reveal mode wait for 500ms then
         * hide question so that correct answer reveal
         * @since 1.8.10
        */
        var feedBackMode = $question_wrap.attr('data-quiz-feedback-mode');

        if (feedBackMode === 'reveal') {
          setTimeout(function () {
            $('.quiz-attempt-single-question').hide();
            $nextQuestion.show();
          }, 800);
        } else {
          $('.quiz-attempt-single-question').hide();
          $nextQuestion.show();
        }
        /**
         * If pagination exists, set active class
         */


        if ($('.tutor-quiz-questions-pagination').length) {
          $('.tutor-quiz-question-paginate-item').removeClass('active');
          $('.tutor-quiz-questions-pagination a[href="' + next_question_id + '"]').addClass('active');
        }
      }
    }
  });
  $(document).on('submit', '#tutor-answering-quiz', function (e) {
    var $questions_wrap = $('.quiz-attempt-single-question');
    var validated = true;

    if ($questions_wrap.length) {
      $questions_wrap.each(function (index, question) {
        // !tutor_quiz_validation( $(question) ) ? validated = false : 0;
        // !feedback_response( $(question) ) ? validated = false : 0;
        validated = tutor_quiz_validation($(question));
        validated = feedback_response($(question));
      });
    }

    if (!validated) {
      e.preventDefault();
    }
  });
  $(document).on('click', '.tutor-quiz-question-paginate-item', function (e) {
    e.preventDefault();
    var $that = $(this);
    var $question = $($that.attr('href'));
    $('.quiz-attempt-single-question').hide();
    $question.show(); //Active Class

    $('.tutor-quiz-question-paginate-item').removeClass('active');
    $that.addClass('active');
  });
  /**
   * Limit Short Answer Question Type
   */

  $(document).on('keyup', 'textarea.question_type_short_answer, textarea.question_type_open_ended', function (e) {
    var $that = $(this);
    var value = $that.val();
    var limit = $that.hasClass('question_type_short_answer') ? _tutorobject.quiz_options.short_answer_characters_limit : _tutorobject.quiz_options.open_ended_answer_characters_limit;
    var remaining = limit - value.length;

    if (remaining < 1) {
      $that.val(value.substr(0, limit));
      remaining = 0;
    }

    $that.closest('.tutor-quiz-answers-wrap').find('.characters_remaining').html(remaining);
  });
  /**
   *
   * @type {jQuery}
   *
   * Improved Quiz draggable answers drop accessibility
   * Answers draggable wrap will be now same height.
   *
   * @since v.1.4.4
   */

  var countDraggableAnswers = $('.quiz-draggable-rand-answers').length;

  if (countDraggableAnswers) {
    $('.quiz-draggable-rand-answers').each(function () {
      var $that = $(this);
      var draggableDivHeight = $that.height();
      $that.css({
        "height": draggableDivHeight
      });
    });
  }
  /**
   * Quiz Validation Helper
   *
   * @since v.1.6.1
   */


  function tutor_quiz_validation($question_wrap) {
    var validated = true;
    var $required_answer_wrap = $question_wrap.find('.quiz-answer-required');

    if ($required_answer_wrap.length) {
      /**
       * Radio field validation
       *
       * @type {jQuery}
       *
       * @since v.1.6.1
       */
      var $inputs = $required_answer_wrap.find('input');

      if ($inputs.length) {
        var $type = $inputs.attr('type');

        if ($type === 'radio') {
          if ($required_answer_wrap.find('input[type="radio"]:checked').length == 0) {
            $question_wrap.find('.answer-help-block').html("<p style=\"color: #dc3545\">".concat(__('Please select an option to answer', 'tutor'), "</p>"));
            validated = false;
          }
        } else if ($type === 'checkbox') {
          if ($required_answer_wrap.find('input[type="checkbox"]:checked').length == 0) {
            $question_wrap.find('.answer-help-block').html("<p style=\"color: #dc3545\">".concat(__('Please select at least one option to answer.', 'tutor'), "</p>"));
            validated = false;
          }
        } else if ($type === 'text') {
          //Fill in the gaps if many, validation all
          $inputs.each(function (index, input) {
            if (!$(input).val().trim().length) {
              $question_wrap.find('.answer-help-block').html("<p style=\"color: #dc3545\">".concat(__('The answer for this question is required', 'tutor'), "</p>"));
              validated = false;
            }
          });
        }
      }

      if ($required_answer_wrap.find('textarea').length) {
        if ($required_answer_wrap.find('textarea').val().trim().length < 1) {
          $question_wrap.find('.answer-help-block').html("<p style=\"color: #dc3545\">".concat(__('The answer for this question is required', 'tutor'), "</p>"));
          validated = false;
        }
      }
      /**
       * Matching Question
       */


      var $matchingDropable = $required_answer_wrap.find('.quiz-answer-matching-droppable');

      if ($matchingDropable.length) {
        $matchingDropable.each(function (index, matching) {
          if (!$(matching).find('.quiz-draggable-answer-item').length) {
            $question_wrap.find('.answer-help-block').html("<p style=\"color: #dc3545\">".concat(__('Please match all the items', 'tutor'), "</p>"));
            validated = false;
          }
        });
      }
    }

    return validated;
  }

  function feedback_response($question_wrap) {
    var goNext = false; // Prepare answer array            

    var quiz_answers = JSON.parse(atob(window.tutor_quiz_context.split('').reverse().join('')));
    !Array.isArray(quiz_answers) ? quiz_answers = [] : 0; // Evaluate result

    var feedBackMode = $question_wrap.attr('data-quiz-feedback-mode');
    $('.wrong-right-text').remove();
    $('.quiz-answer-input-bottom').removeClass('wrong-answer right-answer');
    var validatedTrue = true;
    var $inputs = $question_wrap.find('input');
    var $checkedInputs = $question_wrap.find('input[type="radio"]:checked, input[type="checkbox"]:checked');

    if (feedBackMode === 'retry') {
      $checkedInputs.each(function () {
        var $input = $(this);
        var $type = $input.attr('type');

        if ($type === 'radio' || $type === 'checkbox') {
          var isTrue = quiz_answers.indexOf($input.val()) > -1; // $input.attr('data-is-correct') == '1';

          if (!isTrue) {
            if ($input.prop("checked")) {
              $input.closest('.quiz-answer-input-bottom').addClass('wrong-answer').append("<span class=\"wrong-right-text\"><i class=\"tutor-icon-line-cross\"></i> ".concat(__('Incorrect, Please try again', 'tutor'), "</span>"));
            }

            validatedTrue = false;
          }
        }
      });
      $inputs.each(function () {
        var $input = $(this);
        var $type = $input.attr('type');

        if ($type === 'checkbox') {
          var isTrue = quiz_answers.indexOf($input.val()) > -1; // $input.attr('data-is-correct') == '1';

          var checked = $input.is(':checked');

          if (isTrue && !checked) {
            $question_wrap.find('.answer-help-block').html("<p style=\"color: #dc3545\">".concat(__('More answer for this question is required', 'tutor'), "</p>"));
            validatedTrue = false;
          }
        }
      });
    } else if (feedBackMode === 'reveal') {
      $checkedInputs.each(function () {
        var $input = $(this);
        var isTrue = quiz_answers.indexOf($input.val()) > -1; // $input.attr('data-is-correct') == '1';

        if (!isTrue) {
          validatedTrue = false;
        }
      });
      $inputs.each(function () {
        var $input = $(this);
        var $type = $input.attr('type');

        if ($type === 'radio' || $type === 'checkbox') {
          var isTrue = quiz_answers.indexOf($input.val()) > -1; // $input.attr('data-is-correct') == '1';

          var checked = $input.is(':checked');

          if (isTrue) {
            $input.closest('.quiz-answer-input-bottom').addClass('right-answer').append("<span class=\"wrong-right-text\"><i class=\"tutor-icon-checkbox-pen-outline\"></i>".concat(__('Correct Answer', 'tutor'), "</span>"));
          } else {
            if ($input.prop("checked")) {
              $input.closest('.quiz-answer-input-bottom').addClass('wrong-answer');
            }
          }

          if (isTrue && !checked) {
            $input.attr('disabled', 'disabled');
            validatedTrue = false;
            goNext = true;
          }
        }
      });
    }

    if (validatedTrue) {
      goNext = true;
    }

    return goNext;
  }
  /**
   * Share Link enable
   *
   * @since v.1.0.4
   */


  if ($.fn.ShareLink) {
    var $social_share_wrap = $('.tutor-social-share-wrap');

    if ($social_share_wrap.length) {
      var share_config = JSON.parse($social_share_wrap.attr('data-social-share-config'));
      $('.tutor_share').ShareLink({
        title: share_config.title,
        text: share_config.text,
        image: share_config.image,
        class_prefix: 's_',
        width: 640,
        height: 480
      });
    }
  }
  /**
   * Datepicker initiate
   *
   * @since v.1.1.2
   */


  if (jQuery.datepicker) {
    $(".tutor_report_datepicker").datepicker({
      "dateFormat": 'yy-mm-dd'
    });
  }
  /**
   * Setting account for withdraw earning
   *
   * @since v.1.2.0
   */


  $(document).on('submit', '#tutor-withdraw-account-set-form', function (e) {
    e.preventDefault();
    var $form = $(this);
    var $btn = $form.find('.tutor_set_withdraw_account_btn');
    var data = $form.serializeObject();
    $.ajax({
      url: _tutorobject.ajaxurl,
      type: 'POST',
      data: data,
      beforeSend: function beforeSend() {
        $btn.addClass('updating-icon');
      },
      success: function success(data) {
        if (data.success) {
          tutor_toast('Success!', data.data.msg, 'success', false);
        }
      },
      complete: function complete() {
        $btn.removeClass('updating-icon');
      }
    });
  });
  /**
   * Make Withdraw Form
   *
   * @since v.1.2.0
   */

  $(document).on('click', '.open-withdraw-form-btn, .close-withdraw-form-btn', function (e) {
    e.preventDefault();

    if ($(this).data('reload') == 'yes') {
      window.location.reload();
      return;
    }

    $('.tutor-earning-withdraw-form-wrap').toggle().find('[name="tutor_withdraw_amount"]').val('');
    $('.tutor-withdrawal-pop-up-success').hide().next().show();
    $('html, body').css('overflow', $('.tutor-earning-withdraw-form-wrap').is(':visible') ? 'hidden' : 'auto');
  });
  $(document).on('submit', '#tutor-earning-withdraw-form', function (e) {
    e.preventDefault();
    var $form = $(this);
    var $btn = $('#tutor-earning-withdraw-btn');
    var $responseDiv = $('.tutor-withdraw-form-response');
    var data = $form.serializeObject();
    $.ajax({
      url: _tutorobject.ajaxurl,
      type: 'POST',
      data: data,
      beforeSend: function beforeSend() {
        $form.find('.tutor-success-msg').remove();
        $btn.addClass('updating-icon');
      },
      success: function success(data) {
        var Msg;

        if (data.success) {
          if (data.data.available_balance !== 'undefined') {
            $('.withdraw-balance-col .available_balance').html(data.data.available_balance);
          }

          $('.tutor-withdrawal-pop-up-success').show().next().hide();
        } else {
          Msg = '<div class="tutor-error-msg inline-image-text is-inline-block">\
                            <img src="' + window._tutorobject.tutor_url + 'assets/images/icon-cross.svg"/> \
                            <div>\
                                <b>Error</b><br/>\
                                <span>' + data.data.msg + '</span>\
                            </div>\
                        </div>';
          $responseDiv.html(Msg);
          setTimeout(function () {
            $responseDiv.html('');
          }, 5000);
        }
      },
      complete: function complete() {
        $btn.removeClass('updating-icon');
      }
    });
  });
  /**
   * Delete Course
   */

  $(document).on('click', '.tutor-dashboard-element-delete-btn', function (e) {
    e.preventDefault();
    var element_id = $(this).attr('data-id');
    $('#tutor-dashboard-delete-element-id').val(element_id);
  });
  $(document).on('submit', '#tutor-dashboard-delete-element-form', function (e) {
    e.preventDefault();
    var element_id = $('#tutor-dashboard-delete-element-id').val();
    var $btn = $('.tutor-modal-element-delete-btn');
    var data = $(this).serializeObject();
    $.ajax({
      url: _tutorobject.ajaxurl,
      type: 'POST',
      data: data,
      beforeSend: function beforeSend() {
        $btn.addClass('updating-icon');
      },
      success: function success(res) {
        if (res.success) {
          $('#tutor-dashboard-' + res.data.element + '-' + element_id).remove();
        }
      },
      complete: function complete() {
        $btn.removeClass('updating-icon');
      }
    });
  });
  /**
   * Frontend Profile
   */

  if (!$('#tutor_profile_photo_id').val()) {
    $('.tutor-profile-photo-delete-btn').hide();
  }

  $(document).on('click', '.tutor-profile-photo-delete-btn', function () {
    $('.tutor-profile-photo-upload-wrap').find('img').attr('src', _tutorobject.placeholder_img_src);
    $('#tutor_profile_photo_id').val('');
    $('.tutor-profile-photo-delete-btn').hide();
    $.ajax({
      url: _tutorobject.ajaxurl,
      type: 'POST',
      data: {
        'action': 'tutor_profile_photo_remove'
      }
    });
    return false;
  });
  /**
   * Assignment
   *
   * @since v.1.3.3
   */

  $(document).on('submit', '#tutor_assignment_start_form', function (e) {
    e.preventDefault();
    var $that = $(this);
    var form_data = $that.serializeObject();
    form_data.action = 'tutor_start_assignment';
    $.ajax({
      url: _tutorobject.ajaxurl,
      type: 'POST',
      data: form_data,
      beforeSend: function beforeSend() {
        $('#tutor_assignment_start_btn').addClass('updating-icon');
      },
      success: function success(data) {
        if (data.success) {
          location.reload();
        }
      },
      complete: function complete() {
        $('#tutor_assignment_start_btn').removeClass('updating-icon');
      }
    });
  });
  /**
   * Assignment answer validation
   */

  $(document).on('submit', '#tutor_assignment_submit_form', function (e) {
    var assignment_answer = $('textarea[name="assignment_answer"]').val();

    if (assignment_answer.trim().length < 1) {
      $('#form_validation_response').html('<div class="tutor-error-msg">' + __('Assignment answer can not be empty', 'tutor') + '</div>');
      e.preventDefault();
    }
  });
  /**
   * Single Assignment Upload Button
   * @since v.1.3.4
   */

  $('form').on('change', '.tutor-assignment-file-upload', function () {
    $(this).siblings("label").find('span').html($(this).val().replace(/.*(\/|\\)/, ''));
  });
  /**
   * Lesson Sidebar Topic Toggle
   * @since v.1.3.4
   */

  $(document).on('click', '.tutor-topics-in-single-lesson .tutor-topics-title h3, .tutor-single-lesson-topic-toggle', function (e) {
    var $that = $(this);
    var $parent = $that.closest('.tutor-topics-in-single-lesson');
    $parent.toggleClass('tutor-topic-active');
    $parent.find('.tutor-lessons-under-topic').slideToggle();
  });
  $('.tutor-single-lesson-items.active').closest('.tutor-lessons-under-topic').show();
  $('.tutor-single-lesson-items.active').closest('.tutor-topics-in-single-lesson').addClass('tutor-topic-active');
  $('.tutor-course-lesson.active').closest('.tutor-lessons-under-topic').show();
  /**
   * Add Assignment
   */

  $(document).on('click', '.add-assignment-attachments', function (event) {
    event.preventDefault();
    var $that = $(this);
    var frame; // If the media frame already exists, reopen it.

    if (frame) {
      frame.open();
      return;
    } // Create a new media frame


    frame = wp.media({
      title: __('Select / Upload Media Of Your Chosen Persuasion', 'tutor'),
      button: {
        text: __('Use media', 'tutor')
      },
      multiple: false // Set to true to allow multiple files to be selected

    }); // When an image is selected in the media frame...

    frame.on('select', function () {
      // Get media attachment details from the frame state
      var attachment = frame.state().get('selection').first().toJSON();
      var field_markup = '<div class="tutor-individual-attachment-file"><p class="attachment-file-name">' + attachment.filename + '</p><input type="hidden" name="tutor_assignment_attachments[]" value="' + attachment.id + '"><a href="javascript:;" class="remove-assignment-attachment-a text-muted"> &times; Remove</a></div>';
      $('#assignment-attached-file').append(field_markup);
      $that.closest('.video_source_upload_wrap_html5').find('input').val(attachment.id);
    }); // Finally, open the modal on click

    frame.open();
  });
  $(document).on('click', '.remove-assignment-attachment-a', function (event) {
    event.preventDefault();
    $(this).closest('.tutor-individual-attachment-file').remove();
  });
  /**
   *
   * @type {jQuery}
   *
   * Course builder auto draft save
   *
   * @since v.1.3.4
   */

  var tutor_course_builder = $('input[name="tutor_action"]').val();

  if (tutor_course_builder === 'tutor_add_course_builder') {
    setInterval(auto_draft_save_course_builder, 30000);
  }

  function auto_draft_save_course_builder() {
    var form_data = $('form#tutor-frontend-course-builder').serializeObject();
    form_data.tutor_ajax_action = 'tutor_course_builder_draft_save';
    $.ajax({
      //url : _tutorobject.ajaxurl,
      type: 'POST',
      data: form_data,
      beforeSend: function beforeSend() {
        $('.tutor-dashboard-builder-draft-btn span').text(__('Saving...', 'tutor'));
      },
      success: function success(data) {},
      complete: function complete() {
        $('.tutor-dashboard-builder-draft-btn span').text(__('Save', 'tutor'));
      }
    });
  }
  /**
   *
   * @type {jQuery}
   *
   * Course builder section toggle
   *
   * @since v.1.3.5
   */


  $('.tutor-course-builder-section-title').on('click', function () {
    if ($(this).find('i').hasClass("tutor-icon-up")) {
      $(this).find('i').removeClass('tutor-icon-up').addClass('tutor-icon-down');
    } else {
      $(this).find('i').removeClass('tutor-icon-down').addClass('tutor-icon-up');
    }

    $(this).next('div').slideToggle();
  });
  /**
   * Profile photo upload
   * @since v.1.4.5
   */

  $(document).on('click', '#tutor_profile_photo_button', function (e) {
    e.preventDefault();
    $('#tutor_profile_photo_file').trigger('click');
  });
  $(document).on('change', '#tutor_profile_photo_file', function (event) {
    event.preventDefault();
    var $file = this;

    if ($file.files && $file.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('.tutor-profile-photo-upload-wrap').find('img').attr('src', e.target.result);
      };

      reader.readAsDataURL($file.files[0]);
    }
  });
  /**
   * Addon, Tutor BuddyPress
   * Retrieve MetaInformation on BuddyPress message system
   * @for TutorLMS Pro
   * @since v.1.4.8
   */

  $(document).on('click', '.thread-content .subject', function (e) {
    var $btn = $(this);
    var thread_id = parseInt($btn.closest('.thread-content').attr('data-thread-id'));
    var nonce_key = _tutorobject.nonce_key;
    var json_data = {
      thread_id: thread_id,
      action: 'tutor_bp_retrieve_user_records_for_thread'
    };
    json_data[nonce_key] = _tutorobject[nonce_key];
    $.ajax({
      type: 'POST',
      url: window._tutorobject.ajaxurl,
      data: json_data,
      beforeSend: function beforeSend() {
        $('#tutor-bp-thread-wrap').html('');
      },
      success: function success(data) {
        if (data.success) {
          $('#tutor-bp-thread-wrap').html(data.data.thread_head_html);
          tutor_bp_setting_enrolled_courses_list();
        }
      }
    });
  });

  function tutor_bp_setting_enrolled_courses_list() {
    $('ul.tutor-bp-enrolled-course-list').each(function () {
      var $that = $(this);
      var $li = $that.find(' > li');
      var itemShow = 3;

      if ($li.length > itemShow) {
        var plusCourseCount = $li.length - itemShow;
        $li.each(function (liIndex, liItem) {
          var $liItem = $(this);

          if (liIndex >= itemShow) {
            $liItem.hide();
          }
        });
        var infoHtml = '<a href="javascript:;" class="tutor_bp_plus_courses"><strong>+' + plusCourseCount + ' More </strong></a> Courses';
        $that.closest('.tutor-bp-enrolled-courses-wrap').find('.thread-participant-enrolled-info').html(infoHtml);
      }

      $that.show();
    });
  }

  tutor_bp_setting_enrolled_courses_list();
  $(document).on('click', 'a.tutor_bp_plus_courses', function (e) {
    e.preventDefault();
    var $btn = $(this);
    $btn.closest('.tutor-bp-enrolled-courses-wrap').find('.tutor-bp-enrolled-course-list li').show();
    $btn.closest('.thread-participant-enrolled-info').html('');
  });
  /**
   * Addon, Tutor Certificate
   * Certificate dropdown content and copy link
   * @for TutorLMS Pro
   * @since v.1.5.1
   */
  //$(document).on('click', '.tutor-dropbtn', function (e) {

  $('.tutor-dropbtn').click(function () {
    var $content = $(this).parent().find(".tutor-dropdown-content");
    $content.slideToggle(100);
  });
  $(document).on('click', function (e) {
    var container = $(".tutor-dropdown");
    var $content = container.find('.tutor-dropdown-content'); // if the target of the click isn't the container nor a descendant of the container

    if (!container.is(e.target) && container.has(e.target).length === 0) {
      $content.slideUp(100);
    }
  });
  /**
   * Tutor ajax login
   *
   * @since v.1.6.3
   */

  $(document).on('submit', '.tutor-login-form-wrap #loginform', function (e) {
    e.preventDefault();
    var $that = $(this);
    var $form_wrapper = $('.tutor-login-form-wrap');
    var form_data = $that.serializeObject();
    form_data.action = 'tutor_user_login';
    $.ajax({
      url: _tutorobject.ajaxurl,
      type: 'POST',
      data: form_data,
      success: function success(response) {
        if (response.success) {
          location.assign(response.data.redirect);
          location.reload();
        } else {
          var error_message = response.data || __('Invalid username or password!', 'tutor');

          if ($form_wrapper.find('.tutor-alert').length) {
            $form_wrapper.find('.tutor-alert').html(error_message);
          } else {
            $form_wrapper.prepend('<div class="tutor-alert tutor-alert-warning">' + error_message + '</div>');
          }
        }
      }
    });
  });
  /**
   * Show hide is course public checkbox (frontend dashboard editor)
   * 
   * @since  v.1.7.2
  */

  var price_type = $('.tutor-frontend-builder-course-price [name="tutor_course_price_type"]');

  if (price_type.length == 0) {
    $('#_tutor_is_course_public_meta_checkbox').show();
  } else {
    price_type.change(function () {
      if ($(this).prop('checked')) {
        var method = $(this).val() == 'paid' ? 'hide' : 'show';
        $('#_tutor_is_course_public_meta_checkbox')[method]();
      }
    }).trigger('change');
  }
  /**
   * Withdrawal page tooltip
   * 
   * @since  v.1.7.4
  */
  // Fully accessible tooltip jQuery plugin with delegation.
  // Ideal for view containers that may re-render content.


  (function ($) {
    $.fn.tutor_tooltip = function () {
      this // Delegate to tooltip, Hide if tooltip receives mouse or is clicked (tooltip may stick if parent has focus)
      .on('mouseenter click', '.tooltip', function (e) {
        e.stopPropagation();
        $(this).removeClass('isVisible');
      }) // Delegate to parent of tooltip, Show tooltip if parent receives mouse or focus
      .on('mouseenter focus', ':has(>.tooltip)', function (e) {
        if (!$(this).prop('disabled')) {
          // IE 8 fix to prevent tooltip on `disabled` elements
          $(this).find('.tooltip').addClass('isVisible');
        }
      }) // Delegate to parent of tooltip, Hide tooltip if parent loses mouse or focus
      .on('mouseleave blur keydown', ':has(>.tooltip)', function (e) {
        if (e.type === 'keydown') {
          if (e.which === 27) {
            $(this).find('.tooltip').removeClass('isVisible');
          }
        } else {
          $(this).find('.tooltip').removeClass('isVisible');
        }
      });
      return this;
    };
  })(jQuery); // Bind event listener to container element


  jQuery('.tutor-tooltip-inside').tutor_tooltip();
  /**
   * Manage course filter
   * 
   * @since  v.1.7.2
  */

  var filter_container = $('.tutor-course-filter-container form');
  var loop_container = $('.tutor-course-filter-loop-container');
  var filter_modifier = {}; // Sidebar checkbox value change

  filter_container.on('submit', function (e) {
    e.preventDefault();
  }).find('input').change(function (e) {
    var filter_criteria = Object.assign(filter_container.serializeObject(), filter_modifier);
    filter_criteria.action = 'tutor_course_filter_ajax';
    loop_container.html('<center><img src="' + window._tutorobject.loading_icon_url + '"/></center>');
    $(this).closest('form').find('.tutor-clear-all-filter').show();
    $.ajax({
      url: window._tutorobject.ajaxurl,
      type: 'POST',
      data: filter_criteria,
      success: function success(r) {
        loop_container.html(r).find('.tutor-pagination-wrap a').each(function () {
          $(this).attr('data-href', $(this).attr('href')).attr('href', '#');
        });
      }
    });
  }); // Alter pagination

  loop_container.on('click', '.tutor-pagination-wrap a', function (e) {
    var url = $(this).data('href') || $(this).attr('href');

    if (url) {
      url = new URL(url);
      var page = url.searchParams.get("paged");

      if (page) {
        e.preventDefault();
        filter_modifier.page = page;
        filter_container.find('input:first').trigger('change');
      }
    }
  }); // Alter sort filter

  loop_container.on('change', 'select[name="tutor_course_filter"]', function () {
    filter_modifier.tutor_course_filter = $(this).val();
    filter_container.find('input:first').trigger('change');
  }); // Refresh page after coming back to course archive page from cart

  var archive_loop = $('.tutor-course-loop');

  if (archive_loop.length > 0) {
    window.sessionStorage.getItem('tutor_refresh_archive') === 'yes' ? window.location.reload() : 0;
    window.sessionStorage.removeItem('tutor_refresh_archive');
    archive_loop.on('click', '.tutor-loop-cart-btn-wrap', function () {
      window.sessionStorage.setItem('tutor_refresh_archive', 'yes');
    });
  } //warn user before leave page if quiz is running


  document.body.addEventListener('click', function (event) {
    var target = event.target;
    var targetTag = target.tagName;
    var parentTag = target.parentElement.tagName;

    if ($tutor_quiz_time_update.length > 0 && $tutor_quiz_time_update.html() != 'EXPIRED') {
      if (targetTag === 'A' || parentTag === 'A') {
        event.preventDefault();
        event.stopImmediatePropagation();
        var popup;
        var data = {
          title: __('Abandon Quiz?', 'tutor'),
          description: __('Do you want to abandon this quiz? The quiz will be submitted partially up to this question if you leave this page.', 'tutor'),
          buttons: {
            keep: {
              title: __('Yes, leave quiz', 'tutor'),
              id: 'leave',
              "class": 'tutor-btn tutor-is-outline tutor-is-default',
              callback: function callback() {
                var formData = $('form#tutor-answering-quiz').serialize() + '&action=' + 'tutor_quiz_abandon';
                $.ajax({
                  url: window._tutorobject.ajaxurl,
                  type: 'POST',
                  data: formData,
                  beforeSend: function beforeSend() {
                    document.querySelector("#tutor-popup-leave").innerHTML = __('Leaving...', 'tutor');
                  },
                  success: function success(response) {
                    if (response.success) {
                      if (target.href == undefined) {
                        location.href = target.parentElement.href;
                      } else {
                        location.href = target.href;
                      }
                    } else {
                      alert(__('Something went wrong', 'tutor'));
                    }
                  },
                  error: function error() {
                    alert(__('Something went wrong', 'tutor'));
                    popup.remove();
                  }
                });
              }
            },
            reset: {
              title: __('Stay here', 'tutor'),
              id: 'reset',
              "class": 'tutor-btn',
              callback: function callback() {
                popup.remove();
              }
            }
          }
        };
        popup = new window.tutor_popup($, '', 40).popup(data);
      }
    }
  });
  /* Disable start quiz button  */

  $('body').on('submit', 'form#tutor-start-quiz', function () {
    $(this).find('button').prop('disabled', true);
  });
});
})();

/******/ })()
;
//# sourceMappingURL=tutor-front.js.map