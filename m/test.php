<!DOCTYPE html>
<html>
  <body>
    <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
    <div id="player"></div>

		<script type="text/javascript">
			// 2. This code loads the IFrame Player API code asynchronously.
			var tag = document.createElement('script');

			tag.src = "https://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			// 3. This function creates an <iframe> (and YouTube player)
			//    after the API code downloads.
			var player;
			function onYouTubeIframeAPIReady() {
				player = new YT.Player('player', {
					height: '350',
					width: '350',
					videoId: 'xQl4TiMcR4M',
					playerVars: { 'autoplay': 0, 'controls': 0 }
				});
			}

		</script>
  </body>
</html>