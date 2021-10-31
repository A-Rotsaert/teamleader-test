<?php

declare(strict_types=1);

namespace App\Repository;

use App\Interface\ConfigInterface;
use App\Interface\RepositoryInterface;
use Dotenv\Exception\InvalidFileException;

/**
 * JsonRepositoryService
 *
 * @author <andy.rotsaert@live.be>
 */
final class JsonRepository implements RepositoryInterface
{
    /**
     * @var array
     */
    private array $config;

    /**
     * @var string
     */
    private string $type;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config->get('config', 'data');
    }

    /**
     * @param string $type
     * @return RepositoryInterface
     */
    public function getManager(string $type): RepositoryInterface
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Find a row by id
     *
     * @param int|string $id
     * @return array|bool
     */
    public function find(int|string $id): array|bool
    {
        $data = $this->get();
        $itemIds = array_column(array_values($data), 'id');
        $rowId = array_search($id, $itemIds, true);

        return ($rowId !== false) ? $data[$rowId] : $rowId;
    }

    /**
     * Returns all records in the repository
     *
     * @return array
     */
    public function get(): array
    {
        return $this->parseJson();
    }

    /**
     * @return array
     */
    private function parseJson(): array
    {
        if (!$json = file_get_contents($this->getJsonFile())) {
            throw new InvalidFileException("Repository file {$this->getJsonFile()} does not exist.");
        }

        return json_decode($json, true);
    }

    /**
     * @return string
     */
    private function getJsonFile(): string
    {
        if (!key_exists($this->type, $this->config)) {
            throw new \InvalidArgumentException("Requested repository {$this->type} not found in config/config.yaml.");
        }

        return ROOT_PATH . $this->config[$this->type];
    }

    /**
     * Find one or more records that match the criteria
     *
     * @param array $criteria
     * @return array
     */
    public function findBy(array $criteria): array
    {
        $data = $this->get();
        $result = [];

        foreach ($data as $value) {
            foreach ($criteria as $criteriaKey => $criteriaValue) {
                if (!isset($value[$criteriaKey]) || $value[$criteriaKey] != $criteriaValue) {
                    continue 2;
                }
            }
            $result[] = $value;
        }

        return $result;
    }
}
