# Class: [\Md](../namespaces/md.md)[\Db](../namespaces/md-db.md)\Db

## Summary:

Class Db
Database functions utilities


---

### Properties
* private $[c](#property_c)
* private $[dieOnError](#property_dieOnError)
* private $[pdo](#property_pdo)
* private $[sqlTables](#property_sqlTables)

---

### Methods

* public [__construct()](#method___construct)
* public [getName()](#method_getName)
* public [reset()](#method_reset)
* public [setDieOnError()](#method_setDieOnError)
* private [catchPdoException()](#method_catchPdoException)
* private [connect()](#method_connect)
* private [dropTable()](#method_dropTable)
* private [dropTables()](#method_dropTables)
* private [setSqlTables()](#method_setSqlTables)

---

### Details

* File: [src/Db.php](../src/Db.php)

---

## Properties
<a id="property_c"></a>
#### private $c : \Md\Db\Connection\PDOConnection
---
**Type:** \Md\Db\Connection\PDOConnection

**Details:**


<a id="property_dieOnError"></a>
#### private $dieOnError : bool
---
**Type:** bool

**Details:**


<a id="property_pdo"></a>
#### private $pdo : \PDO
---
**Type:** \PDO

**Details:**


<a id="property_sqlTables"></a>
#### private $sqlTables : array
---
**Type:** array

**Details:**



---

## Methods

<a id="method___construct"></a>
### __construct

```
public __construct(\Md\Db\Connection\Connection  c, bool  dieOnError = true) : mixed
```

##### Summary

Db constructor.

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$c** | \Md\Db\Connection\Connection |  |
| **$dieOnError** | bool | true |

##### Returns:

```
mixed
```

---

<a id="method_getName"></a>
### getName

```
public getName() : string
```

##### Summary

Get database name

##### Returns:

```
string
```

---

<a id="method_reset"></a>
### reset

```
public reset() : \Md\Db\Db
```

##### Returns:

```
\Md\Db\Db
```

---

<a id="method_setDieOnError"></a>
### setDieOnError

```
public setDieOnError(mixed  dieOnError) : \Md\Db\Db
```

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$dieOnError** | mixed |  |

##### Returns:

```
\Md\Db\Db
```

---

<a id="method_catchPdoException"></a>
### catchPdoException

```
private catchPdoException(callable  callback, array  args = []) : mixed
```

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$callback** | callable |  |
| **$args** | array | [] |

##### Returns:

```
mixed
```

---

<a id="method_connect"></a>
### connect

```
private connect() : \Md\Db\Db
```

##### Returns:

```
\Md\Db\Db
```

---

<a id="method_dropTable"></a>
### dropTable

```
private dropTable(string  sqlTable) : \Md\Db\Db
```

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$sqlTable** | string |  |

##### Returns:

```
\Md\Db\Db
```

---

<a id="method_dropTables"></a>
### dropTables

```
private dropTables() : \Md\Db\Db
```

##### Returns:

```
\Md\Db\Db
```

---

<a id="method_setSqlTables"></a>
### setSqlTables

```
private setSqlTables() : \Md\Db\Db
```

##### Returns:

```
\Md\Db\Db
```
