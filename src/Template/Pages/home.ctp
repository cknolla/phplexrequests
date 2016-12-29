<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Data Usage</h3>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover">
			<tr>
				<th>Data Used</th>
				<td id="dataUsed"><?= getVariable('dataUsed')?> GiB of 1024 GiB</td>
			</tr>
			<tr>
				<th>% Data Used</th>
				<td id="percentDataUsed"><?=getVariable('dataUsedPercent')?>%</td>
			</tr>
			<tr>
				<th>% Month Complete</th>
				<td id="percentMonthComplete"><?=getVariable('monthProgressPercent')?>%</td>
			</tr>
			<tr>
				<th>Ratio</th>
				<td id="dataRatio" style="color: <?php
				if($dataRatio < 0.9) {
					echo "green";
				} else if($dataRatio < 1.0) {
					echo "yellow";
				} else {
					echo "red";
				}
			?>"><?=$dataRatio?></td>
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