<?php

declare(strict_types=1);

namespace ToDo\Shared\Infrastructure\Repository\Elasticsearch;

use Elasticsearch\Common\Exceptions\Missing404Exception;
use Php\Support\Helpers\Arr;
use ToDo\Shared\Domain\Criteria\Criteria;
use ToDo\Shared\Infrastructure\Elasticsearch\ElasticsearchClient;

abstract class ElasticsearchRepository
{
    public function __construct(private readonly ElasticsearchClient $client)
    {
    }

    abstract protected function aggregateName(): string;

    protected function persist(string $id, array $plainBody): void
    {
        $this->client->persist($this->aggregateName(), $id, $plainBody);
    }

    protected function searchAllInElastic(): array
    {
        return $this->searchRawElasticsearchQuery([]);
    }

    protected function searchRawElasticsearchQuery(array $params): array
    {
        try {
            $result = $this->client->client()->search(array_merge(['index' => $this->indexName()], $params));

            $hits = Arr::get($result, 'hits.hits', []);
            return mapValue($this->elasticValuesExtractor(), $hits);
        } catch (Missing404Exception) {
            return [];
        }
    }

    public function searchByCriteria(Criteria $criteria): array
    {
        $converter = new ElasticsearchCriteriaConverter();

        $query = $converter->convert($criteria);

        return $this->searchRawElasticsearchQuery($query);
    }

    protected function indexName(): string
    {
        return sprintf('%s_%s', $this->client->indexPrefix(), $this->aggregateName());
    }

    private function elasticValuesExtractor(): callable
    {
        return static fn(array $elasticValues): array => $elasticValues['_source'];
    }
}
