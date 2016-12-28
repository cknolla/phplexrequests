<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Data Usage</h3>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover">
			<tr>
				<th>Data Used</th>
				<td id="dataUsed">100 GiB of 1024 GiB</td>
			</tr>
			<tr>
				<th>% Data Used</th>
				<td id="percentDataUsed">56.2%</td>
			</tr>
			<tr>
				<th>% Month Complete</th>
				<td id="percentMonthComplete">72.6%</td>
			</tr>
			<tr>
				<th>Ratio</th>
				<td id="ratio">1.15</td>
			</tr>
		</table>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">News</h3>
	</div>
	<div class="panel-body">
		<?php foreach($newsStories as $news): ?>
		<P class="news-subject"><?= $news->subject ?></P>
		<P class="news-body">
			<?= $news->body ?>
		</P>
		<hr>
		<?php endforeach; ?>
	</div>
</div>