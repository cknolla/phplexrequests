
<div class="requests form large-9 medium-8 columns content">

	<div class="jumbotron">
		<h2>Search</h2>
			<?php
			echo $this->Form->input('user_id', [
				'type' => 'hidden',
				'value' => '1',
			]);
			echo $this->Form->input('search', [
				'type' => 'text',
				'label' => false,
				'class' => 'form-control',
			]);
			?>
			<div id="search-prompt"></div>
	</div>

	<div id="search-results">
		<!--
		<?php foreach($queryData as $result): ?>
			<div class="search-result">
				<div class="row">
					<div class="col-md-4">
						<?php if(!empty($result->poster)): ?>
							<img src="/img/<?= $result->poster?>" class="img-responsive">
						<?php endif; ?>
					</div>
					<div class="col-md-8">
						<div class="row">
							<div class="col-xs-8 seriesName">
								<?= $result->seriesName ?>
							</div>
							<div class="col-xs-4 requestButton">
								<?= $this->Form->button('Request', [
									'class' => 'btn btn-primary'
								]); ?>
							</div>
						</div>
						<div class="row seriesStats">
							<div class="col-xs-4 firstAired">
								<?= empty($result->firstAired) ? '&nbsp;' : substr($result->firstAired,0,4) ?>
							</div>
							<div class="col-xs-4 network">
								<?= empty($result->network) ? '&nbsp;' : $result->network ?>
							</div>
							<div class="col-xs-4 status">
								<?= empty($result->status) ? '&nbsp;' : $result->status ?>
							</div>
						</div>
						<div class="row">
							<?= empty($result->overview) ? '&nbsp;' : nl2br($result->overview) ?>
						</div>
					</div>
				</div>

			</div>
			<hr>
		<?php endforeach; ?>
		-->
	</div>
</div>

<script>
	function nl2br (str, is_xhtml) {
		var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
	}

	$(function() {
		//setup before functions
		var typingTimer;                //timer identifier
		var doneTypingInterval = 1000;  //time in ms (1 seconds)

		//on keyup, start the countdown
		$('#search').keyup(function(){
			clearTimeout(typingTimer);
			if ($('#search').val()) {
				typingTimer = setTimeout(doneTyping, doneTypingInterval);
			}
		});

		//user is "finished typing," do something
		function doneTyping () {
			$("#search-results").empty();
			$("#search-prompt").empty();
			$("#search-prompt").append("Searching...");
			$.ajax({
				type: 'POST',
				url: '<?php echo $this->Url->build([
					'controller' => 'Requests',
					'action' => 'query-tv',
					//	'_ext' => 'json'
				])
				;?>',
				dataType: 'json',
				data: {
					searchString: $("#search").val()
				},
				success: function (response) {
					$("#search-prompt").empty();
					if (response) {
						if (response.success != "yes") {
							$("#search-prompt").append(response.error);
						} else {
							response.shows.forEach(addShow);
						}
					}
				},
				error: function (xhr, textStatus, err) {
					console.log("readyState: " + xhr.readyState);
					console.log("responseText: " + xhr.responseText);
					console.log("status: " + xhr.status);
					console.log("text status: " + textStatus);
					console.log("error: " + err);
				}
			});
		}
	})

function addShow(item, index) {
	if(item.poster == null) {
		item.poster = 'no_image.png';
	}
	if(item.overview == null) {
		item.overview = 'No description available.';
	}
	$('#search-results').append('' +
		'<div class="search-result">' +
			'<div class="row">' +
				'<div class="col-md-4">' +
					'<img src="/img/' + item.poster + '" class="img-responsive">' +
				'</div>' +
				'<div class="col-md-8">' +
				'<div class="row">' +
					'<div class="col-xs-8 seriesName">' +
						item.seriesName +
					'</div>' +
					'<div class="col-xs-4 requestButton">' +
						'<button class="btn btn-primary">Request</button>' +
					'</div>' +
				'</div>' +
				'<div class="row seriesStats">' +
					'<div class="col-xs-4 firstAired">' +
						item.firstAired.substring(0,4) +
					'</div>' +
					'<div class="col-xs-4 network">' +
						item.network +
					'</div>' +
					'<div class="col-xs-4 status">' +
						item.status +
					'</div>' +
				'</div>' +
				'<div class="row">' +
					nl2br(item.overview) +
				'</div>' +
			'</div>' +
		'</div>' +
		'<hr>');
}

</script>
