<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Requests Issue'), ['action' => 'edit', $requestsIssue->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Requests Issue'), ['action' => 'delete', $requestsIssue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requestsIssue->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Requests Issues'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Requests Issue'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Requests'), ['controller' => 'Requests', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Request'), ['controller' => 'Requests', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Issues'), ['controller' => 'Issues', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Issue'), ['controller' => 'Issues', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="requestsIssues view large-9 medium-8 columns content">
    <h3><?= h($requestsIssue->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Request') ?></th>
            <td><?= $requestsIssue->has('request') ? $this->Html->link($requestsIssue->request->id, ['controller' => 'Requests', 'action' => 'view', $requestsIssue->request->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Issue') ?></th>
            <td><?= $requestsIssue->has('issue') ? $this->Html->link($requestsIssue->issue->name, ['controller' => 'Issues', 'action' => 'view', $requestsIssue->issue->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($requestsIssue->id) ?></td>
        </tr>
    </table>
</div>
