# Class: [\Md](../namespaces/md.md)[\Db](../namespaces/md-db.md)[\Connection](../namespaces/md-db-connection.md)\MySQLiConnection


---

### Properties
* protected $[dbname](#property_dbname)
* protected $[dsn](#property_dsn)
* protected $[dsn_s](#property_dsn_s)
* protected $[host](#property_host)
* protected $[pass](#property_pass)
* protected $[port](#property_port)
* protected $[user](#property_user)

---

### Methods

* public [__construct()](#method___construct)
* public [fromConnection()](#method_fromConnection)
* public [getDb()](#method_getDb)
* public [getHost()](#method_getHost)
* public [getName()](#method_getName)
* public [getPort()](#method_getPort)
* public [getServer()](#method_getServer)
* public [getUser()](#method_getUser)
* public [withDbName()](#method_withDbName)

---

### Details

* File: [src/Connection/MySQLiConnection.php](../src/Connection/MySQLiConnection.php)

---

## Properties
<a id="property_dbname"></a>
#### protected $dbname : string
---
**Type:** string
database name
**Details:**
* Inherited From: [\Md\Db\Connection\Connection](classes/Md-Db-Connection-Connection.md)


<a id="property_dsn"></a>
#### protected $dsn : string
---
**Type:** string
data source name
**Details:**
* Inherited From: [\Md\Db\Connection\Connection](classes/Md-Db-Connection-Connection.md)


<a id="property_dsn_s"></a>
#### protected $dsn_s : string
---
**Type:** string
data source name
**Details:**
* Inherited From: [\Md\Db\Connection\Connection](classes/Md-Db-Connection-Connection.md)


<a id="property_host"></a>
#### protected $host : string
---
**Type:** string
host name
**Details:**
* Inherited From: [\Md\Db\Connection\Connection](classes/Md-Db-Connection-Connection.md)


<a id="property_pass"></a>
#### protected $pass : string
---
**Type:** string
password
**Details:**
* Inherited From: [\Md\Db\Connection\Connection](classes/Md-Db-Connection-Connection.md)


<a id="property_port"></a>
#### protected $port : int
---
**Type:** int
port number
**Details:**
* Inherited From: [\Md\Db\Connection\Connection](classes/Md-Db-Connection-Connection.md)


<a id="property_user"></a>
#### protected $user : string
---
**Type:** string
user name
**Details:**
* Inherited From: [\Md\Db\Connection\Connection](classes/Md-Db-Connection-Connection.md)



---

## Methods

<a id="method___construct"></a>
### __construct

```
public __construct(string  dbname, string  host, string  user, string  pass, int  port = 3306) : mixed
```

##### Summary

Connection constructor.

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$dbname** | string |  |
| **$host** | string |  |
| **$user** | string |  |
| **$pass** | string |  |
| **$port** | int | 3306 |

##### Returns:

```
mixed
```

---

<a id="method_fromConnection"></a>
### fromConnection

```
static public fromConnection(\Md\Db\Connection\Connection  c) : void
```

##### Summary

Create (child) Connection object from a Connection object

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$c** | \Md\Db\Connection\Connection |  |

##### Returns:

```
void
```

---

<a id="method_getDb"></a>
### getDb

```
public getDb() : \stdClass
```

##### Summary

Get an object connected to the database

##### Returns:

```
\stdClass
```

---

<a id="method_getHost"></a>
### getHost

```
public getHost() : string
```

##### Summary

Get host name

##### Returns:

```
string
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

<a id="method_getPort"></a>
### getPort

```
public getPort() : int
```

##### Summary

Get Port number

##### Returns:

```
int
```

---

<a id="method_getServer"></a>
### getServer

```
public getServer() : \stdClass
```

##### Summary

Get an object connected to the server (without database)

##### Returns:

```
\stdClass
```

---

<a id="method_getUser"></a>
### getUser

```
public getUser() : string
```

##### Summary

Get User name

##### Returns:

```
string
```
user name

---

<a id="method_withDbName"></a>
### withDbName

```
public withDbName(string  dbname) : \Md\Db\Connection\Connection
```

##### Summary

Returns a new Connection object with same settings
except a different database

##### Parameters:

| Name | Type | Default |
|------|------|---------|
| **$dbname** | string |  |

##### Returns:

```
\Md\Db\Connection\Connection
```
