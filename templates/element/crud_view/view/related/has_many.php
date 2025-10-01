<?php
use Cake\Utility\Inflector;

$isFieldAllowed = fn(string $field) => in_array($field, ['body']);

$foreignKeyToAssocationName = fn(string $foreignKey) => match($foreignKey) {
    'note_a' => 'parent',
    'note_b' => 'child',
    default => throw new InvalidArgumentException($foreignKey . ' is not a valid association'),
};

if (empty($associations['manyToMany'])) {
    $associations['manyToMany'] = [];
}

if (empty($associations['oneToMany'])) {
    $associations['oneToMany'] = [];
}
$relations = array_merge($associations['oneToMany'], $associations['manyToMany']);

$i = 0;
foreach ($relations as $alias => $details) :
    $aliasSingular = Inflector::singularize($alias);
    $otherSingularVar = $details['propertyName'];
    ?>
    <div class="related">
        <h3><?= __d('crud', '{0} Notes', [$aliasSingular]); ?></h3>
        <div class="actions-wrapper mb-3">
            <?= $this->Html->link(__('Create New {0}', [$aliasSingular]), [
                '_name' => 'notes:add',
                '?' => [
                    $foreignKeyToAssocationName($details['foreignKey']) => $this->CrudView->getViewVar('primaryKeyValue'),
                    '_redirect_url' => $this->CrudView->getView()->getRequest()->getUri()->getPath(),
                ],
            ], [
                'class' => 'btn btn-secondary',
            ]) ?>
        </div>
        <?php
        if (${$viewVar}->{$details['entities']}) :
            ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <?php
                        $otherFields = array_keys(${$viewVar}->{$details['entities']}[0]->toArray());
                        if (isset($details['with'])) {
                            $index = array_search($details['with'], $otherFields);
                            unset($otherFields[$index]);
                        }

                        foreach ($otherFields as $field) {
                            if ($isFieldAllowed($field)) {
                                echo '<th>' . Inflector::humanize($field) . '</th>';
                            }
                        }
                        ?>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach (${$viewVar}->{$details['entities']} as ${$otherSingularVar}) :
                        ?>
                        <tr>
                            <?php
                            foreach ($otherFields as $field) {
                                ?>
                                <?php 
                                    if ($isFieldAllowed($field)) {
                                        echo '<td>' . $this->CrudView->process($field, ${$otherSingularVar}) . '</td>';
                                    }
                                ?>
                                <?php
                            }
                            ?>
                            <td class="actions">
                                <?= $this->Html->link(__d('crud', 'View'), ['plugin' => $details['plugin'], 'controller' => $details['controller'], 'action' => 'view', ${$otherSingularVar}[$details['primaryKey']]], ['class' => 'btn btn-secondary']); ?>
                                <?= $this->Html->link(__d('crud', 'Edit'), ['plugin' => $details['plugin'], 'controller' => $details['controller'], 'action' => 'edit', ${$otherSingularVar}[$details['primaryKey']]], ['class' => 'btn btn-secondary']); ?>
                                <?= $this->Form->postLink(
                                    __d('crud', 'Unlink'),
                                    [
                                        '_name' => 'notes:unlink-associated',
                                        'id' => $primaryKeyValue,
                                        'association' => strtolower($alias),
                                        'associatedId' => ${$otherSingularVar}[$details['primaryKey']],
                                    ],
                                    [
                                        'class' => 'btn btn-danger btn-delete',
                                        'confirm' => __d('crud', 'Are you sure you want to unlink the association?'),
                                        'name' => '_delete',
                                    ]
                                ); ?>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            <?php
        endif;
        ?>
    </div>
<?php endforeach; ?>
