function calculateTotalValue(length) {
  var current_hour = parseInt(length / 3600) % 24,
    current_minute = parseInt(length / 60) % 60,
    current_seconds_long = length % 60,
    current_seconds = current_seconds_long.toFixed(),
    current_time = (current_minute < 10 ? "0" + current_minute : current_minute) + ":" + (current_seconds < 10 ? "0" + current_seconds : current_seconds);

  return current_time;
}

function calculateCurrentValue(currentTime) {
  var current_hour = parseInt(currentTime / 3600) % 24,
    current_minute = parseInt(currentTime / 60) % 60,
    current_seconds_long = currentTime % 60,
    current_seconds = current_seconds_long.toFixed(),
    current_time = (current_minute < 10 ? "0" + current_minute : current_minute) + ":" + (current_seconds < 10 ? "0" + current_seconds : current_seconds);

  return current_time;
}

function initProgressBar($player) {
  var player = $player[0];
  var length = player.duration
  var current_time = player.currentTime;
	
  // calculate total length of value
  var totalLength = calculateTotalValue(length);
  $player.parents(".audio-player").find(".end-time").html(totalLength);

  // calculate current value time
  var currentTime = calculateCurrentValue(current_time);
  $player.parents(".audio-player").find(".start-time").html(currentTime);

	var $progressbar = $player.parents(".audio-player").find(".pbar");
	
  $progressbar.css("left",Math.round(current_time / length * 100)+"%")
};

function initPlayers($player) {
    // pass num in if there are multiple audio players e.g 'player' + i

    // Variables
    // ----------------------------------------------------------
    // audio embed object
    var playerContainer = $player,
    player = $player.find('.player')[0],
    isPlaying = false,
    $playBtn = $player.find('.play-btn'),
    $pauseBtn = $player.find('.pause-btn');

    var length = player.duration;
    var current_time = player.currentTime;
    // calculate total length of value
    var totalLength = calculateTotalValue(length);
    $player.find(".end-time").html(totalLength);
    // Controls Listeners
    // ----------------------------------------------------------
    
    if ($playBtn != null) {
    $playBtn.click(function() {
      togglePlay();
    });
    }
    
    if ($pauseBtn != null) {
    $pauseBtn.click(function() {
      togglePause();
    });
    }


    var progressbar = $player.find('.seekObj')[0];
    progressbar.value = (player.currentTime / player.duration);
    progressbar.addEventListener("click", seek);
    var $progressbar = $player.find(".pbar");

    if (player.currentTime == player.duration) {
      $player.find('.play-btn').removeClass('pause');
    }
    
    function seek(evt) {
      var percent = evt.offsetX / this.offsetWidth;
      player.currentTime = percent * player.duration;
      progressbar.value = percent / 100;
    }

    $progressbar.css("left",Math.round(current_time / length * 100)+"%")

    // Controls & Sounds Methods
    // ----------------------------------------------------------
    function togglePlay() {
      if (player.paused === false) {

      } else {
        player.play();
        isPlaying = true;
        $playBtn.addClass('active');
        $pauseBtn.removeClass('active');
        $player.addClass("playing")
      }
    }

    function togglePause() {
      if (player.paused === false) {
        player.pause();
        isPlaying = false;
        $playBtn.removeClass('active');
        $pauseBtn.addClass('active');
        $player.removeClass("playing")
      } else {
      }
    }	
	
}

function changeAudioSource($playerContainer, newSrc) {
  var $audio = $playerContainer.find('.player');
  var audio = $audio[0];
  
  // Change source and reload
  $audio.find('source').attr('src', newSrc);
  audio.load();

  // Reset player UI
  $playerContainer.find('.start-time').html("00:00");
  $playerContainer.find('.end-time').html("00:00");
  $playerContainer.find('.pbar').css("left", "0%");
  $playerContainer.find('.seekObj').val(0);
  $playerContainer.removeClass("playing");
  $playerContainer.find('.play-btn').removeClass('active');
  $playerContainer.find('.pause-btn').addClass('active');

  // When metadata is loaded, update total duration
  $audio.on('loadedmetadata', function () {
    var totalLength = calculateTotalValue(audio.duration);
    $playerContainer.find('.end-time').html(totalLength);
  });
}

$(window).on('load', function() {

  $('.audio-player').each(function(){
    initPlayers($(this));
  })
  $(".player").each(function(){
    $(this).on('timeupdate', function() {
        initProgressBar($(this));
    });
  })

});