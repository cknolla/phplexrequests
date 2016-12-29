<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Login</h3>
	</div>
	<div class="panel-body">
		<?= $this->Form->create() ?>
		<?= $this->Form->input('username') ?>
		<?= $this->Form->input('password', [
			'type' => 'password'
		])?>
		<?= $this->Form->button('Submit', [
			'class' => 'btn btn-primary'
		]) ?>
		<?= $this->Form->end() ?>
		<button onclick="showAlert()">Alert</button>
	</div>
</div>