# Frequently Asked Questions

## Why is the GNU AGPL used instead of the Apache License?

(Answer by Burra Abhishek)

If you were following this repository for quite some time, you might be 
aware that this repository was formerly licensed under the 
[Apache License, Version 2.0](https://www.apache.org/licenses/LICENSE-2.0).

Even then, except for the same license condition, the other conditions of the 
GNU AGPL were satisfied both in letter and in spirit.

Although the Apache License was also permissive, it allowed proprietary 
forks. This website is specifically dedicated to online voting and elections.

This [article](https://www.fsf.org/blogs/community/dont-let-proprietary-digital-voting-disrupt-democracy) 
published by the [Free Software Foundation](https://www.fsf.org) explains the 
reasons behind using non-proprietary voting platforms. There are circumstances 
under which elections are safer when conducted online. For example, 
the COVID-19 pandemic.

This change is intended to adopt security by exposition, rather than security 
through obscurity, since the former will be more secure in the long run.

While there are many good reasons not to disclose or release the source code, 
it is actually better to do so in the initial stages. Any security vulnerabilities 
can be discovered and patched very early, thereby avoiding any exploits that 
might occur during the actual election.

Another benefit in releasing the source code of the SQL database is that 
the voters can check if the size constraints are reasonable or not. In this 
case, assume the size constraint of the user input to be half of what is 
mentioned in the SQL query of creating the tables. Disclosing the table 
structure may cause the application to be vulnerable to SQL Injection, but 
preventive measures, including but not limited to input validation and/or 
sanitization, parameterized queries and prepared statements should effectively 
render all such attempts futile. This is especially true since the server details 
are not required to be disclosed in any way.

Perhaps the biggest of all the benefits, is that the voters can check if the elections 
are rigged or fair. This is the biggest benefit of using the GNU AGPL license.
In the event the elections are rigged, that problem can be fixed by security 
researchers. The additional requirement of disclosing the source, even if the 
website is hosted on a network, and stating changes every time can help in 
producing evidence of any possible rigging or other disruption of the website.

The GNU Affero General Public License, however, does NOT require the 
administrators to disclose the data stored in the database or the details of the 
servers used. The administrators have full control on their servers.

Considering all this, the decision was made to switch from the 
Apache 2.0 License to the GNU Affero General Public License v3.0+. 

However, any copy of this software that contains a copy of the 
Apache License will continue to be licensed under the Apache License. 
This change affects only those copies which are licensed under the AGPL.

## Won't the contestants be able to determine whether they registered first or not?

(Answer by Burra Abhishek)

It is possible. However the increase in that possibility which arises out of the 
requirements of the GNU AGPL can be nullified.

Administrators have an access control feature. Closing the results section is 
the key.

As a good practice, at any time, it is recommended to keep only the following 
sections open at a time:
- Registration of voters and contestants (both can be open at a time)
- Voting
- Declaration of results

## One of the files discloses the administrator credentials! 

(Answer by Burra Abhishek)

These credentials are currently redundant, i.e. the password is never used 
anywhere in this application. However, when it is used, it will be changed 
and displayed in hashed form rather than the plaintext form used now.
