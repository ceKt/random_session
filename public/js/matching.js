/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/matching.js ***!
  \**********************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

$(function () {
  var matching = 0;
  setInterval(matchcheck, 3000);
  $("#matchbutton").click(matchstart);

  function matchstart() {
    //console.log(document.getElementsByName("contents").id);
    var ci = -1,
        si = -1;

    for (var i in document.getElementsByName("contents")) {
      if (document.getElementsByName("contents").item(i).checked) {
        ci = document.getElementsByName("contents").item(i).id;
        si = document.getElementsByName("contents").item(i).value;
        break;
      }
    } //console.log(document.getElementById('player_id').value);


    var pi = document.getElementById('player_id').value;
    $.ajax({
      type: "post",
      //HTTP通信の種類
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/matchstart',
      //通信したいURL
      //dataType: 'json',
      //contentType: 'application/json',
      //processData: false,
      data: {
        content_id: ci,
        session_id: si,
        player_id: pi
      }
    }) //通信が成功したとき
    .done(function (res) {
      console.log(res);

      if (res == 1) {
        matching = 1; //console.log(res.message);

        document.getElementById("inputbutton").innerHTML = '<button class="btn btn-primary" type="button" id="stopmatch"><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>マッチング中</button>';
        document.getElementById("stopmatch").onclick = "";
        document.getElementById("stopmatch").addEventListener("click", matchstop);
      }
    }) //通信が失敗したとき
    .fail(function (error) {
      console.log(error.statusText);
    });
  }

  function matchstop() {
    //console.log("wadwdadw");
    $.ajax({
      type: "get",
      url: "/matchstop",
      dataType: 'json'
    }).done(function (res) {
      matching = 0;
      console.log(res);
      document.getElementById("inputbutton").innerHTML = 'ID : <input type=text id="player_id">&nbsp;<button type="button" id="matchbutton" class="btn btn-primary">session開始</button>';
      document.getElementById("matchbutton").onclick = "";
      document.getElementById("matchbutton").addEventListener("click", matchstart);
    }).fail(function (error) {
      console.log(error.statusText);
    });
  }

  function matchcheck() {
    console.log(matching);

    if (matching == 1) {
      $.ajax({
        type: "get",
        //HTTP通信の種類
        url: '/matchcheck',
        //通信したいURL
        dataType: "json"
      }) //通信が成功したとき
      .done(function (res) {
        if (res["result"] == 200) {
          window.location.href = res["link"];
        }

        console.log(res["nummatchpeople"]);

        var _iterator = _createForOfIteratorHelper(res["nummatchpeople"]),
            _step;

        try {
          for (_iterator.s(); !(_step = _iterator.n()).done;) {
            var session = _step.value;
            document.getElementById(session["content_id"] + "/" + session["session_id"]).textContent = session["nummatchpeople"] + "人";
          }
        } catch (err) {
          _iterator.e(err);
        } finally {
          _iterator.f();
        }
      }) //通信が失敗したとき
      .fail(function (error) {
        console.log(error.statusText);
      });
    }
  }
});
/******/ })()
;