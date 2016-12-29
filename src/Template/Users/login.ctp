<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Login</h3>
	</div>
	<div class="panel-body">
		<?= $this->Form->create() ?>
		<div class="form-group">
			<?= $this->Form->input('username', [
				'label' => 'Plex Username',
				'class' => 'form-control'
			]) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->input('password', [
				'label' => 'Plex Password',
				'type' => 'password',
				'class' => 'form-control',
			])?>
		</div>
			<?= $this->Form->button('Submit', [
				'class' => 'btn btn-primary'
			]) ?>

		<?= $this->Form->end() ?>
	</div>
</div>