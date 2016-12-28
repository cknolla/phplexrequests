<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Requests Issue'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Requests'), ['controller' => 'Requests', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Request'), ['controller' => 'Requests', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Issues'), ['controller' => 'Issues', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Issue'), ['controller' => 'Issues', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="requestsIssues index large-9 medium-8 columns content">
    <h3><?= __('Requests Issues') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('request_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('issue_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requestsIssues as $requestsIssue): ?>
            <tr>
                <td><?= $this->Number->format($requestsIssue->id) ?></td>
                <td><?= $requestsIssue->has('request') ? $this->Html->link($requestsIssue->request->id, ['controller' => 'Requests', 'action' => 'view', $requestsIssue->request->id]) : '' ?></td>
                <td><?= $requestsIssue->has('issue') ? $this->Html->link($requestsIssue->issue->name, ['controller' => 'Issues', 'action' => 'view', $requestsIssue->issue->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $requestsIssue->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $requestsIssue->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $requestsIssue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requestsIssue->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
