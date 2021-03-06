<?php

namespace App\Models;

use App\Classes\DB;

/**
 * Class Model
 * @package App\Models
 */
abstract class Model
{
	/**
	 * @var string $table имя таблицы
	 */
	protected static $table;
	/**
	 * @var string $primaryKey имя первичного ключа
	 */
	protected static $primaryKey = 'id';
	/**
	 * @var array $schema схема модели
	 * [
	 *   'name' => string, //название поля в БД
	 *   'type' => string //int|string|float|bool тип поля
	 *   'nullable' => bool (true) //может ли быть null
	 * ][]
	 */
	protected static $schema = [];
	/**
	 * @var array $attributes элементы экземпляра //['название поля' => 'значение']
	 */
	protected $attributes = [];

	public function __construct($attributes)
	{
		$attributes = (array)$attributes;
		foreach (static::$schema as $field) {
			$name = $field['name'];
			$fieldValue = $attributes[$name] ?? null;
			if (
				!is_null($fieldValue)
				|| empty($field['nullable'])
			) {
				switch ($field['type']) {
					case 'int':
					case 'bool':
						$fieldValue = (int)$fieldValue;
						break;
					case 'float':
						$fieldValue = (float)$fieldValue;
						break;
					case 'string':
						$fieldValue = (string)$fieldValue;
						break;
				}
			}
			$this->attributes[$name] = $fieldValue;
		}
	}

	public function __get($key)
	{
		return $this->attributes[$key] ?? null;
	}

	public function __set($key, $value)
	{
		$this->attributes[$key] = $value;
	}

	//вот чего не хватало twig
	public function __isset($name)
	{
		return isset($this->attributes[$name]);
	}

	/**
	 * Генерирует SQL запрос
	 * @param array|null $select //каждый элемент или строка colName или ключ - colName, значение - alias
	 * @param array|null $filters //каждый элемент имеет вид ['col' => 'id', 'oper' => '=', 'value' => '1']
	 * @param array|null $orders //каждый элемент имеет вид ['col' => 'id', 'direction' => 'asc']
	 * @param int|null $limitCount //количество элементов выдаче
	 * @param int|null $limitOffset //с какого элемента начинать выдачу
	 * @return string SQL запрос
	 */
	public static function queryBuilder(
		?array $select = [],
		?array $filters = [],
		?array $orders = [],
		?int $limitCount = null,
		?int $limitOffset = null
	): string
	{
		$table = static::$table;
		$sql = "SELECT ";
		if (empty($select)) {
			$select = ['*'];
		}
		//Добавим запрос только необходимые столбцы
		$queries = [];
		foreach ($select as $key => $value) {
			if (is_int($key)) {
				$queries[] = $value;
			} else {
				//Если запрос выглядит как [col => alias] то создаем запрос `col as alias`
				$queries[] = "$key as '$value'";
			}
		}
		$sql .= implode(', ', $queries);
		$sql .= " FROM $table ";
		//Выборка (WHERE)
		if (!empty($filters)) {
			$queries = [];
			//Проходимся по всем фильтрам
			foreach ($filters as $filter) {
				//Перебираем оператор
				switch ($filter['oper']) {
					case 'IS NULL':
					case 'IS NOT NULL':
						//Для работы с NULL $value не нужно
						$queries[] = "{$filter['col']} {$filter['oper']}";
						break;
					case 'IN':
					case 'NOT IN':
						//Для работы с IN $value должно иметь вид (1,2,3)
						$value = $filter['value'];
						if (is_array($value)) {
							$value = '(' . implode(', ', $value) . ')';
						}
						$queries[] = "{$filter['col']} {$filter['oper']} {$value}";
						break;
					default:
						//В остальных случаях без обработки
						$queries[] = "{$filter['col']} {$filter['oper']} '{$filter['value']}'";
						break;
				};
			}
			//Добавляем выборку в запрос
			$sql .= " WHERE " . implode(' AND ', $queries);
		}
		//Сортировка (ORDER BY)
		if (!empty($orders)) {
			$queries = [];
			foreach ($orders as $order) {
				//Делаем возможность использовать только ASC и DESC
				$direction = strtolower($order['direction']) == 'asc' ? 'asc' : 'desc';
				$queries[] = "{$order['col']} $direction";
			}
			$sql .= " ORDER BY " . implode(', ', $queries);
		}
		//Ограничение (LIMIT)
		if (!empty($limitCount)) {
			$sql .= " LIMIT ";
			if (empty($limitOffset)) {
				//Если отступ не задан, делаем только ограничение
				$sql .= " $limitCount";
			} else {
				//Если отступ есть, то ограничиваем с отступом
				$sql .= " $limitOffset, $limitCount";
			}
		}
		return $sql;
	}

	/**
	 * Получает коллекцию моделей
	 * @param array|null $filters
	 * @param array|null $orders
	 * @param int|null $limitCount
	 * @param int|null $limitOffset
	 * @return static[]
	 */
	public static function get(
		?array $filters = [],
		?array $orders = [],
		?int $limitCount = null,
		?int $limitOffset = null
	): array
	{
		//Собираем запрос
		$sql = static::queryBuilder(['*'], $filters, $orders, $limitCount, $limitOffset);
		//Выполняем запрос
		$result = DB::getInstance()->fetchAll($sql);
		//Создаем коллекцию
		foreach ($result as &$row) {
			$row = new static($row);
		}
		return $result;
	}

	/**
	 * Возвращает первый элемент выборки
	 * @param array|null $filters
	 * @param array|null $orders
	 * @return static
	 */
	public static function getOne(?array $filters = [], ?array $orders = [])
	{
		//Ограничиваем выборку 1 элементом
		return static::get($filters, $orders, 1)[0] ?? null;
	}

	/**
	 * Возвращает элемент с соответствующим $primaryKey
	 * @param int $primaryKey
	 * @return static
	 */
	public static function getByKey(int $primaryKey)
	{
		//Делаем выборку по $primaryKey
		return static::getOne([[
			'col' => static::$primaryKey,
			'oper' => '=',
			'value' => $primaryKey
		]]);
	}

	/**
	 * @param array|null $filters
	 * @return int количество элементов в выборке
	 */
	public static function getCount(?array $filters = []): int
	{
		//Создаем запрос и получаем только COUNT
		$sql = static::queryBuilder(['COUNT(*)' => 'count'], $filters);
		return DB::getInstance()->fetchOne($sql)['count'];
	}

	/**
	 * Добавляет или изменяет элемент в БД
	 * @return Model
	 */
	public function save(): self
	{
		$table = static::$table;
		$primary = static::$primaryKey;
		//если primary задан значит Update иначе Insert
		if (!empty($this->attributes[$primary])) {
			//update
			$this->attributes['dateChange'] = date('Y-m-d H:i:s', time() + 10800);
			$sql = "UPDATE $table SET ";
			$queries = [];
			foreach (static::$schema as $field) {
				//Не даем изменить primaryKey
				if ($field['name'] === $primary) {
					continue;
				}
				$value = (string)$this->attributes[$field['name']];
				$value = is_null($this->attributes[$field['name']]) ? 'NULL' : $value;

				$queries[] = "{$field['name']} = '$value'";
			}

			$sql .= implode(', ', $queries);
			$sql .= " WHERE $primary = {$this->attributes[$primary]}";
		} else {
			//insert
			$this->attributes['dateCreate'] = date('Y-m-d H:i:s', time() + 10800);
			$this->attributes['status'] = 1;
			$sql = "INSERT INTO $table ";
			$cols = [];
			$values = [];
			foreach (static::$schema as $field) {
				if ($field['name'] === $primary) {
					continue;
				}
				$cols[] = $field['name'];
				$value = (string)$this->attributes[$field['name']];
				$values[] = is_null($this->attributes[$field['name']]) ? 'NULL' : "'$value'";
			}
			$sql .= '(' . implode(', ', $cols) . ') VALUES (' . implode(', ', $values) . ')';
		}

		DB::getInstance()->exec($sql);

		if ($this->attributes[static::$primaryKey] < 1) {
			$this->attributes[static::$primaryKey] = DB::getInstance()->lastInsertId();
		}
		return $this;
	}

	/**
	 * Удаляет один или несколько элементов из БД
	 * @param array|null $ids [int, int..]
	 * @return bool
	 */
	public function delete(array $ids = []): bool
	{
		if (static::$table !== 'baskets' && (int)($_SESSION['login']->role) === 0) {
			exit();
		}

		$table = static::$table;
		$primary = static::$primaryKey;
		$sql = "DELETE FROM $table WHERE ";

		if (count($ids) > 1) {
			$sql .= "$primary IN (" . implode(', ', $ids) . ")";
		} elseif (count($ids) === 1) {
			$sql .= "$primary = '$ids[0]'";
		} else {
			$sql .= "$primary = '{$this->attributes[$primary]}'";
		}

		return DB::getInstance()->exec($sql);
	}
}