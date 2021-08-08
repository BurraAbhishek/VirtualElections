# HOW TO CONTRIBUTE

Welcome, and thank you for your interest in contributing to this repository!

There are many ways in which you can contribute, beyond writing code. The goal of this document is to provide an overview of how you can get involved.

## Reporting issues

Have you identified any reproducible issue? Want a feature request? Here's how you can make reporting your issue as effective as possible:

Before you create a new issue, please search in [open issues](https://github.com/BurraAbhishek/VirtualElections/issues) to see if the issues or feature request is already filed. However, note that issues that provide little value compared to the required effort may be closed. Before creating an issue, make sure that:

1. You list the steps to reproduce the problem to show that other users may experience it as well, if the issue is not self-descriptive.
2. Search to make sure it isn't a duplicate. [The advanced search syntax](https://help.github.com/articles/searching-issues/) may come in handy.
3. It is not a trivial problem or demand unrealistic dev time to fix.

## Feature requests

**When you're ready, [make an issue ticket](https://github.com/BurraAbhishek/VirtualElections/issues/new)** and link relevant, constructive comments regarding it in your issue ticket (such as a detailed Reddit post; linking to an empty forum thread with only your own commentary adds no value). Make sure that the feature you propose:

1. Doesn't rely on mundane assumptions. Non-technical people have the tendency to measure how difficult / easy a feature is to implement based on their unreliable instincts, and such assumptions wastes everyone's time. **Point out what needs to happen**, not what you think will happen.
2. Is **unique, if you're aiming to solve a problem**. Features that can easily be replaced by easier ideas have little value and may not have to be brought up to begin with.
3. Is **clear and concise**. If ambiguities exist, define them or propose options.

## Coding conventions used in this repository

Start reading the [source code](https://github.com/BurraAbhishek/VirtualElections/tree/main/src) and you'll get the hang of it. In addition to that,
* PHP Data Objects (PDO) is used to access the SQL databases throughout this application. PDO was chosen over MySQLi because PDO supports many different database drivers. In contrast, MySQLi supports only MySQL.
* Each PHP with access to the database has a pre-defined connection class and table lists. (See below)
* Before any changes are official, penetration tests will be performed. Please test your changes before sending a pull request. For example, if you are using [OWASP ZAP](https://www.zaproxy.org) to test your changes, there should be no red flags at all. If there are red flags, please fix them before sending a pull request.
* This is an open-source software. Consider the people who will read your code, and make it look nice for them.

## Using a PHP connection or a table

The connection class is available in [/src/db/config/dbconfig.php](https://github.com/BurraAbhishek/VirtualElections/blob/main/src/db/config/dbconfig.php). You should include this file before using the connection class. The following examples show how to initiate a database connection: (the variables used may differ from case to case)

```
$connection_class = new Connection();
$connection = $connection_class->openConnection();
```

The following code snippet closes this connection:

```
$connection_class->closeConnection();
```

The table class is available in [/src/db/config/tablesconfig.php](https://github.com/BurraAbhishek/VirtualElections/blob/main/src/db/config/tablesconfig.php). You should include this file before using the table class. The following examples show how to initiate a table in the database: (the variables used may differ from case to case)

```
$table_class = new Table();
$admin = $table_class->getAdminStatus();
$parties = $table_class->getPartyList();
$voter = $table_class->getVoterList();
$election = $table_class->getVotes();
```

For example, the prepared statement to select all entries from the parties table may look like this:

```
$party = $parties['table'];
$connection->prepare("SELECT * FROM $party");
```

Using prepared statements wherever possible helps in preventing SQL Injection attacks.

## Contributing to this application

- Set up your development environment.
- [Pick a GitHub issue to work on](https://github.com/BurraAbhishek/VirtualElections/issues). The [good first issue](https://github.com/BurraAbhishek/VirtualElections/issues?q=is%3Aissue+is%3Aopen+label%3A%22good+first+issue%22) tag might be useful.
- Fork this repository to create your own copy of this repository and work on it. When you're ready, submit a pull request to this repository.
