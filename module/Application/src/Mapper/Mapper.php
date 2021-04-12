<?php


namespace Application\Mapper;


use Exception;
use Laminas\Config\Config;
use MongoDB\BSON\ObjectId;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;

class Mapper
{
    private $error = false;
    private $messages = [];
    private $requestParams = [];

    /**
     * @return array
     */
    public function getRequestParams(): array
    {
        return $this->requestParams;
    }

    /**
     * @param array $requestParams
     */
    public function setRequestParams(array $requestParams): void
    {
        $this->requestParams = $requestParams;
    }

    public function validator($fields, $data): bool
    {
        $messages = [];
        foreach ($fields as $key => $field) {
            if (!isset($data[$key])) {
                $this->messages[$key][] = "$key is missing!";
                $this->setError(true);
            } else {
                $this->validatorByField($key, $data[$key], $field["type"]);
            }
        }
        return $this->isError();
    }

    private function validatorByField($fieldName, $fieldValue, $type): void
    {
        $types = preg_split('/\|/', $type);

        foreach ($types as $typeOfValidation) {
            switch ($typeOfValidation) {
                case "url" :
                    if (!preg_match("/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/", $fieldValue)) {
                        $this->messages[$fieldName] = "$fieldValue no is not a valid url";
                        $this->setError(true);
                    }
                    break;
                case "base64":
                    if (!base64_encode(base64_decode($fieldValue, true)) === $fieldValue) {
                        $this->setError(true);
                        $this->messages[$fieldName] = "$fieldValue is not valid";
                    }
                    break;
                case "string":
                    if (!is_string($fieldValue)) {
                        $this->messages[$fieldName][] = "$fieldName should be string type";
                        $this->setError(true);
                    }
                    if (empty($fieldValue)) {
                        $this->messages[$fieldName][] = "$fieldName can't be empty";
                        $this->setError(true);
                    }
                    break;
                case "integer" | "int":
                    if (!is_integer($fieldValue)) {
                        $this->messages[$fieldName][] = "$fieldName should be integer type";
                        $this->setError(true);
                    }
                    break;
                case "boolean":
                    if (!is_bool($fieldValue)) {
                        $this->messages[$fieldName][] = "$fieldName should be boolean type";
                        $this->setError(true);
                    }
                    break;
                case "arrayOfInt":
                    if (!is_array($fieldValue)) {
                        $this->messages[$fieldName][] = "$fieldName should be array type";
                        $this->setError(true);
                    } else {
                        foreach ($fieldValue as $key => $itemOnArray) {
                            if (!is_int($itemOnArray)) {
                                $this->messages[$fieldName][] = "The index $key on the array $fieldName should be integer type";
                                $this->setError(true);
                            }
                        }
                    }
                    break;
                case "arrayOfString":
                    if (!is_array($fieldValue)) {
                        $this->messages[$fieldName][] = "$fieldName should be array type";
                        $this->setError(true);
                    } else {
                        foreach ($fieldValue as $key => $itemOnArray) {
                            if (!is_string($itemOnArray)) {
                                $this->messages[$fieldName][] = "The index $key on the array $fieldName should be string type";
                                $this->setError(true);
                            }
                        }
                    }
                    break;
                default:

                    if (is_array($fieldValue)) {
                        foreach ($fieldValue as $key => $value) {
                            $dataExists = $this->complexTypeValidation($fieldName, $value);
                            if (!$dataExists) {
                                $this->messages[$fieldName][] = "The id: $value is not a valid $fieldName object or non exists into mongo db";
                                $this->setError(true);
                            }
                        }
                    } else {
                        $dataExists = $this->complexTypeValidation($fieldName, $fieldValue);
                        if (!$dataExists) {
                            $this->messages[$fieldName][] = "The id: $fieldValue is not a valid $fieldName object or non exists into the db";
                            $this->setError(true);
                        }
                    }

            }
        }
    }

    private function complexTypeValidation($fieldName, $id)
    {
        $configuration = new Config(include __DIR__ . "/../../../../config/autoload/mongo.local.php");
        $connection = $configuration->doctrine->connection->odm_default;
        $user = $connection->user;
        $password = $connection->password ?? "";
        $server = $connection->server;
        $port = $connection->port;
        $db = $configuration->doctrine->configuration->odm_default->default_db;
        if ((!is_null($user)) && (!is_null($password))) {
            $connectionParams = "mongodb://" . $user . ":" . $password . "@" . $server . ":" . $port."";
        } else {
            $connectionParams = "mongodb://" . $server . ":" . $port;
        }

        try {
            $manager = new Manager($connectionParams);
            $filter = ['_id' => new ObjectId($id)];
            $options = [];

            $query = new Query($filter, $options);
            $collection = ucfirst($fieldName) . "Document";
            $dbSelector = $db . "." . $collection;

            $exists = !empty($manager->executeQuery($dbSelector, $query)->toArray());
            return $exists;
        } catch (Exception $exception) {

            $this->messages[$fieldName][] = "This id: $id is not valid";
            $this->setError(true);
            return false;
        }
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @param bool $error
     */
    public function setError(bool $error): void
    {
        $this->error = $error;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param array $messages
     */
    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }

}