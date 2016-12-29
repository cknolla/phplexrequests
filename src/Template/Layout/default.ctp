<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$title = "PHPlexRequests";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <?= $this->Html->charset() ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="utf-8" />
    <title>
        <?= $title ?>
    </title>
    <?= $this->Html->meta('icon') ?>


	<!-- Latest compiled and minified CSS -->
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
-->
	<?= $this->Html->css('cake.css'); ?>
	<?= $this->Html->css('bass.css'); ?>
	<?= $this->Html->css('bootstrap-slate.css'); ?>
	<!-- Optional theme -->
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
-->



    <link href="/css/default.css" rel="stylesheet">
    <?php  /**
     * Be aware that the following line will auto-import a css file based on Controller/Action name
     * */?>

    <?= $this->Html->css($this->request->params['controller'].'/'.$this->request->params['action'].'.css');?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="/js/default.js"></script>
	<?php  /**
	 * Be aware that the following line will auto-import a js file based on Controller/Action name
	 * */?>
	<?= $this->Html->script($this->request->params['controller'].'/'.$this->request->params['action'].'.js')?>
</head>
<body>
<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?= $this->Html->link('PHPlexRequests', [
				'controller' => 'Pages',
				'action' => 'home' ],
			[
				'class' => 'navbar-brand',

			])?>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li>
					<?= $this->Html->link('Search', [
						'controller' => 'Requests',
						'action' => 'add'
					])?>
				</li>
				<li>
					<?= $this->Html->link('Requests', [
						'controller' => 'Requests',
						'action' => 'index'
					])?>
				</li>
			</ul>
		</div><!--/.nav-collapse -->

	</div>

</nav>

    <?= $this->Flash->render() ?>
<div id="alerts" class="alert alert-success hideAlert">test</div>
    <div class="container clearfix">

        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
