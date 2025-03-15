# Class: [\Md](../namespaces/md.md)[\Db](../namespaces/md-db.md)\DbServer


---

### Constants
* public [DEFAULT_MYSQL_TO_MARIADB_REPLACEMENTS](#constant_DEFAULT_MYSQL_TO_MARIADB_REPLACEMENTS)

---

### Properties
* private $[_pdo](#property__pdo)
* private $[c](#property_c)

---

### Methods

* public [__construct()](#method___construct)
* public [createDatabase()](#method_createDatabase)
* public [createDatabaseWithUser()](#method_createDatabaseWithUser)
* public [createSecondRoot()](#method_createSecondRoot)
* public [createUser()](#method_createUser)
* public [createUserForDatabase()](#method_createUserForDatabase)
* public [dropDatabase()](#method_dropDatabase)
* public [dropUser()](#method_dropUser)
* public [importSql()](#method_importSql)
* private [doImport()](#method_doImport)

---

### Details

* File: [src/DbServer.php](../src/DbServer.php)

---

## Constants
<a id="constant_DEFAULT_MYSQL_TO_MARIADB_REPLACEMENTS"></a>
###### DEFAULT_MYSQL_TO_MARIADB_REPLACEMENTS
```
DEFAULT_MYSQL_TO_MARIADB_REPLACEMENTS = ['utf8mb4_unicode_520_ci' => ["utf8mb4_0900_ai_ci", "utf8mb4_uca1400_ai_ci"]]
```

| attributes |  |  |


---

## Properties
<a id="property__pdo"></a>
#### private $_pdo : \PDO
---
**Type:** \PDO
pdo object
**Details:**


<a id="property_c"></a>
#### private $c : \Md\Db\Connection\Connection
---
**Summary**

Connection object

**Type:** \Md\Db\Connection\Connection

**Details:**



---

## Methods

<a id="method___construct"></a>
### __construct

```
public __construct(\Md\Db\Connection\Connection  c) : mixed
```

##### Summary

Connection object

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$c** | \Md\Db\Connection\Connection |  |

##### Returns:

```
mixed
```

---

<a id="method_createDatabase"></a>
### createDatabase

```
public createDatabase(string  dbname, bool  dropIfExists = false, string  charset = &#039;utf8mb4&#039;, string  collation = &#039;utf8mb4_unicode_520_ci&#039;) : \Md\Db\Db
```

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$dbname** | string |  |
| **$dropIfExists** | bool | false |
| **$charset** | string | &#039;utf8mb4&#039; |
| **$collation** | string | &#039;utf8mb4_unicode_520_ci&#039; |

##### Returns:

```
\Md\Db\Db
```

---

<a id="method_createDatabaseWithUser"></a>
### createDatabaseWithUser

```
public createDatabaseWithUser(string  newDb, string  newUser = &#039;&#039;, string  newPass = &#039;&#039;, string  charSet = &#039;utf8mb4&#039;, string  charCollation = &#039;utf8mb4_unicode_520_ci&#039;) : \Md\Db\Db
```

##### Summary

Create a database on a server

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$newDb** | string |  |
| **$newUser** | string | &#039;&#039; |
| **$newPass** | string | &#039;&#039; |
| **$charSet** | string | &#039;utf8mb4&#039; |
| **$charCollation** | string | &#039;utf8mb4_unicode_520_ci&#039; |

##### Returns:

```
\Md\Db\Db
```

---

<a id="method_createSecondRoot"></a>
### createSecondRoot

```
public createSecondRoot(string  secondRoot, string  secondRootPass) : void
```

##### Summary

Create a second root

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$secondRoot** | string |  |
| **$secondRootPass** | string |  |

##### Returns:

```
void
```

---

<a id="method_createUser"></a>
### createUser

```
public createUser(string  newUser, string  newPass, bool  dropIfExists = false, array  hosts = [&#039;localhost&#039;, &#039;%&#039;], array  databases = []) : $this
```

##### Summary

Create User for the current database

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$newUser** | string |  |
| **$newPass** | string |  |
| **$dropIfExists** | bool | false |
| **$hosts** | array | [&#039;localhost&#039;, &#039;%&#039;] |
| **$databases** | array | [] |

##### Returns:

```
$this
```

---

<a id="method_createUserForDatabase"></a>
### createUserForDatabase

```
public createUserForDatabase(string  dbname, string  newUser, string  newPass) : mixed
```

##### Summary

Create user for database

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$dbname** | string |  |
| **$newUser** | string |  |
| **$newPass** | string |  |

##### Returns:

```
mixed
```

---

<a id="method_dropDatabase"></a>
### dropDatabase

```
public dropDatabase(string  dbname, bool  ifExists = true) : void
```

##### Summary

Drop a database

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$dbname** | string |  |
| **$ifExists** | bool | true |

##### Returns:

```
void
```

---

<a id="method_dropUser"></a>
### dropUser

```
public dropUser(string  user, array  hosts = [&#039;localhost&#039;, &#039;%&#039;], bool  ifExists = true) : void
```

##### Summary

Drop User for the current server

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$user** | string |  |
| **$hosts** | array | [&#039;localhost&#039;, &#039;%&#039;] |
| **$ifExists** | bool | true |

##### Returns:

```
void
```

---

<a id="method_importSql"></a>
### importSql

```
static public importSql(\Md\Db\DbServer  server, \Md\Db\Db|null  db, mixed  sqlFile = __DIR__ . &quot;/file.sql&quot;, mixed  replacements = self::DEFAULT_MYSQL_TO_MARIADB_REPLACEMENTS) : mixed
```

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$server** | \Md\Db\DbServer |  |
| **$db** | \Md\Db\Db|null |  |
| **$sqlFile** | mixed | __DIR__ . &quot;/file.sql&quot; |
| **$replacements** | mixed | self::DEFAULT_MYSQL_TO_MARIADB_REPLACEMENTS |

##### Returns:

```
mixed
```

---

<a id="method_doImport"></a>
### doImport

```
static private doImport(\mysqli  mysqli, string  sqlFile, array  replacements) : mixed
```

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$mysqli** | \mysqli |  |
| **$sqlFile** | string |  |
| **$replacements** | array |  |

##### Returns:

```
mixed
```
