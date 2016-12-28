
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
			echo $this->Form->button('Submit', [
				'id' => 'submit-button',
			]);
			?>
	</div>

	<div id="searchResults">
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
	</div>
</div>

<script>

$("#submit-button").click(function() {
	$("#searchResults").empty();
});

</script>
