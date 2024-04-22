// ---------------------------------------- Function buat play & pause video ----------------------------------------

let video = $("#mainVideo");
let play = $(".fa-play-circle");
let pause = $(".fa-pause-circle");

$("#mainVideo").on({
  mouseenter: function () {
    if (video.get(0).paused) {
      play.css("display", "block");
      play.hover(
        function () {
          play.css("display", "block");
        },
        function () {
          play.css("display", "none");
        }
      );
      play.click(function () {
        video.get(0).play();
        play.css("display", "none");
        pause.css("display", "block");
      });
      pause.click(function () {
        video.get(0).pause();
        play.css("display", "block");
        pause.css("display", "none");
      });
    } else {
      pause.css("display", "block");
      pause.hover(
        function () {
          pause.css("display", "block");
        },
        function () {
          pause.css("display", "none");
        }
      );
      pause.click(function () {
        video.get(0).pause();
        play.css("display", "block");
        pause.css("display", "none");
      });
    }
  },
  mouseleave: function () {
    play.css("display", "none");
    pause.css("display", "none");
  },
});

