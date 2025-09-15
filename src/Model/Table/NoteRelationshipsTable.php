<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NoteRelationships Model
 *
 * @method \App\Model\Entity\NoteRelationship newEmptyEntity()
 * @method \App\Model\Entity\NoteRelationship newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\NoteRelationship> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NoteRelationship get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\NoteRelationship findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\NoteRelationship patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\NoteRelationship> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\NoteRelationship|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\NoteRelationship saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\NoteRelationship>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\NoteRelationship>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\NoteRelationship>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\NoteRelationship> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\NoteRelationship>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\NoteRelationship>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\NoteRelationship>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\NoteRelationship> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NoteRelationshipsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('note_relationships');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Parents', [
            'className' => 'Notes',
            'foreignKey' => 'note_a',
            'bindingKey' => 'id',
            'property_name' => 'parent',
        ]);
        $this->belongsTo('Children', [
            'className' => 'Notes',
            'foreignKey' => 'note_b',
            'bindingKey' => 'id',
            'propertyName' => 'child',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->uuid('note_a')
            ->requirePresence('note_a', 'create')
            ->notEmptyString('note_a')
            ->notSameAs('note_a', 'note_b', 'The parent note must not be the same as the child note');

        $validator
            ->uuid('note_b')
            ->requirePresence('note_b', 'create')
            ->notEmptyString('note_b')
            ->notSameAs('note_b', 'note_a', 'The child note must not be the same as the parent note');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['note_a', 'note_b'], 'Relationship already exists'));
        return $rules;
    }

    public function findByUserId(SelectQuery $query, string $userId): SelectQuery
    {
        return $query->matching('Parents', fn(SelectQuery $query) => $query->find('byUserId', $userId));
    }
}
