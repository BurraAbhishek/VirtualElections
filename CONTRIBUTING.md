# HOW TO CONTRIBUTE

Welcome, and thank you for your interest in contributing to this repository!

There are many ways in which you can contribute, beyond writing code. The goal of this document is to provide an overview of how you can get involved.

## Reporting issues

Have you identified any reproducible issue? Want a feature request? Here's how you can make reporting your issue as effective as possible:

Before you create a new issue, please search in [open issues](https://github.com/BurraAbhishek/VirtualElections/issues) to see if the issues or feature request is already filed.

## Coding conventions used in this repository

Start reading the [source code](https://github.com/BurraAbhishek/VirtualElections/tree/main/src) and you'll get the hang of it. In addition to that,
* PHP Data Objects (PDO) is used to access the SQL databases throughout this application. PDO was chosen over MySQLi because PDO supports many different database drivers. In contrast, MySQLi supports only MySQL.
* Each PHP with access to the database has a pre-defined connection class and table lists. (See below)
* Before any changes are official, SQL Injection tests and cross-site scripting tests are performed. Please test your changes before sending a pull request.
* This is an open-source software. Consider the people who will read your code, and make it look nice for them.

## Using a PHP connection or a table

The connection class is available in [/src/db/dbconfig.php](https://github.com/BurraAbhishek/VirtualElections/blob/main/src/db/dbconfig.php). You should include this file before using the connection class. The following examples show how to initiate a database connection: (the variables used may differ from case to case)

```
$connection_class = new Connection();
$connection = $connection_class->openConnection();
```

The following code snippet closes this connection:

```
$connection_class->closeConnection();
```

The table class is available in [/src/db/tablesconfig.php](https://github.com/BurraAbhishek/VirtualElections/blob/main/src/db/tablesconfig.php). You should include this file before using the table class. The following examples show how to initiate a table in the database: (the variables used may differ from case to case)

```
$table_class = new Table();
$admin = $table_class->getAdminStatus();
$parties = $table_class->getPartyList();
$voter = $table_class->getVoterList();
$election = $table_class->getVotes();
```

For example, the prepared statement to select all entries from the parties table may look like this:

```
$connection->prepare("SELECT * FROM $parties");
```

Using prepared statements wherever possible helps in preventing SQL Injection attacks.

## Contributing to this app

The recommended method: Fork this repository and send a pull request.
