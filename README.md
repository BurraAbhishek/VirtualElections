# VirtualElections

<img src="https://github.com/BurraAbhishek/VirtualElections/blob/main/screenshots/index_page_darkmode.png" alt="Homepage" title="This site comes with a light and dark theme built-in by default, this screenshot shows the dark theme.">

<img src="https://github.com/BurraAbhishek/VirtualElections/blob/main/screenshots/main_menu_1_darkmode.png" alt="Main menu" title="This site comes with a light and dark theme built-in by default, this screenshot shows the dark theme.">

Forever free, adless and open-source voting platform to conduct elections remotely. 

This website is written in [PHP](https://www.php.net/). HTML is used for templating, [using CSS for styling](https://github.com/BurraAbhishek/VirtualElections/tree/main/src/public/css). JavaScript is used for client-side validations, [toggling between light and dark mode](https://github.com/BurraAbhishek/VirtualElections/blob/main/src/public/controllers/css.js) and [showing results](https://github.com/BurraAbhishek/VirtualElections/blob/main/src/vote_counting/results.php). An SQL database is used in this application. Connection to the database is handled using [PHP Data Objects](https://www.php.net/manual/en/book.pdo.php).

For the rewrite in Python (Django framework), see https://github.com/BurraAbhishek/VirtualElections_v2

## Development Environment
Please check the [wiki](https://github.com/burraabhishek/virtualelections/wiki) of this repository to get started.

## Vulnerability Tests
<ul>
  <li>
    SQL Injection
    <ul>
      <li> Status: Secured </li>
      <li> Testing tool used: <a href="https://sqlmap.org">sqlmap</a>, <a href="https://www.zaproxy.org/">OWASP ZAP</a> </li>
    </ul>
  </li>
    <li>
    XSS
    <ul>
      <li> Status: Secured </li>
      <li> Testing tool used: <a href="https://www.zaproxy.org/">OWASP ZAP</a> </li>
    </ul>
  </li>
    <li>
    Path Traversal
    <ul>
      <li> Status: Secured </li>
      <li> Testing tool used: <a href="https://www.zaproxy.org/">OWASP ZAP</a> </li>
    </ul>
  </li>
</ul>

In addition to this, it is recommended to use an identity verification method while conducting elections. There are several constraints to implementing an identity verification and authentication method by means of writing code:
- Not everyone has an email address.
- Not everyone has a registered mobile number.
- This site is designed be compatible and functional worldwide. Therefore, using only one kind of ID proof which is compatible in only one country is not feasible. However, a limit can be imposed on the kind of ID proof and website accessibility depending on the nature of the elections.
- People can submit fake/forged documents.
- Machine Learning algorithms are required to identify genuine documents with several methods of proving one's identity, take photographs of users during registration and verify with the photograph contained in the identity document.

NOTE: It is recommended to use HTTPS and encrypt all traffic while deploying this application for security reasons.

## LICENSE

This repository is dual-licensed under the [Apache License, Version 2.0](https://www.apache.org/licenses/LICENSE-2.0.txt) and the [GNU Affero General Public License 3](https://www.gnu.org/licenses/agpl-3.0.txt) or any later version at your choice.

### External Resources

Files | Author(s) | License
--- | --- | ---
[Font Awesome v4.7 in public/fa](https://github.com/BurraAbhishek/VirtualElections/tree/main/src/public/fa) | [The Font Awesome Team](https://github.com/FortAwesome/Font-Awesome#team) | [CC-BY 4.0, SIL OFL 1.1, MIT](https://github.com/FortAwesome/Font-Awesome/blob/master/LICENSE.txt)
Noto Sans in public/fonts | [Google](https://fonts.google.com/specimen/Noto+Sans) | [Apache License, Version 2.0](https://www.apache.org/licenses/LICENSE-2.0)
Roboto in public/fonts | [Christian Robertson](https://fonts.google.com/specimen/Roboto) | [Apache License, Version 2.0](https://www.apache.org/licenses/LICENSE-2.0)
