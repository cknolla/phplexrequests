
<div class="requests index large-9 medium-8 columns content">
    <h2><?= __('Requests') ?></h2>

    <?php foreach($requests as $request): ?>
		<div class="row request">
			<div class="col-md-4">
				<img src="<?=$requestDetail[$request->id]->Poster?>" class="img-responsive">
			</div>
			<div class="col-md-4">
				<div class="row requestTitle">
					<?=$requestDetail[$request->id]->Title ?>
				</div>
				<div class="row">
					Released: <?= $requestDetail[$request->id]->Released ?>
				</div>
				<div class="row">
					Approved: <?= $request->approved ? 'Yes' : 'No' ?>
				</div>
				<!--
				<div class="row">
					Available: <?= $request->available ? 'Yes' : 'No' ?>
				</div>
				-->
				<div class="row">
					Requested: <?= $request->created ?>
				</div>
				<div class="row">
					Requested By: <?= $request->user->username ?>
				</div>
			</div>
			<div class="col-md-4">
				<?php if($user['id'] == 1): ?>
				<div class="row">
					<button class="approve btn btn-success <?= $request->approved ? 'invisible' : ''?>" value="<?=$request->db_id?>">Approve</button>
				</div>
				<?php endif; ?>

			</div>
		</div>
		<hr>
	<?php endforeach; ?>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>

<script>
	$(function() {
		$(".approve").click(function() {
			approve($(this).val());
		})
	});

	function approve(id)
	{
		$.ajax({
				type: 'POST',
			url: '<?php echo $this->Url->build([
				'controller' => 'Requests',
				'action' => 'approve-movie',
			]);?>',
			dataType: 'json',
			data: {
				imdbId: id
			},
			success: function (response) {
				if (response) {
					if(response.approved != "yes") {
						showAlert('error',"Error in approval process");
					} else {
						showAlert('success',"The request is approved and will be downloaded immediately if available.");
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

	};

</script>
